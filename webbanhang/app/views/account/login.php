<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5 animate-fade-in">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white text-center">
                    <h2 class="mb-0">Đăng nhập</h2>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($error) && !empty($error)): ?>
                    <div class="toast align-items-center text-white bg-danger border-0 mb-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                        <div class="d-flex">
                            <div class="toast-body">
                                <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                    <?php endif; ?>
                    <form method="POST" action="/account/checklogin">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <a href="#!" class="text-muted small">Quên mật khẩu?</a>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-box-arrow-in-right"></i> Đăng nhập</button>
                            <a href="/account/register" class="btn btn-outline-secondary btn-lg">Đăng ký</a>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                        <p class="text-muted">Hoặc đăng nhập bằng:</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#!" class="text-primary"><i class="bi bi-facebook fs-4"></i></a>
                            <a href="#!" class="text-info"><i class="bi bi-twitter fs-4"></i></a>
                            <a href="#!" class="text-danger"><i class="bi bi-google fs-4"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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