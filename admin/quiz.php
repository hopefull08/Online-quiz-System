<?php
include '../includes/session.php';
include '../includes/db.php';
include '../includes/header.php';

$quizId = $_GET['quiz_id'] ?? null;

if (!$quizId) {
    die("No quiz selected.");
}

// Fetch quiz info
$quizRes = $conn->query("SELECT * FROM quizzes WHERE id=$quizId");
$quiz = $quizRes->fetch_assoc();

// Fetch questions for this quiz
$questions = [];
$questionsRes = $conn->query("SELECT * FROM questions WHERE quiz_id=$quizId");
while ($row = $questionsRes->fetch_assoc()) {
    $questions[] = $row;
}

// Handle deletion if delete_id is passed
if (isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();

    // Redirect back to quiz.php without delete_id in URL
    header("Location: quiz.php?quiz_id=" . $quizId);
    exit;
}
$result = $conn->query("
    SELECT q.id, q.title, q.description, c.name AS course_name
    FROM quizzes q
    JOIN courses c ON q.course_id = c.id
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Quiz Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <a href="qlist.php" class="btn">⬅ Back</a>
    <div class="H">
    <div class="quiz-container">
        <h1><?php echo htmlspecialchars($quiz['title']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($quiz['description'])); ?></p>
         <a href="quizEdit.php?quiz_id=<?php echo $quiz['id']; ?>" class="btn">Edit Quiz</a>

        <h3>Questions</h3>
        <?php if (empty($questions)): ?>
            <p>No questions found for this quiz.</p>
        <?php else: ?>
            <?php foreach ($questions as $index => $q): ?>
    <div class="question-block">
        <p><strong><?php echo $index + 1; ?>.</strong> 
           <?php echo htmlspecialchars($q['question_text']); ?></p>
           <div class="side">
        <p><strong>A:</strong> <?php echo htmlspecialchars($q['option_a']); ?></p>
        <p><strong>B:</strong> <?php echo htmlspecialchars($q['option_b']); ?></p>
        <p><strong>C:</strong> <?php echo htmlspecialchars($q['option_c']); ?></p>
        <p><strong>Correct Answer:</strong> <?php echo htmlspecialchars($q['correct_answer']); ?></p>
           </div>
        <!-- Delete button -->
        <a class="btn D" 
           href="quiz.php?quiz_id=<?php echo $quizId; ?>&delete_id=<?php echo $q['id']; ?>" 
           onclick="return confirm('Are you sure you want to delete this question?');">
           Delete
        </a>
    </div>
<?php endforeach; ?>

        <?php endif; ?>
    </div>
    </div>
</body>
</html>
