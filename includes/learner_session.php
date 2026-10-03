<?php
if (!is_learner_logged_in()) {
    redirect('/index.php');
}

$database = new Database();
$conn = $database->getConnection();

$learnerId = (int) $_SESSION['learner_id'];
$learnerToken = $_SESSION['learner_token'];

$stmt = $conn->prepare('SELECT id, nickname, avatar, current_level, stars, coins, badges_count, achievements_count FROM learners WHERE id = ? AND learner_token = ? LIMIT 1');
$stmt->bind_param('is', $learnerId, $learnerToken);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    session_unset();
    session_destroy();
    redirect('/index.php');
}

$learner = $result->fetch_assoc();
$stmt->close();

$progressStmt = $conn->prepare('SELECT * FROM learner_progress WHERE learner_id = ? ORDER BY updated_at DESC LIMIT 1');
$progressStmt->bind_param('i', $learnerId);
$progressStmt->execute();
$progressResult = $progressStmt->get_result();
$progress = $progressResult->num_rows > 0 ? $progressResult->fetch_assoc() : [
    'progress_percent' => 0,
    'lessons_completed' => 0,
    'activities_completed' => 0,
    'words_learned' => 0,
    'quiz_score_total' => 0,
];
$progressStmt->close();
