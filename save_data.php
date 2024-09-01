<?php
header('Content-Type: application/json');

$filename = 'target_date.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save the new date to the file
    $newDate = $_POST['targetDate'] ?? null;
    if ($newDate) {
        file_put_contents($filename, $newDate);
        echo json_encode(['status' => 'success', 'message' => 'Date saved successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No date provided']);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Read the date from the file
    if (file_exists($filename)) {
        $date = file_get_contents($filename);
        echo json_encode(['status' => 'success', 'date' => $date]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Date file not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
