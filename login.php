<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        
        // Semak password hash atau teks biasa (123456)
        if (password_verify($password, $user['password']) || $password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = strtolower(trim($user['role']));
            $_SESSION['fullname'] = $user['fullname'];
            
            // Hantar ke halaman mengikut role
            if ($_SESSION['role'] === 'admin') {
                header("Location: admin.php");
            } elseif ($_SESSION['role'] === 'courier') {
                header("Location: courier.php");
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }
    $message = "E-mel atau kata laluan tidak sah!";
}

include 'header.php';
?>

<div class="form-box">
    <h2>Log Masuk AsraGO</h2>
    <?php if ($message): ?>
        <p style="color: var(--danger); margin-bottom: 1rem;"><?= $message; ?></p>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label>E-mel</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>Kata Laluan</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn" style="width: 100%;">Log Masuk</button>
    </form>
</div>

<?php include 'footer.php'; ?>