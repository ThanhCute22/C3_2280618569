<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5 animate-fade-in">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white text-center">
                    <h2 class="mb-0">Đăng ký tài khoản</h2>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($errors) && !empty($errors)): ?>
                    <div class="toast align-items-center text-white bg-danger border-0 mb-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                        <div class="d-flex">
                            <div class="toast-body">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $err): ?>
                                    <li><?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                    <?php endif; ?>
                    <form method="POST" action="/account/save" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ và tên</label>
                            <input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8') : ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Ảnh đại diện</label>
                            <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmpassword" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" id="confirmpassword" name="confirmpassword" class="form-control" required>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-person-plus"></i> Đăng ký</button>
                            <a href="/account/login" class="btn btn-outline-secondary btn-lg">Đăng nhập</a>
                        </div>
                    </form>
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
        // Kiểm tra client-side
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const phoneRegex = /^[0-9]{10,11}$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Email không hợp lệ.');
            }
            if (!phoneRegex.test(phone)) {
                e.preventDefault();
                alert('Số điện thoại phải có 10-11 chữ số.');
            }
        });
    });
</script>
<?php include 'app/views/shares/footer.php'; ?>