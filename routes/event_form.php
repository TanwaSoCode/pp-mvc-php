<?php
$conn = getConnection();
$event = [
    'event_id' => '', 'title' => '', 'description' => '', 
    'capacity' => '', 'start_date' => '', 'end_date' => ''
];
$images = [];

// ถ้ามีการส่ง id มา แปลว่าเป็นการ "แก้ไข"
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM event WHERE event_id = $id");
    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
        
        // ดึงรูปภาพทั้งหมดของกิจกรรมนี้
        $imgResult = $conn->query("SELECT * FROM event_images WHERE event_id = $id");
        $images = $imgResult->fetch_all(MYSQLI_ASSOC);
    }
}

renderView('event_form', ['title' => 'ฟอร์มกิจกรรม', 'event' => $event, 'images' => $images]);