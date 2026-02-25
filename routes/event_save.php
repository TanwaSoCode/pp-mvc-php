<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /events');
    exit;
}

$conn = getConnection();
$event_id = $_POST['event_id'] ?? '';
$user_id = 1; // จำลอง user_id ไปก่อน
$title = $conn->real_escape_string($_POST['title']);
$description = $conn->real_escape_string($_POST['description']);
$capacity = intval($_POST['capacity']);
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

if (empty($event_id)) {
    // โหมดสร้างใหม่ (INSERT)
    $sql = "INSERT INTO event (user_id, title, description, capacity, start_date, end_date) 
            VALUES ($user_id, '$title', '$description', $capacity, '$start_date', '$end_date')";
    $conn->query($sql);
    $event_id = $conn->insert_id; // ดึง ID ล่าสุดที่เพิ่งสร้าง
} else {
    // โหมดแก้ไข (UPDATE)
    $event_id = intval($event_id);
    $sql = "UPDATE event SET 
            title = '$title', description = '$description', capacity = $capacity, 
            start_date = '$start_date', end_date = '$end_date' 
            WHERE event_id = $event_id";
    $conn->query($sql);
}

// ---- จัดการอัปโหลดรูปภาพ (หลายรูป) ----
if (!empty($_FILES['images']['name'][0])) {
    $uploadDir = __DIR__ . '/../public/uploads/';
    
    foreach ($_FILES['images']['name'] as $key => $filename) {
        $tmp_name = $_FILES['images']['tmp_name'][$key];
        $error = $_FILES['images']['error'][$key];
        
        if ($error === UPLOAD_ERR_OK) {
            // ตั้งชื่อไฟล์ใหม่กันซ้ำ
            $newFilename = time() . '_' . uniqid() . '_' . basename($filename);
            $targetPath = $uploadDir . $newFilename;
            
            if (move_uploaded_file($tmp_name, $targetPath)) {
                // บันทึกชื่อไฟล์ลงตาราง event_images
                $imgSql = "INSERT INTO event_images (event_id, image_url) VALUES ($event_id, '$newFilename')";
                $conn->query($imgSql);
            }
        }
    }
}

header('Location: /events');
exit;