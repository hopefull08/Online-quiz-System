<?php
include '../includes/db.php';
include '../public/header.php';

if (!isset($_GET['quiz_id'])) {
    die("No quiz selected.");
}

$quiz_id = intval($_GET['quiz_id']);

// Fetch quiz info (include course_id so we can redirect later)
$quiz_result = $conn->query("SELECT id, title, course_id FROM quizzes WHERE id=$quiz_id");
$quiz = $quiz_result->fetch_assoc();


// Fetch questions for this quiz
$question_result = $conn->query("SELECT * FROM questions WHERE quiz_id=$quiz_id");
$questions = [];
while($q = $question_result->fetch_assoc()) {
    $questions[] = $q;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $quiz['title']; ?></title>
    <link rel="stylesheet" href="style.css">
    <script>
        // Pass PHP questions into JavaScript
        const questions = <?php echo json_encode($questions); ?>;
    </script>
    <script>
        const courseId = <?php echo json_encode($quiz['course_id']); ?>;
    </script>

    <script src="script.js"></script>
</head>
<body>
    <h1><?php echo $quiz['title']; ?></h1>

    <div id="quiz-container"></div>
    <button id="continueBtn" style="display:none;">Continue</button>

    <!-- Overlay for final score -->
    <div id="resultOverlay" class="overlay" style="display:none;">
        <div class="overlay-content">
            <h2>Quiz Finished!</h2>
            <p id="scoreText"></p>
            <button onclick="closeOverlay()">Close</button>
        </div>
    </div>
</body>
</html>
