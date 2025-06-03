<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');

class AccountController {
    private $accountModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    private function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    private function uploadAvatar($file) {
        $target_dir = "uploads/avatars/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }
        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }
        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }
        return $target_file;
    }

    public function register() {
        include_once 'app/views/account/register.php';
    }

    public function login() {
        include_once 'app/views/account/login.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username'] ?? '');
            $fullName = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $role = $_POST['role'] ?? 'user';
            $avatar = null;
            $errors = [];

            if (empty($username)) $errors['username'] = "Vui lòng nhập tên đăng nhập!";
            if (empty($fullName)) $errors['fullname'] = "Vui lòng nhập họ và tên!";
            if (empty($email)) $errors['email'] = "Vui lòng nhập email!";
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Email không hợp lệ!";
            if (empty($phone)) $errors['phone'] = "Vui lòng nhập số điện thoại!";
            if (!preg_match('/^[0-9]{10,11}$/', $phone)) $errors['phone'] = "Số điện thoại phải có 10-11 chữ số!";
            if (empty($password)) $errors['password'] = "Vui lòng nhập mật khẩu!";
            if ($password != $confirmPassword) $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp!";
            if (!in_array($role, ['admin', 'user'])) $role = 'user';
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors['account'] = "Tên đăng nhập này đã được đăng ký!";
            }
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                try {
                    $avatar = $this->uploadAvatar($_FILES['avatar']);
                } catch (Exception $e) {
                    $errors['avatar'] = $e->getMessage();
                }
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                $result = $this->accountModel->save($username, $fullName, $email, $phone, $password, $avatar, $role);
                if ($result) {
                    header('Location: /account/login');
                    exit;
                } else {
                    $errors['general'] = "Không thể đăng ký. Vui lòng thử lại!";
                    include_once 'app/views/account/register.php';
                }
            }
        }
    }

    public function logout() {
        session_start();
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: /product');
        exit;
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $account = $this->accountModel->getAccountByUsername($username);
            if ($account && password_verify($password, $account->password)) {
                session_start();
                if (!isset($_SESSION['username'])) {
                    $_SESSION['username'] = $account->username;
                    $_SESSION['role'] = $account->role;
                    $_SESSION['avatar'] = $account->avatar; // Lưu avatar vào session
                }
                header('Location: /product');
                exit;
            } else {
                $error = $account ? "Mật khẩu không đúng!" : "Không tìm thấy tài khoản!";
                include_once 'app/views/account/login.php';
                exit;
            }
        }
    }

    public function listUsers() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $users = $this->accountModel->getAllUsers();
        include 'app/views/account/list_user.php';
    }

    public function addUser() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        include 'app/views/account/add_user.php';
    }

    public function saveUser() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $fullName = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $role = $_POST['role'] ?? 'user';
            $avatar = null;

            if (empty($username)) {
                $errors[] = "Tên đăng nhập không được để trống.";
            }
            if (empty($fullName)) {
                $errors[] = "Họ và tên không được để trống.";
            }
            if (empty($email)) {
                $errors[] = "Email không được để trống.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ.";
            }
            if (empty($phone)) {
                $errors[] = "Số điện thoại không được để trống.";
            }
            if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
                $errors[] = "Số điện thoại phải có 10-11 chữ số.";
            }
            if (empty($password)) {
                $errors[] = "Mật khẩu không được để trống.";
            }
            if ($password !== $confirmPassword) {
                $errors[] = "Mật khẩu và xác nhận mật khẩu không khớp.";
            }
            if (!in_array($role, ['admin', 'user'])) {
                $errors[] = "Vai trò không hợp lệ.";
            }
            if ($this->accountModel->getAccountByUsername($username)) {
                $errors[] = "Tên đăng nhập đã tồn tại.";
            }
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                try {
                    $avatar = $this->uploadAvatar($_FILES['avatar']);
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }

            if (empty($errors)) {
                if ($this->accountModel->save($username, $fullName, $email, $phone, $password, $avatar, $role)) {
                    header('Location: /account/listUsers');
                    exit;
                } else {
                    $errors[] = "Không thể thêm người dùng. Vui lòng thử lại.";
                }
            }
        }
        include 'app/views/account/add_user.php';
    }

    public function editUser($username) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $user = $this->accountModel->getUserByUsername($username);
        if (!$user) {
            header('Location: /account/listUsers');
            exit;
        }
        include 'app/views/account/edit_user.php';
    }

    public function updateUser() {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $fullName = trim($_POST['fullname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $role = $_POST['role'] ?? 'user';
            $avatar = $_POST['existing_avatar'] ?? null;

            if (empty($fullName)) {
                $errors[] = "Họ và tên không được để trống.";
            }
            if (empty($email)) {
                $errors[] = "Email không được để trống.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ.";
            }
            if (empty($phone)) {
                $errors[] = "Số điện thoại không được để trống.";
            }
            if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
                $errors[] = "Số điện thoại phải có 10-11 chữ số.";
            }
            if ($password && $password !== $confirmPassword) {
                $errors[] = "Mật khẩu và xác nhận mật khẩu không khớp.";
            }
            if (!in_array($role, ['admin', 'user'])) {
                $errors[] = "Vai trò không hợp lệ.";
            }
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
                try {
                    $avatar = $this->uploadAvatar($_FILES['avatar']);
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }

            if (empty($errors)) {
                if ($this->accountModel->updateUser($username, $fullName, $email, $phone, $password ?: null, $avatar, $role)) {
                    // Cập nhật session nếu người dùng chỉnh sửa chính họ
                    if ($_SESSION['username'] === $username) {
                        $_SESSION['avatar'] = $avatar;
                    }
                    header('Location: /account/listUsers');
                    exit;
                } else {
                    $errors[] = "Không thể cập nhật người dùng. Vui lòng thử lại.";
                }
            }
        }
        $user = $this->accountModel->getUserByUsername($username);
        include 'app/views/account/edit_user.php';
    }

    public function deleteUser($username) {
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($this->accountModel->deleteUser($username)) {
            header('Location: /account/listUsers');
            exit;
        } else {
            $errors[] = "Không thể xóa người dùng. Vui lòng thử lại.";
            $users = $this->accountModel->getAllUsers();
            include 'app/views/account/list_user.php';
        }
    }
}
?>