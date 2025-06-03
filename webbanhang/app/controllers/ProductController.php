<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
// Thêm require SessionHelper
require_once('app/helpers/SessionHelper.php');

class ProductController {
    private $productModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    // Thêm phương thức kiểm tra quyền admin
    private function isAdmin() {
        // Nếu có SessionHelper::isAdmin(), sử dụng phương thức này
        // return SessionHelper::isAdmin();
        // Nếu không, giả định dùng $_SESSION['role']
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function index() {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function show($id) {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add() {
        // Kiểm tra quyền admin
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save() {
        // Kiểm tra quyền admin
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = "";
            }
            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);
            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /Product');
            }
        }
    }

    public function edit($id) {
        // Kiểm tra quyền admin
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();
        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update() {
        // Kiểm tra quyền admin
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            } else {
                $image = $_POST['existing_image'];
            }
            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            if ($edit) {
                header('Location: /Product');
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete($id) {
        // Kiểm tra quyền admin
        if (!$this->isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này!";
            exit;
        }
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /Product');
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file) {
        $target_dir = "uploads/";
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

    public function addToCart($id) {
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'original_price' => $product->price, // Lưu giá gốc
                'price' => $product->price, // Lưu giá hiện tại
                'quantity' => 1,
                'total_price' => $product->price, // Tổng giá ban đầu
                'image' => $product->image
            ];
        }
    
        // Cập nhật giá nếu số lượng từ 2 trở lên
        if ($_SESSION['cart'][$id]['quantity'] >= 2) {
            $_SESSION['cart'][$id]['price'] = $_SESSION['cart'][$id]['original_price'] * 0.9;
        } else {
            $_SESSION['cart'][$id]['price'] = $_SESSION['cart'][$id]['original_price'];
        }
    
        // Tính total_price
        $_SESSION['cart'][$id]['total_price'] = $_SESSION['cart'][$id]['quantity'] * $_SESSION['cart'][$id]['price'];
    
        // Thêm thông báo thành công vào session
        $_SESSION['success_message'] = "Sản phẩm đã được thêm vào giỏ hàng!";
        header('Location: /Product');
        exit();
    }
    
    public function increaseQuantity($id) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
    
            // Cập nhật giá nếu số lượng từ 2 trở lên
            if ($_SESSION['cart'][$id]['quantity'] >= 2) {
                $_SESSION['cart'][$id]['price'] = $_SESSION['cart'][$id]['original_price'] * 0.9;
            } else {
                $_SESSION['cart'][$id]['price'] = $_SESSION['cart'][$id]['original_price'];
            }
    
            // Tính lại total_price
            $_SESSION['cart'][$id]['total_price'] = $_SESSION['cart'][$id]['quantity'] * $_SESSION['cart'][$id]['price'];
        }
        header('Location: /Product/cart');
        exit();
    }
    
    public function decreaseQuantity($id) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']--;
            
            // Nếu số lượng giảm về 0, xóa sản phẩm khỏi giỏ hàng
            if ($_SESSION['cart'][$id]['quantity'] <= 0) {
                unset($_SESSION['cart'][$id]);
            } else {
                // Cập nhật giá nếu số lượng từ 2 trở lên
                if ($_SESSION['cart'][$id]['quantity'] >= 2) {
                    $_SESSION['cart'][$id]['price'] = $_SESSION['cart'][$id]['original_price'] * 0.9;
                } else {
                    $_SESSION['cart'][$id]['price'] = $_SESSION['cart'][$id]['original_price'];
                }
    
                // Tính lại total_price
                $_SESSION['cart'][$id]['total_price'] = $_SESSION['cart'][$id]['quantity'] * $_SESSION['cart'][$id]['price'];
            }
        }
        header('Location: /Product/cart');
        exit();
    }

    public function cart() {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }

    public function checkout() {
        include 'app/views/product/checkout.php';
    }

    public function processCheckout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $address = $_POST['address'];
            $payment_method = (int)$_POST['payment_method'];
    
            // Kiểm tra giỏ hàng
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }
    
            // Kiểm tra payment_method hợp lệ
            if (!in_array($payment_method, [1, 2, 3])) {
                throw new Exception("Phương thức thanh toán không hợp lệ.");
            }
    
            // Bắt đầu giao dịch
            $this->db->beginTransaction();
            try {
                // Tính tổng giá trị đơn hàng
                $totalPrice = 0;
                $cart = $_SESSION['cart'];
                foreach ($cart as $item) {
                    if (!isset($item['total_price'])) {
                        throw new Exception("Thiếu total_price trong giỏ hàng.");
                    }
                    $totalPrice += $item['total_price'];
                }
    
                // Lưu thông tin đơn hàng vào bảng orders
                $query = "INSERT INTO orders (name, phone, email, address, total_price, payment_method) VALUES (:name, :phone, :email, :address, :total_price, :payment_method)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                $stmt->bindParam(':total_price', $totalPrice, PDO::PARAM_STR);
                $stmt->bindParam(':payment_method', $payment_method, PDO::PARAM_INT);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();
    
                // Lưu chi tiết đơn hàng vào bảng order_details
                foreach ($cart as $product_id => $item) {
                    if (!isset($item['quantity']) || !isset($item['price']) || !isset($item['total_price'])) {
                        throw new Exception("Dữ liệu giỏ hàng không hợp lệ: Thiếu quantity, price hoặc total_price cho product_id $product_id.");
                    }
    
                    $quantity = (int)$item['quantity'];
                    $price = (float)$item['price'];
                    $total_price = (float)$item['total_price'];
                    $product_id = (int)$product_id;
    
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price, total_price) VALUES (:order_id, :product_id, :quantity, :price, :total_price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
                    $stmt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
                    $stmt->bindParam(':price', $price, PDO::PARAM_STR);
                    $stmt->bindParam(':total_price', $total_price, PDO::PARAM_STR);
                    $stmt->execute();
                }
    
                // Xóa giỏ hàng sau khi đặt hàng thành công
                unset($_SESSION['cart']);
                // Lưu order_id vào session để sử dụng trên trang xác nhận
                $_SESSION['last_order_id'] = $order_id;
                // Commit giao dịch
                $this->db->commit();
                // Chuyển hướng đến trang xác nhận đơn hàng
                header('Location: /Product/orderConfirmation');
                exit();
            } catch (Exception $e) {
                // Rollback giao dịch nếu có lỗi
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
                exit();
            }
        }
    }

    public function getOrderById($id) {
        $query = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    
    public function orderConfirmation() {
        $order = null;
        if (isset($_SESSION['last_order_id'])) {
            $order = $this->getOrderById($_SESSION['last_order_id']);
            if (!$order) {
                // Debug: Nếu không tìm thấy đơn hàng
                error_log("Không tìm thấy đơn hàng với ID: " . $_SESSION['last_order_id']);
            }
            unset($_SESSION['last_order_id']);
        } else {
            // Debug: Nếu session không tồn tại
            error_log("Không tìm thấy last_order_id trong session.");
        }
        include 'app/views/product/orderConfirmation.php';
    }

    public function list() {
        $products = $this->productModel->getProducts();
        require_once 'app/views/product/list.php';
    }
}
?>