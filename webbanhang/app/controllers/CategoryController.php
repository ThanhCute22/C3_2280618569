<?php
require_once('app/config/database.php');
require_once('app/models/CategoryModel.php');

class CategoryController
{
    private $categoryModel;
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function list()
    {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    public function add()
    {
        include 'app/views/category/add.php';
    }

    public function save()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name)) {
                $errors[] = "Tên danh mục không được để trống.";
            }

            if (empty($errors)) {
                if ($this->categoryModel->create($name, $description)) {
                    header('Location: /Category/list');
                    exit;
                } else {
                    $errors[] = "Không thể thêm danh mục. Vui lòng thử lại.";
                }
            }
        }
        include 'app/views/category/add.php';
    }

    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        if (!$category) {
            // Redirect or show error if category not found
            header('Location: /Category/list');
            exit;
        }
        include 'app/views/category/edit.php';
    }

    public function update()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (empty($name)) {
                $errors[] = "Tên danh mục không được để trống.";
            }

            if (empty($errors)) {
                if ($this->categoryModel->update($id, $name, $description)) {
                    header('Location: /Category/list');
                    exit;
                } else {
                    $errors[] = "Không thể cập nhật danh mục. Vui lòng thử lại.";
                }
            }
        }
        $category = $this->categoryModel->getCategoryById($id);
        include 'app/views/category/edit.php';
    }

    public function delete($id)
    {
        if ($this->categoryModel->delete($id)) {
            header('Location: /Category/list');
            exit;
        } else {
            // Handle error (e.g., show error message)
            $errors[] = "Không thể xóa danh mục. Vui lòng thử lại.";
            $categories = $this->categoryModel->getCategories();
            include 'app/views/category/list.php';
        }
    }
}
?>