<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white text-center">
            <h2 class="mb-0">Thêm sản phẩm mới</h2>
        </div>
        <div class="card-body p-4">
            <?php if (!empty($errors)): ?>
            <div class="toast align-items-center text-white bg-danger border-0 mb-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                <div class="d-flex">
                    <div class="toast-body">
                        <ul class="mb-0">
                            <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
            <?php endif; ?>
            <form method="POST" action="/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
                <div class="mb-3 position-relative">
                    <label for="name" class="form-label">Tên sản phẩm</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea id="description" name="description" class="form-control" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Giá (VND)</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Danh mục</label>
                    <select id="category_id" name="category_id" class="form-select" required>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id; ?>">
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Hình ảnh</label>
                    <input type="file" id="image" name="image" class="form-control">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">Thêm sản phẩm</button>
                    <a href="/Product/list" class="btn btn-outline-secondary btn-lg">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Auto-show toast if errors exist
    document.addEventListener('DOMContentLoaded', function () {
        var toastEl = document.querySelector('.toast');
        if (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
    });
</script>
<?php include 'app/views/shares/footer.php'; ?>