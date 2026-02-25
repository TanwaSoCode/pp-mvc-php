<?php
$conn = getConnection();
$user_id = 1; // จำลอง User ที่ล็อกอินอยู่

// รับค่าจากฟอร์มค้นหา
$search_title = $_GET['search_title'] ?? '';
$search_start_date = $_GET['search_start_date'] ?? '';
$search_end_date = $_GET['search_end_date'] ?? '';

$where_clauses = ["1=1"]; 

if (!empty($search_title)) {
    $safe_title = $conn->real_escape_string($search_title);
    $where_clauses[] = "title LIKE '%$safe_title%'";
}
if (!empty($search_start_date)) {
    $safe_start = $conn->real_escape_string($search_start_date);
    $where_clauses[] = "start_date >= '$safe_start 00:00:00'";
}
if (!empty($search_end_date)) {
    $safe_end = $conn->real_escape_string($search_end_date);
    $where_clauses[] = "start_date <= '$safe_end 23:59:59'";
}

$where_sql = implode(" AND ", $where_clauses);

// ดึงข้อมูลกิจกรรม
$sql = "SELECT * FROM event WHERE $where_sql ORDER BY start_date DESC";
$result = $conn->query($sql);
$events = [];

if ($result && $result->num_rows > 0) {
    $events = $result->fetch_all(MYSQLI_ASSOC);
}

foreach ($events as $key => $event) {
    $event_id = $event['event_id'];
    
    // 1. ดึงรูปภาพหน้าปก
    $imgSql = "SELECT image_url FROM event_images WHERE event_id = $event_id LIMIT 1";
    $imgResult = $conn->query($imgSql);
    $events[$key]['cover_image'] = $imgResult->fetch_assoc()['image_url'] ?? null;

    // 2. นับจำนวนคนที่ลงทะเบียนไปแล้ว
    $countSql = "SELECT COUNT(*) as total_registered FROM registration WHERE event_id = $event_id";
    $events[$key]['total_registered'] = $conn->query($countSql)->fetch_assoc()['total_registered'];

    // 3. เช็คว่า User คนนี้ลงทะเบียนงานนี้ไปหรือยัง
    $checkRegSql = "SELECT * FROM registration WHERE event_id = $event_id AND user_id = $user_id";
    $events[$key]['is_registered'] = ($conn->query($checkRegSql)->num_rows > 0);
}

renderView('events', [
    'title' => 'จัดการและค้นหากิจกรรม', 
    'events' => $events,
    'search' => [
        'title' => $search_title,
        'start_date' => $search_start_date,
        'end_date' => $search_end_date
    ]
]);