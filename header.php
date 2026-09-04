<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AsraGO - Beli Barang Asrama</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>
<body>
    <header>
        <div class="nav-container">
            <a href="index.php" class="logo">Asra<span>GO</span></a>
            <nav>
                <a href="index.php">Kategori & Barang</a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if ($_SESSION['role'] == 'student'): ?>
                        <a href="cart.php">Troli</a>
                        <a href="order_status.php">Status Pesanan</a>
                    <?php elseif ($_SESSION['role'] == 'admin'): ?>
                        <a href="admin.php">Dashboard Admin</a>
                    <?php elseif ($_SESSION['role'] == 'courier'): ?>
                        <a href="courier.php">Dashboard Courier</a>
                    <?php endif; ?>
                    <a href="logout.php">Log Keluar</a>
                <?php else: ?>
                    <a href="login.php">Log Masuk</a>
                    <a href="register.php">Daftar</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <div class="container">