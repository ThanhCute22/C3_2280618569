<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5 animate-fade-in">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white text-center">
            <h2 class="mb-0">Chi tiết sản phẩm</h2>
        </div>
        <div class="card-body p-4">
            <?php if ($product): ?>
            <div class="row">
                <div class="col-md-6 mb-4 mb-md-0">
                    <?php if ($product->image): ?>
                    <img src="/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>"
                         class="img-fluid rounded shadow-sm" 
                         alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                    <?php else: ?>
                    <img src="/images/no-image.png"
                         class="img-fluid rounded shadow-sm" 
                         alt="Không có ảnh">
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h3 class="card-title fw-bold text-dark"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?></p>
                    <p class="text-danger fw-bold h4">
                        💰 <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                    </p>
                    <p>
                        <strong>Danh mục:</strong>
                        <span class="badge bg-info text-white">
                            <?php echo !empty($product->category_name) ? htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8') : 'Chưa có danh mục'; ?>
                        </span>
                    </p>
                    <div class="mt-4 d-flex gap-2">
                        <a href="/Product/addToCart/<?php echo $product->id; ?>"
                           class="btn btn-success btn-lg"><i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng</a>
                        <a href="/Product/list" class="btn btn-outline-secondary btn-lg">Quay lại danh sách</a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-danger text-center shadow-sm">
                <h4 class="mb-0">Không tìm thấy sản phẩm!</h4>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'app/views/shares/footer.php'; ?>