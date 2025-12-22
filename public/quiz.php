<?php
include '../includes/db.php';

if (!isset($_GET['quiz_id'])) {
    die("No quiz selected.");
}

$quiz_id = intval($_GET['quiz_id']);

// Fetch quiz info
$quiz_result = $conn->query("SELECT title FROM quizzes WHERE id=$quiz_id");
$quiz = $quiz_result->fetch_assoc();

// Fetch questions
$question_result = $conn->query("SELECT * FROM questions WHERE quiz_id=$quiz_id");
...
