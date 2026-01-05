<?php
include '../includes/session.php';
include '../includes/db.php';
include '../includes/header.php';

// Handle quiz deletion 
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']); 
    // Delete all questions belonging to this quiz 
    $stmtQ = $conn->prepare("DELETE FROM questions WHERE quiz_id = ?"); 
    $stmtQ->bind_param("i", $deleteId); $stmtQ->execute(); 
    // Delete the quiz itself 
    $stmtQuiz = $conn->prepare("DELETE FROM quizzes WHERE id = ?"); 
    $stmtQuiz->bind_param("i", $deleteId); 
    $stmtQuiz->execute(); 
    // Redirect back to qlist.php without delete_id in URL 
    header("Location: qlist.php"); 
    exit; 
}

// Fetch quizzes with course names
$result = $conn->query("
    SELECT q.id, q.title, q.description, c.name AS course_name
    FROM quizzes q
    JOIN courses c ON q.course_id = c.id
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Quiz List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="H">
    <h1>Quiz Management</h1>

    <button class="btn" onclick="openModal()">Create Quiz</button>

    <div class="quiz-list">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="quiz-item">
                <div>
                    <strong><?php echo $row['title']; ?></strong><br>
                    <em><?php echo $row['course_name']; ?></em><br>
                    <?php if (!empty($row['description'])) echo $row['description']; ?>
                </div>
                <div>
                    <a href="quiz.php?quiz_id=<?php echo $row['id']; ?>" class="btn O">Open</a>
                    <a href="quizEdit.php?quiz_id=<?php echo $row['id']; ?>" class="btn E">Edit</a>
                    
                    <a href="qlist.php?delete_id=<?php echo $row['id']; ?>" 
                        class="btn D"
                        onclick="return confirm('Are you sure you want to delete this quiz and all its questions?');">
                        Delete
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

<!-- Modal for Create Quiz -->
<div id="quizModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Create Quiz</h2>
    <form id="createQuizForm" method="get" action="quizEdit.php">
        <label>Quiz Title:</label>
        <input type="text" name="title" required><br><br>

        <label>Description:</label>
        <textarea name="description"></textarea><br><br>

        <button type="submit" class="btn">Continue</button>
    </form>
  </div>
</div>
</div>

    <script>
        function openModal() {
            document.getElementById("quizModal").style.display = "flex";
        }
        function closeModal() {
            document.getElementById("quizModal").style.display = "none";
        }
    </script>

</body>
</html>
