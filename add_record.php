<?php
session_start();
include('config/db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $student_name = $_POST['student_name']; // student_name from form
    $violation = $_POST['violation'];
    $advice = $_POST['advice'];
    $counselor_id = $_SESSION['user_id']; // counselor_id from session
    $session_date = date('Y-m-d'); // current date

    // Check if the student exists in the students table
    $stmt = $pdo->prepare('SELECT id FROM students WHERE student_name = ?');
    $stmt->execute([$student_name]);

    if ($stmt->rowCount() == 0) {
        // If student does not exist, insert the student into the students table
        $stmt = $pdo->prepare('INSERT INTO students (student_name) VALUES (?)');
        $stmt->execute([$student_name]);

        // Fetch the student ID after insertion
        $student_id = $pdo->lastInsertId();
    } else {
        // If student exists, fetch the student ID
        $student_id = $stmt->fetchColumn();
    }

    // Check if counselor_id exists in the users table
    $stmt = $pdo->prepare('SELECT id FROM users WHERE id = ?');
    $stmt->execute([$counselor_id]);
    if ($stmt->rowCount() == 0) {
        echo '<p>Error: Invalid counselor ID.</p>';
        exit;
    }

    // Insert into guidance_records table
    $stmt = $pdo->prepare('INSERT INTO guidance_records (student_id, counselor_id, session_date, violation, advice) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$student_id, $counselor_id, $session_date, $violation, $advice]);

    // Success message
    echo '<p>Guidance record added successfully.</p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Guidance Record</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* Styling for the Major and Minor Offense Buttons */
        .advice-button {
            padding: 15px 30px;
            border-radius: 5px;
            font-size: 16px;
            margin: 10px 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .major-offense {
            background-color: #f44336; /* Red for Major Offense */
            color: white;
        }
        .minor-offense {
            background-color: #ffa500; /* Orange for Minor Offense */
            color: white;
        }
        .selected {
            opacity: 0.8;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Guidance Record</h2>
        <form method="POST" action="">
            <label for="student_name">Student Name:</label>
            <input type="text" id="student_name" name="student_name" required placeholder="Enter student name" />

            <label for="violation">Violation:</label>
            <select id="violation" name="violation" required>
                <option value="Late">Late</option>
                <option value="Cheating">Cheating</option>
                <option value="Disrespect">Disrespect</option>
                <option value="Fighting">Fighting</option>
                <option value="Vandalism">Vandalism</option>
                <!-- Add more violations here -->
            </select>

            <label for="advice">Advice:</label>
            <div>
                <button type="button" class="advice-button major-offense" id="major-offense" onclick="setAdvice('Major Offense')">Major Offense</button>
                <button type="button" class="advice-button minor-offense" id="minor-offense" onclick="setAdvice('Minor Offense')">Minor Offense</button>
            </div>
            <input type="hidden" id="advice" name="advice" />

            <button type="submit">Add Record</button>
        </form>
    </div>

    <script>
        // Function to handle the selection of advice
        function setAdvice(adviceType) {
            // Set hidden input value to the selected advice type
            document.getElementById('advice').value = adviceType;

            // Add 'selected' class to visually indicate the selection
            document.getElementById('major-offense').classList.remove('selected');
            document.getElementById('minor-offense').classList.remove('selected');

            if (adviceType === 'Major Offense') {
                document.getElementById('major-offense').classList.add('selected');
            } else if (adviceType === 'Minor Offense') {
                document.getElementById('minor-offense').classList.add('selected');
            }
        }
    </script>
</body>
</html>
