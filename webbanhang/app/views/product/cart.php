<?php include 'app/views/shares/header.php'; ?>
<h1>Giỏ hàng</h1>
<?php if (!empty($cart)): ?>
<ul class="list-group">
<?php 
$totalCartPrice = 0; // Biến để tính tổng giá trị giỏ hàng
foreach ($cart as $id => $item): 
    $totalCartPrice += $item['total_price']; // Cộng dồn total_price
?>
<li class="list-group-item">
    <h2><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h2>

    <?php if ($item['image']): ?>
    <img src="/<?php echo $item['image']; ?>" alt="Product Image" style="max-width: 100px;">
    <?php endif; ?>

    <p>Giá: <?php echo htmlspecialchars(number_format($item['price'], 0, ',', '.'), ENT_QUOTES, 'UTF-8'); ?> VND</p>

    <p>Số lượng: 
        <a href="/Product/decreaseQuantity/<?php echo $id; ?>" class="btn btn-sm btn-warning">-</a>
        <?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?>
        <a href="/Product/increaseQuantity/<?php echo $id; ?>" class="btn btn-sm btn-success">+</a>
    </p>

    <p>Tổng giá: <?php echo htmlspecialchars(number_format($item['total_price'], 0, ',', '.'), ENT_QUOTES, 'UTF-8'); ?> VND</p>

</li>
<?php endforeach; ?>
</ul>
<p class="mt-3"><strong>Tổng giá trị giỏ hàng:</strong> <?php echo htmlspecialchars(number_format($totalCartPrice, 0, ',', '.'), ENT_QUOTES, 'UTF-8'); ?> VND</p>
<?php else: ?>
<p>Giỏ hàng của bạn đang trống.</p>
<?php endif; ?>
<a href="/Product" class="btn btn-secondary mt-2">Tiếp tục mua sắm</a>
<a href="/Product/checkout" class="btn btn-secondary mt-2">Thanh Toán</a>
<?php include 'app/views/shares/footer.php'; ?>