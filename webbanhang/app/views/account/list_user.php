<?php include 'app/views/shares/header.php'; ?>
<div class="container mt-5 animate-fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark">Danh sách người dùng</h1>
        <a href="/account/addUser" class="btn btn-primary btn-lg"><i class="bi bi-plus-circle"></i> Thêm người dùng mới</a>
    </div>
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
    <div class="card shadow-lg border-0">
        <div class="card-body p-4">
            <table class="table table-hover">
                <thead class="bg-gradient-primary text-white">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ảnh đại diện</th>
                        <th scope="col">Tên đăng nhập</th>
                        <th scope="col">Họ và tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Vai trò</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">Không có người dùng nào.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <th scope="row"><?php echo $index + 1; ?></th>
                        <td>
                            <?php if ($user->avatar): ?>
                            <img src="/<?php echo htmlspecialchars($user->avatar, ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px;">
                            <?php else: ?>
                            <i class="bi bi-person-circle text-muted" style="font-size: 40px;"></i>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($user->username, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($user->fullname, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($user->phone, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($user->role, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td>
                            <a href="/account/editUser/<?php echo urlencode($user->username); ?>" class="btn btn-warning btn-sm me-2"><i class="bi bi-pencil"></i> Sửa</a>
                            <a href="/account/deleteUser/<?php echo urlencode($user->username); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');"><i class="bi bi-trash"></i> Xóa</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
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