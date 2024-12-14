<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientId = isset($_POST['PatientID']) ? $_POST['PatientID'] : null;

    if ($patientId) {
        $db = new Database();
        $patient = $db->getPatientById($patientId);

        if ($patient) {
            echo json_encode($patient);
        } else {
            echo json_encode(['error' => 'Patient not found']);
        }
    } else {
        echo json_encode(['error' => 'Invalid PatientID']);
    }
}