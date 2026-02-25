<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($data['title']) ?></title>
    <style>
        table { width: 100%; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>รายชื่อผู้ลงทะเบียนกิจกรรม: <span style="color: blue;"><?= htmlspecialchars($data['event_title']) ?></span></h1>
    
    <a href="/events"><button type="button">กลับหน้ารายการกิจกรรม</button></a>
    <hr>

    <?php if (empty($data['participants'])): ?>
        <p style="color: red;">ยังไม่มีผู้ลงทะเบียนเข้าร่วมกิจกรรมนี้</p>
    <?php else: ?>
        <p>จำนวนผู้ลงทะเบียนทั้งหมด: <strong><?= count($data['participants']) ?></strong> คน</p>
        
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อ - นามสกุล</th>
                    <th>อีเมล</th>
                    <th>เพศ</th>
                    <th>จังหวัด</th>
                    <th>สถานะปัจจุบัน</th>
                    <th>จัดการสถานะ (Admin)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['participants'] as $index => $user): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['gender']) ?></td>
                    <td><?= htmlspecialchars($user['province']) ?></td>
                    <td>
                        <?php 
                            if ($user['status'] == 'Confirmed') echo '<span style="color: green;">อนุมัติแล้ว</span>';
                            elseif ($user['status'] == 'Rejected') echo '<span style="color: red;">ถูกปฏิเสธ</span>';
                            else echo '<span style="color: orange;">รอตรวจสอบ</span>';
                        ?>
                    </td>
                    <td>
                        <?php if ($user['status'] != 'Confirmed'): ?>
                            <a href="/update_status?reg_id=<?= $user['registration_id'] ?>&status=Confirmed&event_id=<?= $data['event_id'] ?>" onclick="return confirm('ยืนยันการอนุมัติบุคคลนี้?');">
                                <button style="background-color: green; color: white; cursor: pointer;">อนุมัติ</button>
                            </a>
                        <?php endif; ?>

                        <?php if ($user['status'] != 'Rejected'): ?>
                            <a href="/update_status?reg_id=<?= $user['registration_id'] ?>&status=Rejected&event_id=<?= $data['event_id'] ?>" onclick="return confirm('ยืนยันการปฏิเสธบุคคลนี้?');">
                                <button style="background-color: red; color: white; cursor: pointer;">ปฏิเสธ</button>
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