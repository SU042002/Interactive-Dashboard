<?php
require 'db_connection.php';

header('Content-Type: application/json');

$filters = json_decode(file_get_contents('php://input'), true);

$limit = isset($filters['limit']) ? (int)$filters['limit'] : 1;
$page = isset($filters['page']) ? (int)$filters['page'] : 1;
$skip = ($page - 1) * $limit;

$db = new Database();
$appointments = $db->database->Appointments;

// Build the query dynamically
$query = [];

if (!empty($filters['PatientId'])) {
    $query['Patient.PatientId'] = (int)$filters['PatientId'];
}

if (!empty($filters['AppointmentID'])) {
    $query['AppointmentID'] = (int)$filters['AppointmentID'];
}

if (!empty($filters['dateRange'])) {
    list($startDate, $endDate) = explode(' - ', $filters['dateRange']);
    $startDate = new MongoDB\BSON\UTCDateTime(strtotime($startDate) * 1000);
    $endDate = new MongoDB\BSON\UTCDateTime(strtotime($endDate) * 1000);
    $query['AppointmentDay'] = ['$gte' => $startDate, '$lte' => $endDate];
}

// Showed Up Filter
if (isset($filters['ShowedUp']) && $filters['ShowedUp'] !== '') {
    $query['Showed_up'] = filter_var($filters['ShowedUp'], FILTER_VALIDATE_BOOLEAN);
}

if (isset($filters['smsReceived']) && $filters['smsReceived'] !== '') {
    $query['SMS_received'] = filter_var($filters['smsReceived'], FILTER_VALIDATE_BOOLEAN);
}

if (isset($filters['dateMin']) && isset($filters['dateMax']) && $filters['dateMin'] !== '' && $filters['dateMax'] !== '') {
    $query['DateDiff'] = ['$gte' => intval($filters['dateMin']), '$lte' => intval($filters['dateMax'])];
}

// Execute the query with the limit
$result = $appointments->find($query, ['limit' => $limit])->toArray();

// Execute the query
$result = $appointments->find($query, ['skip' => $skip, 'limit' => $limit])->toArray();
$totalCount = $appointments->countDocuments($query);

foreach ($result as &$appointment) {
    if (isset($appointment['ScheduledDay']) && is_object($appointment['ScheduledDay'])) {
        $appointment['ScheduledDay'] = $appointment['ScheduledDay']->toDateTime()->format('Y-m-d');
    }
    if (isset($appointment['AppointmentDay']) && is_object($appointment['AppointmentDay'])) {
        $appointment['AppointmentDay'] = $appointment['AppointmentDay']->toDateTime()->format('Y-m-d');
    }
}

echo json_encode([
    'data' => $result,
    'totalCount' => $totalCount,
    'currentPage' => $page,
    'limit' => $limit
]);
