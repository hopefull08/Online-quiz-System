<?php
include '../includes/db.php';
include '../public/header.php';

if (!isset($_GET['course_id'])) {
    die("No course selected.");
}

$course_id = intval($_GET['course_id']);

// Fetch course name
$course_result = $conn->query("SELECT name FROM courses WHERE id=$course_id");
$course = $course_result->fetch_assoc();

// Fetch quizzes directly linked to this course
$quiz_result = $conn->query("
    SELECT q.id, q.title, q.description, COUNT(ques.id) AS question_count
    FROM quizzes q
    LEFT JOIN questions ques ON q.id = ques.quiz_id
    WHERE q.course_id = $course_id
    GROUP BY q.id
");
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $course['name']; ?> - Quizzes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1><?php echo $course['name']; ?> - Quizzes</h1>

    <div class="quiz-list">
        <?php if ($quiz_result->num_rows > 0): ?>
            <?php while($row = $quiz_result->fetch_assoc()): ?>
                <div class="quiz-item">
                    <div class="quiz-info">
                        <h2><?php echo $row['title']; ?></h2>
                        <?php if (!empty($row['description'])): ?>
                            <p><?php echo $row['description']; ?></p>
                        <?php endif; ?>
                        <p><strong>Questions:</strong> <?php echo $row['question_count']; ?></p>
                    </div>
                    <a href="quiz.php?quiz_id=<?php echo $row['id']; ?>" class="start-btn">Start</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No quizzes available for this course.</p>
        <?php endif; ?>
    </div>
</body>
</html>
