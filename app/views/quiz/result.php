<h2>Kết quả bài thi</h2>
<p>Điểm số: <?= $_SESSION['last_score'] ?? 0 ?>%</p>

<?php foreach ($details as $index => $d): 
    $options = $d['Options'] ?? [
        'A' => $d['OptionA'] ?? '',
        'B' => $d['OptionB'] ?? '',
        'C' => $d['OptionC'] ?? '',
        'D' => $d['OptionD'] ?? ''
    ];
    $userAnswerContent = trim((string)($d['UserAnswerContent'] ?? ''));
    $correctAnswerContent = trim((string)($d['CorrectAnswerContent'] ?? ''));
?>
    <div style="margin-bottom:20px;">
        <b>Câu <?= $index + 1 ?>:</b> <?= htmlspecialchars($d['Content'] ?? '') ?><br>
        <?php foreach ($options as $optKey => $optVal): 
            $optValStr = trim((string)$optVal);
            $style = '';
            if ($optValStr === $userAnswerContent) {
                $style = $userAnswerContent === $correctAnswerContent ? 'color:green;font-weight:bold;' : 'color:red;font-weight:bold;';
            } elseif ($optValStr === $correctAnswerContent) {
                $style = $userAnswerContent !== $correctAnswerContent ? 'color:green;' : '';
            }
        ?>
            <span style="<?= $style ?>"><?= $optKey ?>. <?= htmlspecialchars($optVal) ?></span><br>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<a href="index.php?controller=quiz&action=start">🔄 Làm lại đề khác</a>