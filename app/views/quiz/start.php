<h2>Đề thi môn <?= htmlspecialchars($questions[0]['SubjectName'] ?? '') ?></h2>

<form method="POST" action="index.php?controller=quiz&action=submit">
    <!-- Thêm input ẩn quiz_id -->
    <input type="hidden" name="quiz_id" value="<?= $quizId ?? 0 ?>">

    <?php foreach ($questions as $index => $q): ?>
        <div style="margin-bottom:20px;">
            <b>Câu <?= $index + 1 ?>:</b> <?= htmlspecialchars($q['Content']) ?><br>
            <input type="radio" name="answers[<?= $q['QuestionId'] ?>]" value="A" required> A. <?= htmlspecialchars($q['OptionA']) ?><br>
            <input type="radio" name="answers[<?= $q['QuestionId'] ?>]" value="B"> B. <?= htmlspecialchars($q['OptionB']) ?><br>
            <input type="radio" name="answers[<?= $q['QuestionId'] ?>]" value="C"> C. <?= htmlspecialchars($q['OptionC']) ?><br>
            <input type="radio" name="answers[<?= $q['QuestionId'] ?>]" value="D"> D. <?= htmlspecialchars($q['OptionD']) ?><br>
        </div>
    <?php endforeach; ?>

    <button type="submit">Nộp bài</button>
</form>
