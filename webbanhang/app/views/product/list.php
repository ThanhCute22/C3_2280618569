<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5 animate-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark">Danh sách sản phẩm</h1>
    </div>

    <?php if (isset($_SESSION['success_message'])): ?>
    <div class="toast align-items-center text-white bg-success border-0 mb-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
        <div class="d-flex">
            <div class="toast-body">
                <?php echo htmlspecialchars($_SESSION['success_message'], ENT_QUOTES, 'UTF-8'); ?>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <?php
    // Xóa thông báo sau khi hiển thị
    unset($_SESSION['success_message']);
    endif;
    ?> 

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($products as $product): ?>
        <div class="col">
            <div class="card h-100 shadow-lg border-0 animate-fade-in">
                <?php if ($product->image): ?>
                <div class="bg-light rounded-top p-2 d-flex align-items-center justify-content-center" style="height: 150px;">
                    <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                         class="img-fluid rounded" 
                         alt="Product Image" 
                         style="max-height: 130px; object-fit: contain;">
                </div>
                <?php else: ?>
                <div class="bg-light rounded-top d-flex align-items-center justify-content-center" 
                     style="height: 150px;">
                    <span class="text-muted">Không có ảnh</span>
                </div>
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="/Product/show/<?php echo $product->id; ?>" 
                           class="text-decoration-none text-dark">
                            <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                    </h5>
                    <p class="card-text text-truncate" 
                       title="<?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                    <p class="card-text fw-bold text-danger">
                        <?php echo htmlspecialchars(number_format($product->price, 0, ',', '.'), ENT_QUOTES, 'UTF-8'); ?> VND
                    </p>
                    <p class="card-text">
                        <span class="badge bg-info text-white">
                            <?php echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8'); ?>
                        </span>
                    </p>
                </div>
                <div class="card-footer bg-transparent border-0 d-flex align-items-center">
                    <?php
                    // Kiểm tra xem người dùng có phải admin không
                    $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
                    ?>
                    <?php if ($isAdmin): ?>
                        <a href="/Product/edit/<?php echo $product->id; ?>" 
                           class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil"></i> Sửa</a>
                        <a href="/Product/delete/<?php echo $product->id; ?>" 
                           class="btn btn-sm btn-danger me-1" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"><i class="bi bi-trash"></i> Xóa</a>
                        <a href="/Product/addToCart/<?php echo $product->id; ?>" 
                           class="btn btn-sm btn-primary me-1"><i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng</a>
                    <?php else: ?>
                        <a href="/Product/addToCart/<?php echo $product->id; ?>" 
                           class="btn btn-sm btn-primary"><i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastEl = document.querySelector('.toast');
        if (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>
<?php include 'app/views/shares/footer.php'; ?>