<h2>Chào mừng bạn đến với Quiz!</h2>

<form method="POST" action="index.php?controller=quiz&action=start">
    <label>Chọn môn học:</label>
    <select name="subject_id" required>
        <option value="">-- Chọn môn học --</option>
        <?php foreach ($subjects as $s): ?>
            <option value="<?= $s['SubjectId'] ?>">
                <?= htmlspecialchars($s['SubjectName']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <button type="submit">Bắt đầu làm bài</button>
</form>
