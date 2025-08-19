<h1>Sửa môn học</h1>
<form method="POST" action="/Subject/update/<?= $subject['SubjectId'] ?>">
    <label>Tên môn học:</label>
    <input type="text" name="SubjectName" value="<?= htmlspecialchars($subject['SubjectName']) ?>" required>
    <button type="submit">Cập nhật</button>
</form>
<a href="/Subject/index">⬅ Quay lại</a>
