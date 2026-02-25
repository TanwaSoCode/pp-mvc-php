<?php


$userData = [];
if (isset($_SESSION['user_id'])) {
    $conn = getConnection();
    $stmt = $conn->prepare('SELECT * FROM `user` WHERE user_id = ?');
    if (!$stmt) {
        error_log('home_get prepare failed: ' . $conn->error);
    } else {
        $stmt->bind_param('i', $_SESSION['user_id']);
        $stmt->execute();
        $userData = $stmt->get_result()->fetch_assoc() ?: [];
    }
}

renderView('main_get', ['userData' => $userData]);
