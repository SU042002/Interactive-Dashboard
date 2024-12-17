<?php
require 'db_connection.php'; // Database connection

header('Content-Type: application/json'); // Set the header to return JSON file

$filters = json_decode(file_get_contents('php://input'), true); // Get the filters from the request body from fetch request in the frontend

$limit = isset($filters['limit']) ? (int)$filters['limit'] : 1; // Set the limit of the results to return
$page = isset($filters['page']) ? (int)$filters['page'] : 1; // Set the page number, default is 1 if nothing is set
$skip = ($page - 1) * $limit; // Calculate the number of results to skip based on the page number and the limit

$db = new Database(); // Create a new instance of the Database class
$appointments = $db->database->Appointments; // Get the Appointments collection from the database

// Build the query dynamically
$query = []; // Initialize the query array

if (!empty($filters['PatientId'])) { // Check if the PatientId filter is set
    $query['Patient.PatientId'] = (int)$filters['PatientId']; // Add the PatientId filter to the query
}

if (!empty($filters['AppointmentID'])) { // Check if the AppointmentID filter is set
    $query['AppointmentID'] = (int)$filters['AppointmentID']; // Add the AppointmentID filter to the query
}

if (!empty($filters['dateRange'])) { // Check if the dateRange filter is set
    list($startDate, $endDate) = explode(' - ', $filters['dateRange']); // Split the dateRange into start and end date
    $startDate = new MongoDB\BSON\UTCDateTime(strtotime($startDate) * 1000); // Convert the start date to UTCDateTime
    $endDate = new MongoDB\BSON\UTCDateTime(strtotime($endDate) * 1000); // Convert the end date to UTCDateTime
    $query['AppointmentDay'] = ['$gte' => $startDate, '$lte' => $endDate]; // Add the dateRange filter to the query
}

// Showed Up Filter
if (isset($filters['ShowedUp']) && $filters['ShowedUp'] !== '') { // Check if the ShowedUp filter is set
    $query['Showed_up'] = filter_var($filters['ShowedUp'], FILTER_VALIDATE_BOOLEAN); // Add the ShowedUp filter to the query
}

if (isset($filters['smsReceived']) && $filters['smsReceived'] !== '') { // Check if the SMS Received filter is set and not empty
    $query['SMS_received'] = filter_var($filters['smsReceived'], FILTER_VALIDATE_BOOLEAN); // If the SMS Received filter is set, add it to the query
}

if (isset($filters['dateMin']) && isset($filters['dateMax']) && $filters['dateMin'] !== '' && $filters['dateMax'] !== '') { // Check if the dateMin and dateMax filters are set and not empty
    $query['DateDiff'] = ['$gte' => intval($filters['dateMin']), '$lte' => intval($filters['dateMax'])]; // Add the dateMin and dateMax filters to the query
}

// Execute the query with the limit
$result = $appointments->find($query, ['limit' => $limit])->toArray(); // Find the appointments based on the query and limit

// Execute the query
$result = $appointments->find($query, ['skip' => $skip, 'limit' => $limit])->toArray(); // Find the appointments based on the query, skip, and limit
$totalCount = $appointments->countDocuments($query); // Get the total number of appointments based on the query

foreach ($result as &$appointment) { // Loop through the appointments and format the dates
    if (isset($appointment['ScheduledDay']) && is_object($appointment['ScheduledDay'])) { // Check if the ScheduledDay is set and is an object
        $appointment['ScheduledDay'] = $appointment['ScheduledDay']->toDateTime()->format('Y-m-d'); // Format the ScheduledDay to Y-m-d
    }
    if (isset($appointment['AppointmentDay']) && is_object($appointment['AppointmentDay'])) { // Check if the AppointmentDay is set and is an object
        $appointment['AppointmentDay'] = $appointment['AppointmentDay']->toDateTime()->format('Y-m-d'); // Format the AppointmentDay to Y-m-d
    }
}

echo json_encode([ // Return the results as JSON
    'data' => $result, // Return the data
    'totalCount' => $totalCount, // Return the total count
    'currentPage' => $page, // Return the current page
    'limit' => $limit // Return the limit
]);
