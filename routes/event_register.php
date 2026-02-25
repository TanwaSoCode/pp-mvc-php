<?php
if (!isset($_GET['id'])) {
    header('Location: /events');
    exit;
}

$conn = getConnection();
$event_id = intval($_GET['id']);
$user_id = 1; // จำลอง User ที่ล็อกอิน

// เช็คข้อมูลกิจกรรมว่ามีอยู่จริงและรับคนได้เท่าไหร่
$eventResult = $conn->query("SELECT capacity FROM event WHERE event_id = $event_id");
if ($eventResult->num_rows > 0) {
    $event = $eventResult->fetch_assoc();
    $capacity = $event['capacity'];

    // นับจำนวนคนที่ลงทะเบียนแล้ว
    $countResult = $conn->query("SELECT COUNT(*) as total FROM registration WHERE event_id = $event_id");
    $total_registered = $countResult->fetch_assoc()['total'];

    // เช็คว่า User คนนี้ลงทะเบียนหรือยัง
    $checkUser = $conn->query("SELECT * FROM registration WHERE event_id = $event_id AND user_id = $user_id");

    // ถ้ายังไม่เคยลงทะเบียน และ ที่นั่งยังไม่เต็ม ให้บันทึกข้อมูล
    if ($checkUser->num_rows == 0 && $total_registered < $capacity) {
        $sql = "INSERT INTO registration (user_id, event_id, status, is_attended) 
                VALUES ($user_id, $event_id, 'Pending', FALSE)";
        $conn->query($sql);
    }
}

// กลับไปหน้าแรก
header('Location: /events');
exit;