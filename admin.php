<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Semak sesi SEBELUM memanggil header.php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

include 'header.php';

// Kemaskini Stok Produk
if (isset($_POST['update_stock'])) {
    $p_id = $_POST['product_id'];
    $new_stock = $_POST['stock'];
    $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_stock, $p_id);
    $stmt->execute();
}

// Laporan Jualan
$total_sales = $conn->query("SELECT SUM(total_price) AS total FROM orders WHERE status = 'Selesai Dihantar'")->fetch_assoc()['total'] ?? 0;
$products = $conn->query("SELECT * FROM products");
?>


<!-- Baki kod admin.php kekal sama seperti asal -->

<h2>Dashboard Pentadbir (Admin)</h2>

<div style="display: flex; gap: 1rem; margin: 1.5rem 0;">
    <div class="card" style="flex: 1;">
        <h3>Jumlah Jualan Keseluruhan</h3>
        <p style="font-size: 2rem; color: var(--accent); font-weight: bold;">RM <?= number_format($total_sales, 2); ?></p>
    </div>
</div>

<h3>Pengurusan Stok & Barang Sold Out</h3>
<table>
    <thead>
        <tr>
            <th>Gambar</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Baki Stok</th>
            <th>Tindakan Restock</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($p = $products->fetch_assoc()): ?>
        <tr>
            <td><img src="images/<?= $p['image']; ?>" width="50" style="border-radius:4px;"></td>
            <td><?= htmlspecialchars($p['name']); ?></td>
            <td><?= $p['category']; ?></td>
            <td>RM <?= number_format($p['price'], 2); ?></td>
            <td>
                <?php if ($p['stock'] == 0): ?>
                    <span class="badge-soldout">Habis</span>
                <?php else: ?>
                    <?= $p['stock']; ?>
                <?php endif; ?>
            </td>
            <td>
                <form method="POST" style="display: flex; gap: 0.5rem;">
                    <input type="hidden" name="product_id" value="<?= $p['id']; ?>">
                    <input type="number" name="stock" value="<?= $p['stock']; ?>" style="width: 70px; padding: 0.2rem;" min="0">
                    <button type="submit" name="update_stock" class="btn" style="padding: 0.2rem 0.6rem;">Kemaskini</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>