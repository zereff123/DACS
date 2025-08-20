<h2>Danh sách câu hỏi</h2>
<a href="index.php?controller=question&action=create">➕ Thêm câu hỏi</a>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Nội dung</th>
        <th>Đáp án A</th>
        <th>Đáp án B</th>
        <th>Đáp án C</th>
        <th>Đáp án D</th>
        <th>Đúng</th>
        <th>Môn</th>
        <th>Khối</th>
        <th>Độ khó</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($questions as $q): ?>
    <tr>
        <td><?= $q['QuestionId'] ?></td>
        <td><?= htmlspecialchars($q['Content']) ?></td>
        <td><?= htmlspecialchars($q['OptionA']) ?></td>
        <td><?= htmlspecialchars($q['OptionB']) ?></td>
        <td><?= htmlspecialchars($q['OptionC']) ?></td>
        <td><?= htmlspecialchars($q['OptionD']) ?></td>
        <td><?= $q['CorrectAnswer'] ?></td>
        <td><?= htmlspecialchars($q['SubjectName']) ?></td>
        <td><?= $q['GradeLevel'] ?></td>
        <td><?= $q['DifficultyLevel'] ?></td>
        <td>
            <a href="index.php?controller=question&action=edit&id=<?= $q['QuestionId'] ?>">Sửa</a> |
            <a href="index.php?controller=question&action=delete&id=<?= $q['QuestionId'] ?>" 
                onclick="return confirm('Xóa câu hỏi này?')">Xóa</a>

        </td>
    </tr>
    <?php endforeach; ?>
</table>
<a class="btn" href="index.php?controller=admin&action=index">← Quay lại trang quản trị</a>
