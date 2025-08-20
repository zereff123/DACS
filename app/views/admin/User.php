
<?php
$me = SessionHelper::get('user');
$users //là mảng dữ liệu user lấy từ controller

?>
<h2>Danh sách tài khoản</h2>
<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Lớp</th>
            <th>Trình độ</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users) && is_array($users)): ?>       
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?php echo htmlspecialchars($u['Username']); ?></td>
                    <td><?php echo htmlspecialchars($u['Email']); ?></td>
                    <td><?php echo htmlspecialchars($u['Role']); ?></td>
                    <td><?php echo htmlspecialchars($u['GradeLevel']); ?></td>
                    <td><?php echo htmlspecialchars($u['CurrentLevel']); ?></td>
                    <td>
                        <a href="index.php?controller=admin&action=edit&id=<?php echo $u['UserId']; ?>">Sửa</a>
                        <a href="index.php?controller=admin&action=delete&id=<?php echo $u['UserId']; ?>" onclick="return confirm('Xóa tài khoản này?');">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">Không có dữ liệu người dùng.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<div class="btn-container">
        <a class="btn" href="index.php?controller=admin&action=index">← Quay lại trang quản trị</a>
</div>
