<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5 animate-fade-in">
    <h1 class="fw-bold text-dark mb-4">Thanh toán</h1>
    <div class="card shadow-lg border-0">
        <div class="card-body p-4">
            <form method="POST" action="/Product/processCheckout">
                <div class="form-group mb-3">
                    <label for="name">Họ tên:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="address">Địa chỉ:</label>
                    <textarea id="address" name="address" class="form-control" required></textarea>
                </div>
                <div class="form-group mb-3">
                    <label>Phương thức thanh toán:</label>
                    <div class="card p-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="cash" value="1" required checked>
                            <label class="form-check-label" for="cash">
                                Tiền mặt 
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="momo" value="2" required>
                            <label class="form-check-label" for="momo">
                                Momo 
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="vnpay" value="3" required>
                            <label class="form-check-label" for="vnpay">
                                VNPay 
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Thanh toán</button>
            </form>
            <a href="/Product/cart" class="btn btn-secondary mt-2">Quay lại giỏ hàng</a>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>