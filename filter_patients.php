<?php
require 'db_connection.php'; // Database connection

header('Content-Type: application/json'); // Set the header to return JSON

$filters = json_decode(file_get_contents('php://input'), true); // Get the filters from the request body

$limit = isset($filters['limit']) ? (int)$filters['limit'] : 1; // Limit of records per page
$page = isset($filters['page']) ? (int)$filters['page'] : 1; // Current page
$skip = ($page - 1) * $limit; // Skip records

$db = new Database(); // Create a new instance of the Database class
$patients = $db->database->Patients; // Get the Patients collection

// Build the query dynamically
$query = []; // Initialize the query

if (!empty($filters['PatientId'])) { // Patient ID Filter is not empty
    $query['PatientId'] = (int)$filters['PatientId']; // Add the Patient ID to the query
}

// Age Range Filter
if (!empty($filters['AgeMin']) && !empty($filters['AgeMax'])) { // Age Range is not empty
    $query['Age'] = ['$gte' => intval($filters['AgeMin']), '$lte' => intval($filters['AgeMax'])]; // Add the Age Range to the query
}

// Gender Filter
if (!empty($filters['Gender'])) { // If gender is not empty
    $query['Gender'] = $filters['Gender']; // Add the gender to the query
}

// Medical Conditions
if ($filters['Diabetes']) { // If Diabetes is checked
    $query['Diabetes'] = true; // Add Diabetes to the query
}
if ($filters['Hipertension']) { // If Hipertension is checked
    $query['Hipertension'] = true; // Add Hipertension to the query
}
if ($filters['Alcoholism']) { // If Alcoholism is checked
    $query['Alcoholism'] = true; // Add Alcoholism to the query
}
if ($filters['Handcap']) { // If Handcap is checked
    $query['Handcap'] = true; // Add Handcap to the query
}

// Scholarship Filter
if ($filters['ScholarshipTrue'] && !$filters['ScholarshipFalse']) {  // If Scholarship is checked
    $query['Scholarship'] = true; // Add Scholarship to the query
} elseif (!$filters['ScholarshipTrue'] && $filters['ScholarshipFalse']) { // If Scholarship is not checked
    $query['Scholarship'] = false; // Add Scholarship to the query
}

// Neighbourhood Filter
if (!empty($filters['Neighbourhood'])) { // If Neighbourhood is not empty
    $query['Neighbourhood'] = $filters['Neighbourhood']; // Add Neighbourhood to the query
}

// Execute the query
$result = $patients->find($query, ['skip' => $skip, 'limit' => $limit])->toArray(); // Get the records based on the query and limit the records per page
$totalCount = $patients->countDocuments($query); // Get the total count of records based on the query

echo json_encode([ // Return the result as JSON
    'data' => $result, // Records
    'totalCount' => $totalCount, // Total count of records
    'currentPage' => $page, // Current page
    'limit' => $limit // Limit of records per page
]);


