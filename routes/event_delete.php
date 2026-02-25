<?php
if (isset($_GET['id'])) {
    $conn = getConnection();
    $event_id = intval($_GET['id']);
    
    // ลบข้อมูลในตาราง event (ตาราง event_images จะถูกลบตามอัตโนมัติด้วย ON DELETE CASCADE ที่คุณตั้งไว้)
    $conn->query("DELETE FROM event WHERE event_id = $event_id");
    
    // หมายเหตุ: ในระบบจริงควรมีโค้ดสำหรับเข้าไปลบไฟล์รูปภาพในโฟลเดอร์ uploads ด้วย (ใช้ฟังก์ชัน unlink)
}

header('Location: /events');
exit;