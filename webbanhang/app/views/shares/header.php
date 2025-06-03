<?php
// Kiểm tra và khởi động session nếu chưa khởi động
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            min-height: 100vh;
        }
        .navbar {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand, .nav-link {
            color: white !important;
            transition: color 0.3s, transform 0.3s;
        }
        .nav-link:hover {
            color: #ffd700 !important;
            transform: scale(1.05);
        }
        .bg-gradient-primary {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
        }
        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2a5298;
            box-shadow: 0 0 10px rgba(42, 82, 152, 0.2);
        }
        .btn-primary {
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            border: none;
            border-radius: 12px;
            padding: 10px 20px;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #2a5298, #1e3c72);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(42, 82, 152, 0.4);
        }
        .btn-outline-secondary {
            border-radius: 12px;
            transition: all 0.3s;
        }
        .btn-outline-secondary:hover {
            background-color: #e0e0e0;
            transform: translateY(-3px);
        }
        .card {
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        /* Điều chỉnh badge giỏ hàng */
        .cart-badge {
            top: -8px !important;
            right: -12px !important;
            font-size: 0.65rem;
            padding: 0.2em 0.5em;
            transform: translateY(-50%);
        }
        /* Ngăn badge bị ảnh hưởng bởi hover của nav-link */
        .nav-link:hover .cart-badge {
            transform: translateY(-50%) !important;
        }
        /* Khoảng cách giữa biểu tượng và chữ */
        .cart-icon {
            margin-right: 0.3rem;
        }
        /* Bổ sung style cho dropdown */
        .dropdown-menu {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            background-color: #fff;
        }
        .dropdown-item {
            padding: 8px 20px;
            transition: background-color 0.3s;
        }
        .dropdown-item:hover {
            background-color: #f5f7fa;
        }
        /* Điều chỉnh avatar trong dropdown */
        .avatar-img {
            width: 30px;
            height: 30px;
            object-fit: cover;
            border-radius: 50%;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                Quản lý sản phẩm
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/Product/">Danh sách sản phẩm</a>
                    </li>
                    <?php
                    // Giả định SessionHelper::isAdmin() bằng cách kiểm tra $_SESSION['role']
                    $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
                    ?>
                    <?php if ($isAdmin): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/account/listUsers">Quản lý người dùng</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/Category/list">Danh sách danh mục</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Product/cart">
                            <span class="position-relative">
                                <i class="bi bi-cart cart-icon"></i>
                                <?php
                                // Tính tổng số lượng sản phẩm trong giỏ hàng
                                $cartCount = 0;
                                if (isset($_SESSION['cart']) && !empty($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                                    foreach ($_SESSION['cart'] as $item) {
                                        if (isset($item['quantity']) && is_numeric($item['quantity'])) {
                                            $cartCount += (int)$item['quantity'];
                                        }
                                    }
                                }
                                ?>
                                <?php if ($cartCount > 0): ?>
                                    <span class="badge bg-danger rounded-pill position-absolute cart-badge"><?php echo $cartCount; ?></span>
                                <?php endif; ?>
                            </span>
                            Giỏ hàng
                        </a>
                    </li>
                    <?php
                    require_once 'app/helpers/SessionHelper.php';
                    $isLoggedIn = SessionHelper::isLoggedIn();
                    ?>
                    <li class="nav-item dropdown">
                        <?php if ($isLoggedIn): ?>
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php if (isset($_SESSION['avatar']) && $_SESSION['avatar']): ?>
                                    <img src="/<?php echo htmlspecialchars($_SESSION['avatar'], ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar" class="avatar-img">
                                <?php else: ?>
                                    <i class="bi bi-person-circle me-2" style="font-size: 1.5rem;"></i>
                                <?php endif; ?>
                                <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                                <li><a class="dropdown-item" href="/account/logout">Đăng xuất</a></li>
                            </ul>
                        <?php else: ?>
                            <a class="nav-link" href="/account/login">Đăng nhập</a>
                        <?php endif; ?>
                    </li>
                    <?php if (!$isLoggedIn): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/account/register">Đăng ký</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">