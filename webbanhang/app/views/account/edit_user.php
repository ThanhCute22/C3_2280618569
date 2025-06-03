<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5 animate-fade-in">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-primary text-white text-center">
            <h2 class="mb-0">Sửa thông tin người dùng</h2>
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
            <form method="POST" action="/account/updateUser" enctype="multipart/form-data">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?>">
                <div class="mb-3">
                    <label for="username_display" class="form-label">Tên đăng nhập</label>
                    <input type="text" id="username_display" class="form-control" value="<?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="fullname" class="form-label">Họ và tên</label>
                    <input type="text" id="fullname" name="fullname" class="form-control" value="<?php echo htmlspecialchars($user->fullname, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($user->phone, ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="avatar" class="form-label">Ảnh đại diện</label>
                    <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                    <input type="hidden" name="existing_avatar" value="<?php echo htmlspecialchars($user->avatar, ENT_QUOTES, 'UTF-8'); ?>">
                    <?php if ($user->avatar): ?>
                    <img src="/<?php echo htmlspecialchars($user->avatar, ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar" class="img-fluid rounded mt-2" style="max-width: 100px;">
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật khẩu mới (để trống nếu không đổi)</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="confirmpassword" class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" id="confirmpassword" name="confirmpassword" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Vai trò</label>
                    <select id="role" name="role" class="form-select" required>
                        <option value="user" <?php echo $user->role === 'user' ? 'selected' : ''; ?>>User</option>
                        <option value="admin" <?php echo $user->role === 'admin' ? 'selected' : ''; ?>>Admin</option>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-save"></i> Lưu thay đổi</button>
                    <a href="/account/listUsers" class="btn btn-outline-secondary btn-lg">Quay lại</a>
                </div>
            </form>
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