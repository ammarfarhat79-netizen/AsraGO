<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'db.php';

// Semak sesi SEBELUM include header.php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'courier') {
    header("Location: login.php");
    exit;
}

include 'header.php';

// Kemaskini Status Penghantaran
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
}

$orders = $conn->query("SELECT orders.*, users.fullname FROM orders JOIN users ON orders.user_id = users.id ORDER BY orders.id DESC");
?>

<h2>Dashboard Penghantar (Courier)</h2>
<p>Semak pesanan dan kemaskini status penghantaran terus ke dorm pelajar.</p>

<table>
    <thead>
        <tr>
            <th>ID Pesanan</th>
            <th>Nama Pelajar</th>
            <th>No Dorm</th>
            <th>Jumlah</th>
            <th>Status Semasa</th>
            <th>Tindakan Status</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($o = $orders->fetch_assoc()): ?>
        <tr>
            <td>#<?= $o['id']; ?></td>
            <td><?= htmlspecialchars($o['fullname']); ?></td>
            <td><strong style="color: var(--accent);"><?= htmlspecialchars($o['dorm_no']); ?></strong></td>
            <td>RM <?= number_format($o['total_price'], 2); ?></td>
            <td><?= $o['status']; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="order_id" value="<?= $o['id']; ?>">
                    <select name="status" onchange="this.form.submit()" style="padding:0.4rem; background: #0f172a; color: white; border-radius: 4px;">
                        <option value="Sedang Diproses" <?= $o['status'] == 'Sedang Diproses' ? 'selected' : ''; ?>>Sedang Diproses</option>
                        <option value="Dalam Penghantaran" <?= $o['status'] == 'Dalam Penghantaran' ? 'selected' : ''; ?>>Dalam Penghantaran</option>
                        <option value="Selesai Dihantar" <?= $o['status'] == 'Selesai Dihantar' ? 'selected' : ''; ?>>Selesai Dihantar</option>
                    </select>
                    <input type="hidden" name="update_status" value="1">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>