<?php
class OrderController {
    private $orders;

    public function __construct() {
        $this->orders = new OrderModel();
    }

    // Hiển thị danh sách đơn hàng
    public function index() {
        $view = 'orders/index';
        $title = 'Danh sách order';
        $data = $this->orders->getAll(); // Lấy tất cả đơn hàng
        require_once PATH_VIEW_ADMIN_MAIN;
    }

    // Hiển thị chi tiết đơn hàng
    public function show() {
        try {
            // Kiểm tra tham số "id" trong URL
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (!$id) {
                throw new Exception('Thiếu tham số "id" hoặc ID không hợp lệ!', 99);
            }

            // Lấy chi tiết đơn hàng từ model
            $orderDetails = $this->orders->showAllID($id);

            // Kiểm tra nếu không có kết quả
            if (empty($orderDetails)) {
                throw new Exception("Đơn hàng có ID = $id KHÔNG TỒN TẠI!");
            }

            // Truyền dữ liệu tới view
            $view = 'orders/show';
            $title = "Chi tiết đơn hàng có ID = $id";
            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit();
        }
    }

    // Chỉnh sửa đơn hàng
    public function edit() {
        try {
            // Kiểm tra tham số "id" trong URL
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (!$id) {
                throw new Exception('Thiếu tham số "id" hoặc ID không hợp lệ!', 99);
            }

            // Lấy thông tin đơn hàng từ model
            $orderDetails = $this->orders->showAllID($id);

            if (empty($orderDetails)) {
                throw new Exception("Đơn hàng có ID = $id KHÔNG TỒN TẠI!");
            }

            // Truyền dữ liệu tới view
            $view = 'orders/edit';
            $title = "Cập nhật đơn hàng có ID = $id";
            require_once PATH_VIEW_ADMIN_MAIN;

        } catch (\Throwable $th) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $th->getMessage();

            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit();
        }
    }

    // Cập nhật thông tin đơn hàng
    public function update() {
        try {
            // Kiểm tra phương thức POST
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Yêu cầu không hợp lệ!');
            }

            // Lấy dữ liệu từ form
            $order_id = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
            if (!$order_id) {
                throw new Exception('Thiếu tham số "order_id" hoặc ID không hợp lệ');
            }

            $customer_name = filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING);
            $customer_email = filter_input(INPUT_POST, 'customer_email', FILTER_VALIDATE_EMAIL);
            $customer_phone = filter_input(INPUT_POST, 'customer_phone', FILTER_SANITIZE_STRING);
            $total_amount = filter_input(INPUT_POST, 'total_amount', FILTER_VALIDATE_FLOAT);
            $order_status = filter_input(INPUT_POST, 'order_status', FILTER_SANITIZE_STRING);
            $payment_status = filter_input(INPUT_POST, 'payment_status', FILTER_SANITIZE_STRING);
            $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);

            if (!$customer_email) {
                throw new Exception('Email không hợp lệ!');
            }

            // Lấy thông tin các sản phẩm từ form
            $order_items = [];
            foreach ($_POST['product_name'] as $key => $product_name) {
                $order_items[] = [
                    'order_item_id' => $_POST['order_item_id'][$key],
                    'product_name' => $product_name,
                    'variant_name' => $_POST['variant_name'][$key],
                    'quantity' => $_POST['quantity'][$key],
                    'price' => $_POST['price'][$key],
                    'total_price' => $_POST['total_price'][$key],
                ];
            }

            // Cập nhật đơn hàng và các sản phẩm
            $this->orders->updateOrderAndItems($order_id, $customer_name, $customer_email, $customer_phone, 
                                                $total_amount, $order_status, $payment_status, $payment_method, 
                                                $order_items);

            $_SESSION['success'] = true;
            $_SESSION['msg'] = 'Cập nhật đơn hàng thành công!';
            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit();

        } catch (Exception $e) {
            $_SESSION['success'] = false;
            $_SESSION['msg'] = $e->getMessage();
            header('Location: ' . BASE_URL_ADMIN . '&action=orders-index');
            exit();
        }
    }
}
?>
