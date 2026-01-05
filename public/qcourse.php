<?php
include '../includes/db.php'; // connect to database
include '../includes/header.php';

// Fetch all courses
$result = $conn->query("SELECT * FROM courses");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Courses</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>This is the quiz list - Choose the course you want to take</h1>

    <div class="list">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <?php
                    // Count quizzes for this course
                    $course_id = $row['id'];
                    $quiz_count_result = $conn->query("SELECT COUNT(*) AS total FROM quizzes WHERE course_id = $course_id");
                    $quiz_count = $quiz_count_result->fetch_assoc()['total'];
                ?>
                <div class="item">
                    <div class="nam">
                    <span class="name"><?php echo $row['name']; ?></span>
                    <span class="quiz-count">Number of quizzes: <?php echo $quiz_count; ?></span>
                    </div>
                    <a href="qlist.php?course_id=<?php echo $row['id']; ?>" class="button">Start</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No courses available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
