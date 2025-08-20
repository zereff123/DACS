<h2>Lịch sử làm bài</h2>

<?php if (empty($results)): ?>
    <p>Bạn chưa làm bài nào.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>#</th>
            <th>Môn học</th>
            <th>Điểm</th>
            <th>Ngày làm</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($results as $index => $r): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($r['SubjectName']) ?></td>
                <td><?= $r['Score'] ?>%</td>
                <td><?= $r['StartTime'] ?></td>
                <td>
                    <a href="index.php?controller=quiz&action=viewResult&quizResultId=<?= $r['QuizResultId'] ?>">Xem chi tiết</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<a href="index.php?controller=quiz&action=start">🔄 Làm đề khác</a>
