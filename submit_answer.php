<?php
// Define the file to store submissions
$file = 'submissions.json';

// Get the POST data from the client
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['participant']) && !empty($data['order']) && isset($data['time'])) {
    // Prepare the submission data
    $submission = [
        'participant' => $data['participant'],      // Participant name
        'order_selected' => $data['order'],         // Selected order (e.g., "1,3,2,4")
        'submission_time' => microtime(true) * 1000 // Current time in milliseconds
    ];

    // Check if the file exists and read it
    if (file_exists($file)) {
        $submissions = json_decode(file_get_contents($file), true);
    } else {
        $submissions = [];
    }

    // Add the new submission
    $submissions[] = $submission;

    // Write the updated submissions back to the JSON file
    file_put_contents($file, json_encode($submissions));

    // Send a success response
    echo json_encode(['message' => 'Submission received successfully']);
} else {
    // Send an error response if required data is missing
    echo json_encode(['message' => 'Invalid submission data']);
}
?>
