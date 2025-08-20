<h2>Chi tiết bài làm</h2>

<p>Điểm số: <?= htmlspecialchars($score ?? 0) ?>%</p>
<p>Ngày làm bài: <?= htmlspecialchars($quizResult['CreatedAt'] ?? '') ?></p>

<?php foreach ($details as $index => $d): ?>
    <div style="margin-bottom:20px;">
        <b>Câu <?= $index + 1 ?>:</b> <?= htmlspecialchars($d['Content']) ?><br>
        <?php foreach (['A','B','C','D'] as $optKey): ?>
            <?php
                $style = '';
                if ($optKey === $d['UserAnswer']) {
                    $style = $d['IsCorrect'] ? 'color:green;font-weight:bold;' : 'color:red;font-weight:bold;';
                } elseif ($optKey === $d['CorrectAnswer']) {
                    $style = !$d['IsCorrect'] ? 'color:green;' : '';
                }
            ?>
            <span style="<?= $style ?>"><?= $optKey ?>. <?= htmlspecialchars($d['Option'.$optKey]) ?></span><br>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<a href="index.php?controller=quiz&action=history">🔙 Quay lại lịch sử làm bài</a>
