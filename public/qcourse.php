<?php
include '../includes/db.php'; // connect to database
include '../public/header.php';

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
    <h1>Choose the course to take quiz</h1>

    <div class="course-list">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="course-item">
                    <span class="course-name"><?php echo $row['name']; ?></span>
                    <a href="qlist.php?course_id=<?php echo $row['id']; ?>" class="start-btn">Start</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No courses available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
