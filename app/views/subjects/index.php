<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý môn học</title>
</head>
<body>
    <h1>Danh sách môn học</h1>
    <a href="/Subject/create">➕ Thêm môn học</a>
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Tên môn học</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($subjects as $subject): ?>
        <tr>
            <td><?= $subject['SubjectId'] ?></td>
            <td><?= htmlspecialchars($subject['SubjectName']) ?></td>
            <td>
                <a href="/Subject/edit/<?= $subject['SubjectId'] ?>">✏ Sửa</a> | 
                <a href="/Subject/delete/<?= $subject['SubjectId'] ?>" onclick="return confirm('Xóa môn học này?')">🗑 Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
