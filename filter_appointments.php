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

if (isset($filters['smsReceived']) && $filters['smsReceived'] !== '') {
    $query['SMS_received'] = filter_var($filters['smsReceived'], FILTER_VALIDATE_BOOLEAN);
}

// Execute the query with the limit
$result = $appointments->find($query, ['limit' => $limit])->toArray();

foreach ($result as &$appointment) {
    if (isset($appointment['ScheduledDay']) && is_object($appointment['ScheduledDay'])) {
        $appointment['ScheduledDay'] = $appointment['ScheduledDay']->toDateTime()->format('Y-m-d');
    }
    if (isset($appointment['AppointmentDay']) && is_object($appointment['AppointmentDay'])) {
        $appointment['AppointmentDay'] = $appointment['AppointmentDay']->toDateTime()->format('Y-m-d');
    }
}

echo json_encode($result);
