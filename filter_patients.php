<?php
require 'db_connection.php';

header('Content-Type: application/json');

$filters = json_decode(file_get_contents('php://input'), true);

$db = new Database();
$patients = $db->database->Patients;

// Build the query dynamically
$query = [];

// Age Range Filter
if (!empty($filters['AgeMin']) && !empty($filters['AgeMax'])) {
    $query['Age'] = ['$gte' => intval($filters['AgeMin']), '$lte' => intval($filters['AgeMax'])];
}

// Gender Filter
if (!empty($filters['Gender'])) {
    $query['Gender'] = $filters['Gender'];
}

// Medical Conditions
if ($filters['Diabetes']) {
    $query['Diabetes'] = true;
}
if ($filters['Hypertension']) {
    $query['Hipertension'] = true;
}
if ($filters['Alcoholism']) {
    $query['Alcoholism'] = true;
}
if ($filters['Handcap']) {
    $query['Handcap'] = true;
}

// Scholarship Filter
if ($filters['ScholarshipTrue'] && !$filters['ScholarshipFalse']) {
    $query['Scholarship'] = true;
} elseif (!$filters['ScholarshipTrue'] && $filters['ScholarshipFalse']) {
    $query['Scholarship'] = false;
}

// Neighbourhood Filter
if (!empty($filters['Neighbourhood'])) {
    $query['Neighbourhood'] = $filters['Neighbourhood'];
}

// Execute the query
$result = $patients->find($query);
echo json_encode(iterator_to_array($result));

