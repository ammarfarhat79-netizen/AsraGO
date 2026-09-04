<?php
include 'db.php';
include 'header.php';

// Sekat akses jika belum log masuk
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil senarai pesanan untuk pelajar yang sedang log masuk
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>

<h2>Status Pesanan Saya</h2>
<p style="margin-bottom: 1.5rem; color: var(--text-muted);">Semak status penghantaran barang keperluan terus ke dorm anda.</p>

<?php if ($orders->num_rows == 0): ?>
    <div class="card" style="text-align: center; padding: 2rem;">
        <p>Anda belum membuat sebarang pesanan.</p>
        <a href="index.php" class="btn" style="margin-top: 1rem; display: inline-block;">Mula Membeli</a>
    </div>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>No Dorm Penghantaran</th>
                <th>Jumlah Keseluruhan</th>
                <th>Status Pesanan</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($o = $orders->fetch_assoc()): ?>
            <tr>
                <td>#<?= $o['id']; ?></td>
                <td><strong style="color: var(--accent);"><?= htmlspecialchars($o['dorm_no']); ?></strong></td>
                <td>RM <?= number_format($o['total_price'], 2); ?></td>
                <td>
                    <?php if ($o['status'] == 'Sedang Diproses'): ?>
                        <span style="color: #f59e0b; font-weight: bold;"><?= $o['status']; ?></span>
                    <?php elseif ($o['status'] == 'Dalam Penghantaran'): ?>
                        <span style="color: #3b82f6; font-weight: bold;"><?= $o['status']; ?></span>
                    <?php elseif ($o['status'] == 'Selesai Dihantar'): ?>
                        <span style="color: var(--success); font-weight: bold;"><?= $o['status']; ?></span>
                    <?php else: ?>
                        <?= $o['status']; ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php include 'footer.php'; ?>