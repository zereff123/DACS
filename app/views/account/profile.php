<h2>Hồ sơ cá nhân</h2>

<?php if (!empty($errors)): ?>
<article class="contrast">
  <ul><?php foreach ($errors as $e) echo "<li>$e</li>"; ?></ul>
</article>
<?php endif; ?>

<?php if (!empty($success)): ?>
<article class="contrast">
  <p><?php echo $success; ?></p>
</article>
<?php endif; ?>

<?php $me = SessionHelper::get('user'); ?>
<article>
  <header>
    <strong><?php echo htmlspecialchars($me['Username']); ?></strong>
    <small>Role: <?php echo htmlspecialchars($me['Role']); ?></small>
  </header>

  <form method="post">
    <label>Email
      <input type="email" name="email" value="<?php echo htmlspecialchars($me['Email']); ?>" required>
    </label>
    <div class="grid">
      <label>Lớp (GradeLevel)
        <input type="number" name="gradeLevel" min="1" max="12" value="<?php echo (int)$me['GradeLevel']; ?>" required>
      </label>
      <label>Trình độ hiện tại
        <select name="currentLevel">
          <?php
            $levels = ['Yếu','TB','Giỏi'];
            foreach ($levels as $lv) {
              $sel = ($lv === $me['CurrentLevel']) ? 'selected' : '';
              echo "<option value='$lv' $sel>$lv</option>";
            }
          ?>
        </select>
      </label>
    </div>
    <label>Đổi mật khẩu (để trống nếu không đổi)
      <input type="password" name="newPassword" placeholder="Mật khẩu mới">
    </label>
    <button type="submit">Lưu thay đổi</button>
    <a class="secondary" href="index.php?controller=account&action=logout">Đăng xuất</a>
  </form>
</article>
