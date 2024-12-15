<?php
require 'db_connection.php';

header('Content-Type: application/json');

$filters = json_decode(file_get_contents('php://input'), true);

$limit = isset($filters['limit']) ? (int)$filters['limit'] : 10;

$db = new Database();
$appointments = $db->database->Appointments;

// Build the query dynamically
$query = [];

// Showed Up Filter
if (isset($filters['ShowedUp']) && $filters['ShowedUp'] !== '') {
    $query['Showed_up'] = filter_var($filters['ShowedUp'], FILTER_VALIDATE_BOOLEAN);
}

// Execute the query with the limit
$result = $appointments->find($query, ['limit' => $limit])->toArray();

echo json_encode($result);
