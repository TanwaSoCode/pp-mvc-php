<!DOCTYPE html>
<html>

<head>
    <title><?= htmlspecialchars($data['title']) ?></title>
    <style>
        .search-box {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <h1>รายการกิจกรรม</h1>

    <div class="search-box">
        <form action="/events" method="GET">
            <label>ชื่อกิจกรรม:</label>
            <input type="text" name="search_title" value="<?= htmlspecialchars($data['search']['title']) ?>" placeholder="ค้นหาชื่องาน...">

            <label>ตั้งแต่วันที่:</label>
            <input type="date" name="search_start_date" value="<?= htmlspecialchars($data['search']['start_date']) ?>">

            <label>ถึงวันที่:</label>
            <input type="date" name="search_end_date" value="<?= htmlspecialchars($data['search']['end_date']) ?>">

            <button type="submit">ค้นหา</button>
            <a href="/events"><button type="button">ล้างการค้นหา</button></a>
        </form>
    </div>

    <a href="/event_form">สร้างกิจกรรมใหม่</a>
    <hr>

    <?php if (empty($data['events'])): ?>
        <p style="color: red;">ไม่พบกิจกรรมที่ตรงกับเงื่อนไขการค้นหา</p>
    <?php else: ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>รูปภาพ</th>
                    <th>ชื่องาน</th>
                    <th>จำนวนที่รับ</th>
                    <th>วันที่เริ่ม - สิ้นสุด</th>
                    <th>จัดการ (Admin)</th>
                    <th>ลงทะเบียน (User)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['events'] as $event): ?>
                    <tr>
                        <td>
                            <?php if ($event['cover_image']): ?>
                                <img src="/uploads/<?= $event['cover_image'] ?>" width="100">
                            <?php else: ?>
                                ไม่มีรูป
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($event['title']) ?></td>
                        <td><?= $event['total_registered'] ?> / <?= $event['capacity'] ?></td>
                        <td><?= $event['start_date'] ?> ถึง <?= $event['end_date'] ?></td>
                        <td>
                            <a href="/event_form?id=<?= $event['event_id'] ?>">แก้ไข</a> |
                            <a href="/event_delete?id=<?= $event['event_id'] ?>" onclick="return confirm('ยืนยันการลบ?');">ลบ</a> |
                            <a href="/event_participants?id=<?= $event['event_id'] ?>">ดูรายชื่อคนลงทะเบียน</a>
                        </td>

                        <td>
                            <?php if ($event['is_registered']): ?>
                                <button disabled style="background-color: green; color: white;">ลงทะเบียนแล้ว</button>
                            <?php elseif ($event['total_registered'] >= $event['capacity']): ?>
                                <button disabled style="background-color: red; color: white;">ที่นั่งเต็ม</button>
                            <?php else: ?>
                                <a href="/event_register?id=<?= $event['event_id'] ?>" onclick="return confirm('ยืนยันการลงทะเบียนเข้าร่วมกิจกรรมนี้?');">
                                    <button style="background-color: blue; color: white; cursor: pointer;">ลงทะเบียนเข้าร่วม</button>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>

</html>