<?php
include 'db.php';
include 'header.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $dorm_no = $_POST['dorm_no'];
    $role = 'student';

    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    
    if ($check->get_result()->num_rows > 0) {
        $message = "E-mel ini telah berdaftar!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, password, role, dorm_no) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $fullname, $email, $password, $role, $dorm_no);
        if ($stmt->execute()) {
            echo "<script>alert('Pendaftaran berjaya!'); window.location='login.php';</script>";
            exit;
        }
    }
}
?>

<div class="form-box">
    <h2>Daftar Akaun Pelajar</h2>
    <?php if ($message): ?><p style="color: var(--danger);"><?= $message; ?></p><?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label>Nama Penuh</label>
            <input type="text" name="fullname" required>
        </div>
        <div class="form-group">
            <label>E-mel</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>No Dorm (Contoh: B-3-12)</label>
            <input type="text" name="dorm_no" required>
        </div>
        <div class="form-group">
            <label>Kata Laluan</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn" style="width:100%;">Daftar</button>
    </form>
</div>

<?php include 'footer.php'; ?>