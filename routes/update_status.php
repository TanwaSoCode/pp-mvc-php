<?php
// ตรวจสอบว่าส่งพารามิเตอร์มาครบหรือไม่
if (!isset($_GET['reg_id']) || !isset($_GET['status']) || !isset($_GET['event_id'])) {
    header('Location: /events');
    exit;
}

$conn = getConnection();
$reg_id = intval($_GET['reg_id']);
$event_id = intval($_GET['event_id']);
$status = $conn->real_escape_string($_GET['status']);

// ตรวจสอบความถูกต้องของสถานะ ป้องกันการแก้ URL มั่วๆ
$allowed_status = ['Confirmed', 'Rejected', 'Pending'];
if (in_array($status, $allowed_status)) {
    // อัปเดตสถานะในตาราง registration
    $sql = "UPDATE registration SET status = '$status' WHERE registration_id = $reg_id";
    $conn->query($sql);
}

// อัปเดตเสร็จให้เด้งกลับมาที่หน้าดูรายชื่อของกิจกรรมเดิม
header("Location: /event_participants?id=" . $event_id);
exit;
