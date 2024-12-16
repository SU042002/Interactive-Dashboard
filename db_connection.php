<?php
require 'vendor/autoload.php';

use MongoDB\Client;

class Database
{
    public $database;

    public function __construct()
    {
        $uri = "mongodb+srv://su042002:r0m2ZGaYscBSPW9r@cluster0.wkif8.mongodb.net/";
        $client = new Client($uri);
        $this->database = $client->Courswork1;
    }

    public function getTotalPatients()
    {
        $patients = $this->database->Patients;
        return $patients->countDocuments();
    }

    public function getTotalAppointments()
    {
        $appointments = $this->database->Appointments;
        return $appointments->countDocuments();
    }

    public function getTotalNeighbourhoods()
    {
        $patients = $this->database->Patients;

        $result = $patients->aggregate([
            [
                '$group' => [
                    '_id' => '$Neighbourhood'
                ]
            ],
            [
                '$count' => 'TotalNeighbourhoods'
            ]
        ]);

        $totalNeighbourhoods = $result->toArray();
        return isset($totalNeighbourhoods[0]['TotalNeighbourhoods']) ? $totalNeighbourhoods[0]['TotalNeighbourhoods'] : 0;
    }

    public function getTotalMales()
    {
        $patients = $this->database->Patients;

        return $patients->countDocuments(['Gender' => 'M']);
    }

    public function getTotalFemales()
    {
        $patients = $this->database->Patients;

        return $patients->countDocuments(['Gender' => 'F']);
    }

    public function getTotalNoShows() {
        $appointments = $this->database->Appointments;
        return $appointments->countDocuments(['Showed_up' => false]);
    }

    public function getTotalShows() {
        $appointments = $this->database->Appointments;
        return $appointments->countDocuments(['Showed_up' => true]);
    }

    public function getTop5NoShowsByNeighbourhood() {
        $appointments = $this->database->Appointments;

        $pipeline = [
            [
                '$match' => ['Showed_up' => false]
            ],
            [
                '$group' => [
                    '_id' => '$Patient.Neighbourhood',
                    'NoShows' => ['$sum' => 1]
                ]
            ],
            [
                '$sort' => ['NoShows' => -1]
            ],
            [
                '$limit' => 5
            ]
        ];

        $result = $appointments->aggregate($pipeline);
        return iterator_to_array($result);
    }

    public function getTotalPatientsWithConditions() {
        $patients = $this->database->Patients;

        $pipeline = [
            [
                '$group' => [
                    '_id' => null,
                    'totalDiabetes' => ['$sum' => ['$cond' => [['$eq' => ['$Diabetes', true]], 1, 0]]],
                    'totalHypertension' => ['$sum' => ['$cond' => [['$eq' => ['$Hipertension', true]], 1, 0]]],
                    'totalAlcoholism' => ['$sum' => ['$cond' => [['$eq' => ['$Alcoholism', true]], 1, 0]]],
                    'totalHandicap' => ['$sum' => ['$cond' => [['$eq' => ['$Handcap', true]], 1, 0]]],
                ]
            ]
        ];

        $result = $patients->aggregate($pipeline);
        return iterator_to_array($result);
    }

    public function getTotalPatientsWithAnyCondition() {
        $patients = $this->database->Patients;

        // Query to count patients with at least one condition
        $conditions = [
            '$or' => [
                ['Diabetes' => true],
                ['Hipertension' => true],
                ['Alcoholism' => true],
                ['Handcap' => true],
                ['Scholarship' => true]
            ]
        ];

        return $patients->countDocuments($conditions);
    }

    public function getAppointmentsOverMonths() {
        $appointments = $this->database->Appointments;

        $pipeline = [
            [
                '$group' => [
                    '_id' => [
                        '$dateToString' => ['format' => '%Y-%m', 'date' => '$AppointmentDay']
                    ],
                    'totalAppointments' => ['$sum' => 1]
                ]
            ],
            [
                '$sort' => ['_id' => 1] // Sort by month
            ]
        ];

        $result = $appointments->aggregate($pipeline);
        return iterator_to_array($result);
    }

    public function getAppointmentsByAgeGroup() {
        $appointments = $this->database->Appointments;

        $pipeline = [
            [
                '$group' => [
                    '_id' => [
                        '$switch' => [
                            'branches' => [
                                ['case' => ['$lt' => ['$Patient.Age', 18]], 'then' => 'Under 18'],
                                ['case' => ['$and' => [['$gte' => ['$Patient.Age', 18]], ['$lte' => ['$Patient.Age', 30]]]], 'then' => '18-30'],
                                ['case' => ['$and' => [['$gte' => ['$Patient.Age', 31]], ['$lte' => ['$Patient.Age', 50]]]], 'then' => '31-50'],
                                ['case' => ['$gt' => ['$Patient.Age', 50]], 'then' => 'Over 50']
                            ],
                            'default' => 'Unknown'
                        ]
                    ],
                    'totalAppointments' => ['$sum' => 1]
                ]
            ],
            [
                '$sort' => ['_id' => 1]
            ]
        ];

        $result = $appointments->aggregate($pipeline);
        return iterator_to_array($result);
    }

    public function getNoShowRatesByGender() {
        $appointments = $this->database->Appointments;

        $pipeline = [
            [
                '$group' => [
                    '_id' => '$Patient.Gender',
                    'TotalAppointments' => ['$sum' => 1],
                    'MissedAppointments' => ['$sum' => ['$cond' => [['$eq' => ['$Showed_up', false]], 1, 0]]]
                ]
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'Gender' => '$_id',
                    'NoShowRate' => [
                        '$round' => [['$multiply' => [['$divide' => ['$MissedAppointments', '$TotalAppointments']], 100]], 2]
                    ]
                ]
            ]
        ];

        $result = $appointments->aggregate($pipeline);
        return iterator_to_array($result);
    }

    public function getShowUpRatesBySMS() {
        $appointments = $this->database->Appointments;

        $pipeline = [
            [
                '$group' => [
                    '_id' => '$SMS_received',
                    'TotalAppointments' => ['$sum' => 1],
                    'ShowedUpCount' => ['$sum' => ['$cond' => [['$eq' => ['$Showed_up', true]], 1, 0]]]
                ]
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'SMS_Received' => ['$cond' => [['$eq' => ['$_id', true]], 'Received SMS', 'Did Not Receive SMS']],
                    'ShowUpRate' => [
                        '$round' => [['$multiply' => [['$divide' => ['$ShowedUpCount', '$TotalAppointments']], 100]], 2]
                    ]
                ]
            ]
        ];

        $result = $appointments->aggregate($pipeline);
        return iterator_to_array($result);
    }

    public function getNoShowRatesByScholarship() {
        $appointments = $this->database->Appointments;

        $pipeline = [
            [
                '$group' => [
                    '_id' => '$Patient.Scholarship',
                    'TotalAppointments' => ['$sum' => 1],
                    'MissedAppointments' => ['$sum' => ['$cond' => [['$eq' => ['$Showed_up', false]], 1, 0]]]
                ]
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'Scholarship' => ['$cond' => [['$eq' => ['$_id', true]], 'With Scholarship', 'Without Scholarship']],
                    'NoShowRate' => [
                        '$round' => [['$multiply' => [['$divide' => ['$MissedAppointments', '$TotalAppointments']], 100]], 2]
                    ]
                ]
            ]
        ];

        $result = $appointments->aggregate($pipeline);
        return iterator_to_array($result);
    }

    public function getPatientById($patientId) {
        $patients = $this->database->Patients;

        // Query the database for the specific PatientID
        $query = ['PatientId' => intval($patientId)];

        // Fetch the first matching document
        $result = $patients->findOne($query);

        return $result ? $result : null;
    }

    public function getNeighbourhoods() {
        $patients = $this->database->Patients;

        // Use aggregation to get distinct neighbourhoods
        $pipeline = [
            [
                '$group' => [
                    '_id' => null,
                    'neighbourhoods' => ['$addToSet' => '$Neighbourhood']
                ]
            ],
            [
                '$unwind' => '$neighbourhoods'
            ],
            [
                '$sort' => ['neighbourhoods' => 1] // Sort alphabetically
            ]
        ];

        $result = $patients->aggregate($pipeline);
        $neighbourhoods = [];

        foreach ($result as $item) {
            $neighbourhoods[] = $item['neighbourhoods'];
        }

        return $neighbourhoods;
    }

    public function getTop10NeighborhoodsByPopulation() {
        $patients = $this->database->Patients;

        $pipeline = [
            [
                '$group' => [
                    '_id' => '$Neighbourhood',
                    'PopulationCount' => ['$sum' => 1]
                ]
            ],
            [
                '$sort' => ['PopulationCount' => -1] // Sort by population count descending
            ],
            [
                '$limit' => 10 // Limit to top 10 results
            ]
        ];

        $result = $patients->aggregate($pipeline);
        return iterator_to_array($result);
    }

    public function getTopShowRates() {
        $appointments = $this->database->Appointments;

        $pipeline = [
            [
                '$group' => [
                    '_id' => '$Patient.Neighbourhood',
                    'TotalAppointments' => ['$sum' => 1],
                    'ShowedUpCount' => [
                        '$sum' => ['$cond' => [['$eq' => ['$Showed_up', true]], 1, 0]]
                    ]
                ]
            ],
            [
                '$project' => [
                    'Neighbourhood' => '$_id',
                    'TotalAppointments' => 1,
                    'ShowedUpCount' => 1,
                    'ShowRate' => [
                        '$round' => [['$multiply' => [['$divide' => ['$ShowedUpCount', '$TotalAppointments']], 100]], 2]
                    ]
                ]
            ],
            [
                '$sort' => ['ShowRate' => -1]
            ],
            [
                '$limit' => 5
            ]
        ];

        return $appointments->aggregate($pipeline)->toArray();
    }

    public function getScholarshipCounts() {
        $patients = $this->database->Patients;

        $pipeline = [
            [
                '$group' => [
                    '_id' => '$Scholarship', // Group by Scholarship field (true/false)
                    'Count' => ['$sum' => 1] // Count the number of patients in each group
                ]
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'ScholarshipStatus' => [
                        '$cond' => [
                            ['$eq' => ['$_id', true]], 'With Scholarship', 'Without Scholarship'
                        ]
                    ],
                    'Count' => 1
                ]
            ]
        ];

        return $patients->aggregate($pipeline)->toArray();
    }



}



?>