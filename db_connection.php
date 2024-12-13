<?php
require 'vendor/autoload.php';

use MongoDB\Client;

class Database
{
    private $database;

    public function __construct()
    {
        $uri = "mongodb+srv://su042002:r0m2ZGaYscBSPW9r@cluster0.wkif8.mongodb.net/"; // Update with your connection details if needed
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
                '$match' => ['Showed_up' => false] // Filter for no-shows
            ],
            [
                '$group' => [
                    '_id' => '$Patient.Neighbourhood', // Group by neighbourhood
                    'NoShows' => ['$sum' => 1]    // Count the number of no-shows
                ]
            ],
            [
                '$sort' => ['NoShows' => -1] // Sort by no-show count in descending order
            ],
            [
                '$limit' => 5 // Limit the results to the top 5
            ]
        ];

        $result = $appointments->aggregate($pipeline);
        return iterator_to_array($result);
    }

}
?>