<?php
include 'db.php';
include 'header.php';

$query = "SELECT * FROM products";
$result = $conn->query($query);
?>

<div class="hero">
    <h1>Barangan Keperluan Asrama Terus Ke Dorm Anda!</h1>
    <p>Pilih, bayar secara dalam talian, dan kami terus hantar ke bilik dorm anda.</p>
</div>

<h2>Kategori Barang</h2>
<div style="margin: 1rem 0; display: flex; gap: 0.5rem; flex-wrap: wrap;">
    <button class="btn" data-filter="all">Semua</button>
    <button class="btn" data-filter="Makanan">Makanan</button>
    <button class="btn" data-filter="Minuman">Minuman</button>
    <button class="btn" data-filter="Penjagaan Diri">Penjagaan Diri</button>
    <button class="btn" data-filter="Keperluan">Keperluan</button>
</div>

<div class="product-grid">
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card" data-category="<?= $row['category']; ?>">
            <!-- PHP Memanggil Fail Imej dari Folder /images/ -->
            <img src="images/<?= htmlspecialchars($row['image']); ?>" alt="<?= htmlspecialchars($row['name']); ?>">
            <span class="category"><?= $row['category']; ?></span>
            <h3><?= htmlspecialchars($row['name']); ?></h3>
            <div class="price">RM <?= number_format($row['price'], 2); ?></div>
            
            <?php if ($row['stock'] > 0): ?>
                <span style="color: var(--success); font-size: 0.8rem; margin-bottom: 0.5rem;">Stok: <?= $row['stock']; ?></span>
                <a href="cart.php?action=add&id=<?= $row['id']; ?>" class="btn">Beli Sekarang</a>
            <?php else: ?>
                <span class="badge-soldout">Habis / Sold Out</span>
                <button class="btn btn-disabled" style="margin-top: 0.5rem;" disabled>Stok Habis</button>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
</div>

<script src="main.js"></script>
<?php include 'footer.php'; ?>