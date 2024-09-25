<?php
// Define the file to store submissions
$file = 'submissions.json';

// Read submissions from the JSON file
if (file_exists($file)) {
    $submissions = json_decode(file_get_contents($file), true);
} else {
    $submissions = [];
}

// Sort submissions by submission time (ascending)
usort($submissions, function($a, $b) {
    return $a['submission_time'] <=> $b['submission_time'];
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Fastest Finger First</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .admin-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h2>Submissions</h2>
        <table>
            <tr>
                <th>Participant Name</th>
                <th>Order Selected</th>
                <th>Submission Time</th>
            </tr>
            <?php
            if (count($submissions) > 0) {
                // Output data of each row
                foreach ($submissions as $submission) {
                    $submissionTime = round((($submission['submission_time'] - $_SERVER['REQUEST_TIME_FLOAT']) / 1000), 2); // Convert time to seconds
                    echo "<tr>
                            <td>" . htmlspecialchars($submission['participant']) . "</td>
                            <td>" . htmlspecialchars($submission['order_selected']) . "</td>
                            <td>" . htmlspecialchars($submissionTime . 's') . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>No submissions yet</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
