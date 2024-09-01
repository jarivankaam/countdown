<?php
header('Content-Type: application/json');

$filename = 'target_date.txt';

if (file_exists($filename)) {
    $date = file_get_contents($filename);
    echo json_encode(['status' => 'success', 'date' => $date]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Date file not found']);
}
?>
