<?php include 'app/views/shares/header.php'; ?>
<h1>Xác nhận đơn hàng</h1>
<p>Cảm ơn bạn đã đặt hàng. Đơn hàng của bạn đã được xử lý thành công.</p>

<?php 
// Hàm ánh xạ ID phương thức thanh toán thành tên
function getPaymentMethodName($id) {
    switch ($id) {
        case 1:
            return "Tiền mặt";
        case 2:
            return "Momo";
        case 3:
            return "VNPay";
        default:
            return "Không xác định";
    }
}

// Debug: Kiểm tra dữ liệu $order
if (!isset($order)) {
    echo "<p><strong>Debug:</strong> Biến \$order không được truyền hoặc không tồn tại.</p>";
}
?>

<?php if ($order): ?>
<p><strong>Mã đơn hàng:</strong> <?php echo htmlspecialchars($order->id, ENT_QUOTES, 'UTF-8'); ?></p>
<p><strong>Tên khách hàng:</strong> <?php echo htmlspecialchars($order->name, ENT_QUOTES, 'UTF-8'); ?></p>
<p><strong>Email:</strong> <?php echo htmlspecialchars($order->email, ENT_QUOTES, 'UTF-8'); ?></p>
<p><strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars(getPaymentMethodName($order->payment_method), ENT_QUOTES, 'UTF-8'); ?></p>
<p><strong>Tổng giá trị đơn hàng:</strong> <?php echo htmlspecialchars(number_format($order->total_price, 0, ',', '.'), ENT_QUOTES, 'UTF-8'); ?> VND</p>
<?php else: ?>
<p>Không tìm thấy thông tin đơn hàng.</p>
<?php endif; ?>

<a href="/Product/list" class="btn btn-primary mt-2">Tiếp tục mua sắm</a>
<?php include 'app/views/shares/footer.php'; ?>