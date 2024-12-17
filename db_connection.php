<?php
require 'vendor/autoload.php'; // include Composer's autoloader

use MongoDB\Client; // Import the MongoDB Client class

class Database // Create a Database class to handle database connections. Used in most other files
{
    public $database; // Create a public variable to store the database connection

    public function __construct() // Create a constructor method to connect to the database
    {
        $uri = "mongodb+srv://su042002:r0m2ZGaYscBSPW9r@cluster0.wkif8.mongodb.net/"; // MongoDB connection URI
        $client = new Client($uri); // Create a new MongoDB client
        $this->database = $client->Courswork1; // Select the database to use
    }

    public function getTotalPatients() // Method to get the total number of patients in the database
    {
        $patients = $this->database->Patients; // Select the Patients collection
        return $patients->countDocuments(); // Return the total number of documents in the collection
    }
    public function getTotalAppointments() // Method to get the total number of appointments in the database
    {
        $appointments = $this->database->Appointments; // Select the Appointments collection
        return $appointments->countDocuments(); // Return the total number of documents in the collection
    }

    public function getTotalNeighbourhoods() // Method to get the total number of neighbourhoods in the database
    {
        $patients = $this->database->Patients;

        $result = $patients->aggregate([ // Use aggregation to group by Neighbourhood and count the number of groups
            [
                '$group' => [
                    '_id' => '$Neighbourhood' // Group by Neighbourhood field
                ]
            ],
            [
                '$count' => 'TotalNeighbourhoods' // Count the number of groups
            ]
        ]);

        $totalNeighbourhoods = $result->toArray(); // Convert the result to an array
        return isset($totalNeighbourhoods[0]['TotalNeighbourhoods']) ? $totalNeighbourhoods[0]['TotalNeighbourhoods'] : 0; // Return the total number of neighbourhoods
    }

    public function getTotalMales() // Method to get the total number of males
    {
        $patients = $this->database->Patients; // Select the Patients collection

        return $patients->countDocuments(['Gender' => 'M']); // Return the total number of documents where condition M is met
    }

    public function getTotalFemales() // Method to get the total number of Females
    {
        $patients = $this->database->Patients; // Select the Patients collection

        return $patients->countDocuments(['Gender' => 'F']); // Return the total number of documents where condition F is met
    }

    public function getTotalNoShows() { // Method to get the total number of no-shows
        $appointments = $this->database->Appointments; // Select the Appointments collection
        return $appointments->countDocuments(['Showed_up' => false]); // Return the total number of documents where condition Showed_up is false
    }

    public function getTotalShows() {
        $appointments = $this->database->Appointments; // Select the Appointments collection
        return $appointments->countDocuments(['Showed_up' => true]); // Return the total number of documents where condition Showed_up is true
    }

    public function getTop5NoShowsByNeighbourhood() {
        $appointments = $this->database->Appointments; // Select the Appointments collection

        $pipeline = [ // Create an aggregation pipeline to group by Neighbourhood and count the number of no-shows
            [
                '$match' => ['Showed_up' => false] // Match documents where Showed_up is false
            ],
            [
                '$group' => [
                    '_id' => '$Patient.Neighbourhood', // Group by Neighbourhood field
                    'NoShows' => ['$sum' => 1] // Count the number of no-shows
                ]
            ],
            [
                '$sort' => ['NoShows' => -1] // Sort by NoShows count descending
            ],
            [
                '$limit' => 5 // Limit to top 5 results for the overview page
            ]
        ];

        $result = $appointments->aggregate($pipeline); // Execute the aggregation pipeline
        return iterator_to_array($result); // Convert the result to an array
    }

    public function getTotalPatientsWithConditions() { // Method to get the total number of patients with conditions
        $patients = $this->database->Patients; // Select the Patients collection

        $pipeline = [ // Create an aggregation pipeline to get all conditions that patients have
            [
                '$group' => [ // Group by null to get the total count
                    '_id' => null,
                    'totalDiabetes' => ['$sum' => ['$cond' => [['$eq' => ['$Diabetes', true]], 1, 0]]], // Count the number of patients with Diabetes
                    'totalHypertension' => ['$sum' => ['$cond' => [['$eq' => ['$Hipertension', true]], 1, 0]]], // Count the number of patients with Hypertension
                    'totalAlcoholism' => ['$sum' => ['$cond' => [['$eq' => ['$Alcoholism', true]], 1, 0]]], // Count the number of patients with Alcoholism
                    'totalHandicap' => ['$sum' => ['$cond' => [['$eq' => ['$Handcap', true]], 1, 0]]], // Count the number of patients with Handicap
                ]
            ]
        ];

        $result = $patients->aggregate($pipeline); // Execute the aggregation pipeline
        return iterator_to_array($result); // Convert the result to an array
    }

    public function getTotalPatientsWithAnyCondition() { // Method to get the total number of patients with at least one condition
        $patients = $this->database->Patients; // Select the Patients collection

        // Query to count patients with at least one condition
        $conditions = [ // Conditions to check for
            '$or' => [ // Check if any of the conditions are true
                ['Diabetes' => true],
                ['Hipertension' => true],
                ['Alcoholism' => true],
                ['Handcap' => true],
                ['Scholarship' => true]
            ]
        ];

        return $patients->countDocuments($conditions); // Return the total number of documents where the conditions are met
    }

    public function getAppointmentsOverMonths() { // Method to get the number of appointments over months
        $appointments = $this->database->Appointments; // Select the Appointments collection

        $pipeline = [ // Create an aggregation pipeline to group by month and count the number of appointments
            [
                '$group' => [ // Group by month
                    '_id' => [
                        '$dateToString' => ['format' => '%Y-%m', 'date' => '$AppointmentDay'] // Format the date to year-month
                    ],
                    'totalAppointments' => ['$sum' => 1] // Count the number of appointments
                ]
            ],
            [
                '$sort' => ['_id' => 1] // Sort by month
            ]
        ];

        $result = $appointments->aggregate($pipeline); // Execute the aggregation pipeline
        return iterator_to_array($result); // Convert the result to an array
    }

    public function getAppointmentsByAgeGroup() { // Method to get the number of appointments by age group
        $appointments = $this->database->Appointments; // Select the Appointments collection

        $pipeline = [
            [
                '$group' => [ // Group by age group
                    '_id' => [
                        '$switch' => [
                            'branches' => [
                                ['case' => ['$lt' => ['$Patient.Age', 18]], 'then' => 'Under 18'], // Check if age is under 18
                                ['case' => ['$and' => [['$gte' => ['$Patient.Age', 18]], ['$lte' => ['$Patient.Age', 30]]]], 'then' => '18-30'], // Check if age is between 18 and 30
                                ['case' => ['$and' => [['$gte' => ['$Patient.Age', 31]], ['$lte' => ['$Patient.Age', 50]]]], 'then' => '31-50'], // Check if age is between 31 and 50
                                ['case' => ['$gt' => ['$Patient.Age', 50]], 'then' => 'Over 50'] // Check if age is over 50
                            ],
                            'default' => 'Unknown' // Default to Unknown if age is not in any of the groups or there is odd value in the database
                        ]
                    ],
                    'totalAppointments' => ['$sum' => 1] // Count the number of appointments
                ]
            ],
            [
                '$sort' => ['_id' => 1] // Sort by age group
            ]
        ];

        $result = $appointments->aggregate($pipeline); // Execute the aggregation pipeline
        return iterator_to_array($result); // Convert the result to an array
    }

    public function getNoShowRatesByGender() { // Method to get the no-show rates by
        $appointments = $this->database->Appointments; // Select the Appointments collection

        $pipeline = [
            [
                '$group' => [
                    '_id' => '$Patient.Gender', // Group by patient gender
                    'TotalAppointments' => ['$sum' => 1],  // Count the total number of appointments
                    'MissedAppointments' => ['$sum' => ['$cond' => [['$eq' => ['$Showed_up', false]], 1, 0]]] // Count the number of missed appointments
                ]
            ],
            [
                '$project' => [ // Project
                    '_id' => 0, // Exclude the _id field
                    'Gender' => '$_id', // Rename _id
                    'NoShowRate' => [ // Calculate the no-show rate
                        '$round' => [['$multiply' => [['$divide' => ['$MissedAppointments', '$TotalAppointments']], 100]], 2]
                    ]
                ]
            ]
        ];

        $result = $appointments->aggregate($pipeline); // Execute the aggregation pipeline
        return iterator_to_array($result); // Convert the result to an array
    }

    public function getShowUpRatesBySMS() { // Method to get the show-up rates by SMS
        $appointments = $this->database->Appointments; // Select the Appointments collection

        $pipeline = [ // Aggregation pipeline
            [
                '$group' => [ // Group by SMS_received field
                    '_id' => '$SMS_received',
                    'TotalAppointments' => ['$sum' => 1], // Count the total number of appointments
                    'ShowedUpCount' => ['$sum' => ['$cond' => [['$eq' => ['$Showed_up', true]], 1, 0]]] // Count the number of showed up appointments if SMS_received is true
                ]
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'SMS_Received' => ['$cond' => [['$eq' => ['$_id', true]], 'Received SMS', 'Did Not Receive SMS']], // Rename the _id field
                    'ShowUpRate' => [ // Calculate the show-up rate
                        '$round' => [['$multiply' => [['$divide' => ['$ShowedUpCount', '$TotalAppointments']], 100]], 2]
                    ]
                ]
            ]
        ];

        $result = $appointments->aggregate($pipeline); // Execute the aggregation pipeline
        return iterator_to_array($result); // Convert the result to an array
    }

    public function getNoShowRatesByScholarship() { // Method to get the no-show rates by Scholarship
        $appointments = $this->database->Appointments; // Select the Appointments collection

        $pipeline = [
            [
                '$group' => [
                    '_id' => '$Patient.Scholarship', // Group by Scholarship field
                    'TotalAppointments' => ['$sum' => 1], // Count the total number of appointments
                    'MissedAppointments' => ['$sum' => ['$cond' => [['$eq' => ['$Showed_up', false]], 1, 0]]] // Count the number of missed appointments
                ]
            ],
            [
                '$project' => [
                    '_id' => 0, // Exclude the _id field
                    'Scholarship' => ['$cond' => [['$eq' => ['$_id', true]], 'With Scholarship', 'Without Scholarship']], // Rename the _id field
                    'NoShowRate' => [ // Calculate the no-show rate
                        '$round' => [['$multiply' => [['$divide' => ['$MissedAppointments', '$TotalAppointments']], 100]], 2]
                    ]
                ]
            ]
        ];

        $result = $appointments->aggregate($pipeline); // Execute the aggregation pipeline
        return iterator_to_array($result); // Convert the result to an array
    }

    public function getPatientById($patientId) { // Method to get a patient by ID
        $patients = $this->database->Patients; // Select the Patients collection

        $query = ['PatientId' => intval($patientId)]; // Create a query to find the patient by ID

        $result = $patients->findOne($query); // Find the patient by ID

        return $result ? $result : null; // Return the result if found, otherwise return null
    }

    public function getNeighbourhoods() { // Method to get all neighbourhoods
        $patients = $this->database->Patients; // Select the Patients collection

        // Use aggregation to get distinct neighbourhoods
        $pipeline = [ // Aggregation pipeline
            [
                '$group' => [
                    '_id' => null,
                    'neighbourhoods' => ['$addToSet' => '$Neighbourhood'] // Add all neighbourhoods to a set
                ]
            ],
            [
                '$unwind' => '$neighbourhoods' // Unwind the neighbourhoods array, separate each neighbourhood into its own document
            ],
            [
                '$sort' => ['neighbourhoods' => 1] // Sort alphabetically by neighbourhood
            ]
        ];

        $result = $patients->aggregate($pipeline); // Execute the aggregation pipeline
        $neighbourhoods = [];

        foreach ($result as $item) { // Loop through the result
            $neighbourhoods[] = $item['neighbourhoods']; // Add each neighbourhood to the neighbourhoods array
        }

        return $neighbourhoods; // Return the neighbourhoods array
    }

    public function getTop10NeighborhoodsByPopulation() { // Method to get the top 10 neighbourhoods by population
        $patients = $this->database->Patients; // Select the Patients collection

        $pipeline = [
            [
                '$group' => [
                    '_id' => '$Neighbourhood', // Group by Neighbourhood field
                    'PopulationCount' => ['$sum' => 1] // Count the number of patients in each group
                ]
            ],
            [
                '$sort' => ['PopulationCount' => -1] // Sort by population count descending
            ],
            [
                '$limit' => 10 // Limit to top 10 results
            ]
        ];

        $result = $patients->aggregate($pipeline); // Execute the aggregation pipeline
        return iterator_to_array($result); // Convert the result to an array
    }

    public function getTopShowRates() { // Method to get the top 5 neighbourhoods with the highest show rates
        $appointments = $this->database->Appointments; // Select the Appointments collection

        $pipeline = [ // Aggregation pipeline
            [
                '$group' => [
                    '_id' => '$Patient.Neighbourhood', // Group by Neighbourhood field
                    'TotalAppointments' => ['$sum' => 1], // Count the total number of appointments
                    'ShowedUpCount' => [ // Count the number of showed up appointments
                        '$sum' => ['$cond' => [['$eq' => ['$Showed_up', true]], 1, 0]]
                    ]
                ]
            ],
            [
                '$project' => [
                    'Neighbourhood' => '$_id', // Rename the _id field
                    'TotalAppointments' => 1, // Include the TotalAppointments field
                    'ShowedUpCount' => 1, // Include the ShowedUpCount field
                    'ShowRate' => [ // Calculate the show rate
                        '$round' => [['$multiply' => [['$divide' => ['$ShowedUpCount', '$TotalAppointments']], 100]], 2]
                    ]
                ]
            ],
            [
                '$sort' => ['ShowRate' => -1] // Sort by show rate descending
            ],
            [
                '$limit' => 5 // Limit to top 5 results
            ]
        ];

        return $appointments->aggregate($pipeline)->toArray(); // Execute the aggregation pipeline and convert the result to an array
    }

    public function getScholarshipCounts() { // Method to get the number of patients with and without scholarships
        $patients = $this->database->Patients; // Select the Patients collection

        $pipeline = [ // Aggregation pipeline
            [
                '$group' => [
                    '_id' => '$Scholarship', // Group by Scholarship field (true/false)
                    'Count' => ['$sum' => 1] // Count the number of patients in each group
                ]
            ],
            [
                '$project' => [
                    '_id' => 0,
                    'ScholarshipStatus' => [ // Rename the _id field
                        '$cond' => [
                            ['$eq' => ['$_id', true]], 'With Scholarship', 'Without Scholarship ' // equivalent to if else statement
                        ]
                    ],
                    'Count' => 1 // Include the Count field
                ]
            ]
        ];

        return $patients->aggregate($pipeline)->toArray(); // Execute the aggregation pipeline and convert the result to an array
    }

}

?>