<?php
if (!isset($_GET['id'])) {
    header('Location: /events');
    exit;
}

$conn = getConnection();
$event_id = intval($_GET['id']);

// ดึงชื่อกิจกรรมมาเป็นหัวข้อหน้าเว็บ
$eventResult = $conn->query("SELECT title FROM event WHERE event_id = $event_id");
if ($eventResult->num_rows == 0) {
    header('Location: /events');
    exit;
}
$event = $eventResult->fetch_assoc();

// เพิ่ม r.registration_id ในคำสั่ง SELECT, รวมชื่อ-สกุลจากตาราง `user`
$sql = "SELECT r.registration_id,
               CONCAT(u.fname,' ',u.lname) AS full_name,
               u.email, u.gender, u.occupation, u.province,
               r.status, r.is_attended
        FROM registration r
        JOIN `user` u ON r.user_id = u.user_id
        WHERE r.event_id = $event_id
        ORDER BY r.registration_id ASC";
        
$result = $conn->query($sql);
$participants = [];
if ($result && $result->num_rows > 0) {
    $participants = $result->fetch_all(MYSQLI_ASSOC);
}

// ส่ง event_id ไปด้วย
renderView('event_participants', [
    'title' => 'รายชื่อผู้เข้าร่วม: ' . $event['title'],
    'event_title' => $event['title'],
    'event_id' => $event_id,
    'participants' => $participants
]);