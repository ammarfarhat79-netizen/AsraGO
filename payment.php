<?php
include 'db.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit;
}

// Kira jumlah keseluruhan
$grand_total = 0;
foreach ($_SESSION['cart'] as $id => $quantity) {
    $id = intval($id);
    $res = $conn->query("SELECT price FROM products WHERE id = $id");
    if ($res && $res->num_rows > 0) {
        $product = $res->fetch_assoc();
        $grand_total += $product['price'] * $quantity;
    }
}

// Ambil maklumat dorm pelajar
$user_id = $_SESSION['user_id'];
$stmt_user = $conn->prepare("SELECT dorm_no FROM users WHERE id = ?");
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$dorm_no = $stmt_user->get_result()->fetch_assoc()['dorm_no'];

// Proses pengesahan pesanan & pembayaran
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_payment'])) {
    $payment_method = $_POST['payment_method'];
    $status = 'Sedang Diproses';

    $stmt_order = $conn->prepare("INSERT INTO orders (user_id, total_price, status, dorm_no) VALUES (?, ?, ?, ?)");
    $stmt_order->bind_param("idss", $user_id, $grand_total, $status, $dorm_no);
    
    if ($stmt_order->execute()) {
        $_SESSION['cart'] = array(); // Kosongkan troli
        echo "<script>alert('Pembayaran berjaya dibuat menggunakan [ " . $payment_method . " ]! Pesanan anda sedang diproses.'); window.location='order_status.php';</script>";
        exit;
    }
}
?>

<h2>Pilihan Kaedah Pembayaran</h2>

<div class="card" style="max-width: 600px; margin: 0 auto; padding: 2rem; text-align: center;">
    <h3>Ringkasan Pesanan</h3>
    <p>Penghantaran Ke Dorm: <strong style="color: var(--accent);"><?= htmlspecialchars($dorm_no); ?></strong></p>
    <p style="font-size: 1.2rem; margin: 0.5rem 0 1.5rem 0;">Jumlah Bayaran: <strong style="color: var(--accent);">RM <?= number_format($grand_total, 2); ?></strong></p>

    <hr style="margin: 1.5rem 0; border: 0; border-top: 1px solid rgba(255,255,255,0.1);">

    <form method="POST">
        <h4 style="margin-bottom: 1.2rem;">Sila Pilih Kaedah Bayaran:</h4>

        <!-- Pilihan Radio Button Sebelah-Menyebelah -->
        <div style="display: flex; gap: 10px; justify-content: center; margin-bottom: 1.5rem; flex-wrap: wrap;">
            
            <!-- Pilihan COD -->
            <label style="flex: 1; min-width: 200px; padding: 12px 15px; border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; background: rgba(255,255,255,0.05); font-size: 0.9rem;">
                <input type="radio" name="payment_method" value="Tunai Semasa Penghantaran (COD)" checked onclick="toggleQR(false)">
                <span>Tunai Semasa Penghantaran (COD)</span>
            </label>

            <!-- Pilihan QR -->
            <label style="flex: 1; min-width: 200px; padding: 12px 15px; border: 1px solid #007bff; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; background: rgba(0, 123, 255, 0.1); font-size: 0.9rem;">
                <input type="radio" name="payment_method" value="QR DuitNow / TNG eWallet" onclick="toggleQR(true)">
                <span>QR DuitNow / TNG eWallet</span>
            </label>

        </div>

        <!-- Paparan Kod QR -->
        <div id="qr_section" style="display: none; text-align: center; background: #ffffff; color: #000; padding: 1.5rem; border-radius: 8px; margin: 1rem 0;">
            <h4 style="margin-bottom: 0.5rem; color: #000;">Imbas Kod QR Untuk Bayar</h4>
            <p style="font-size: 0.9rem; margin-bottom: 1rem; color: #333;">Sila buat bayaran sebanyak <strong>RM <?= number_format($grand_total, 2); ?></strong></p>
            
            <img src="images/qr_code.png" alt="Kod QR Pembayaran" style="max-width: 200px; width: 100%; border: 1px solid #ccc; padding: 5px; border-radius: 4px;">
            
            <p style="font-size: 0.8rem; color: #666; margin-top: 0.8rem;">Selepas imbas dan selesaikan bayaran di aplikasi bank/eWallet anda, tekan butang di bawah untuk mengesahkan pesanan.</p>
        </div>

        <button type="submit" name="confirm_payment" class="btn" style="width: 100%; margin-top: 1rem; background-color: #ff9800; border: none; font-weight: bold;">Bayar & Hantar Pesanan</button>
    </form>
</div>

<script>
function toggleQR(show) {
    const qrSection = document.getElementById('qr_section');
    if (show) {
        qrSection.style.display = 'block';
    } else {
        qrSection.style.display = 'none';
    }
}
</script>

<?php include 'footer.php'; ?>