<!DOCTYPE html>
<html>

<head>
    <title><?= $data['title'] ?></title>
</head>

<body>
    <h1><?= empty($data['event']['event_id']) ? 'สร้างกิจกรรมใหม่' : 'แก้ไขกิจกรรม' ?></h1>

    <form action="/event_save" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="event_id" value="<?= $data['event']['event_id'] ?>">

        <label>ชื่องาน:</label><br>
        <input type="text" name="title" value="<?= htmlspecialchars($data['event']['title']) ?>" required><br><br>

        <label>รายละเอียด:</label><br>
        <textarea name="description" rows="4" cols="50"><?= htmlspecialchars($data['event']['description']) ?></textarea><br><br>

        <label>จำนวนที่รับ (Capacity):</label><br>
        <input type="number" name="capacity" value="<?= $data['event']['capacity'] ?>"><br><br>

        <label>วันที่เริ่ม (Start Date):</label><br>
        <input type="datetime-local" name="start_date" value="<?= $data['event']['start_date'] ?>" required><br><br>

        <label>วันที่สิ้นสุด (End Date):</label><br>
        <input type="datetime-local" name="end_date" value="<?= $data['event']['end_date'] ?>" required><br><br>

        <label>อัปโหลดรูปภาพ (เลือกได้หลายรูป):</label><br>
        <input type="file" name="images[]" multiple accept="image/*"><br><br>

        <?php if (!empty($data['images'])): ?>
            <p>รูปภาพปัจจุบัน:</p>
            <?php foreach ($data['images'] as $img): ?>
                <img src="/uploads/<?= $img['image_url'] ?>" width="100">
            <?php endforeach; ?>
            <br><br>
        <?php endif; ?>

        <button type="submit">บันทึกข้อมูล</button>
        <a href="/events">ยกเลิก</a>
    </form>
</body>

</html>