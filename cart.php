<?php
include 'db.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Tambah Barang ke Troli
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $product_id = intval($_GET['id']);
    $check_p = $conn->query("SELECT id FROM products WHERE id = $product_id");
    if ($check_p && $check_p->num_rows > 0) {
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]++;
        } else {
            $_SESSION['cart'][$product_id] = 1;
        }
    }
    echo "<script>window.location='cart.php';</script>";
    exit;
}

// Padam Barang dari Troli
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $product_id = intval($_GET['id']);
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
    echo "<script>window.location='cart.php';</script>";
    exit;
}
?>

<h2>Troli Belanja Anda</h2>

<?php if (empty($_SESSION['cart'])): ?>
    <div class="card" style="text-align: center; padding: 2rem;">
        <p>Troli anda masih kosong.</p>
        <a href="index.php" class="btn" style="margin-top: 1rem; display: inline-block;">Lihat Barangan</a>
    </div>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Barang</th>
                <th>Harga Seunit</th>
                <th>Kuantiti</th>
                <th>Jumlah</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $grand_total = 0;
            foreach ($_SESSION['cart'] as $id => $quantity): 
                $id = intval($id);
                $res = $conn->query("SELECT * FROM products WHERE id = $id");
                if ($res && $res->num_rows > 0):
                    $product = $res->fetch_assoc();
                    $subtotal = $product['price'] * $quantity;
                    $grand_total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($product['name']); ?></td>
                <td>RM <?= number_format($product['price'], 2); ?></td>
                <td><?= $quantity; ?></td>
                <td>RM <?= number_format($subtotal, 2); ?></td>
                <td>
                    <a href="cart.php?action=remove&id=<?= $id; ?>" style="color: var(--danger); text-decoration: none; font-weight: bold;">Padam</a>
                </td>
            </tr>
            <?php 
                endif;
            endforeach; 
            ?>
        </tbody>
    </table>

    <div style="margin-top: 1.5rem; text-align: right;">
        <h3>Jumlah Keseluruhan: <span style="color: var(--accent);">RM <?= number_format($grand_total, 2); ?></span></h3>
        <!-- Terus ke Halaman Pembayaran -->
        <a href="payment.php" class="btn" style="margin-top: 1rem; display: inline-block; text-decoration: none;">Teruskan Ke Pembayaran</a>
    </div>
<?php endif; ?>

<?php include 'footer.php'; ?>