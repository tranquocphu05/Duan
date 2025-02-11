<?php
class OrderModel extends BaseModel
{
    protected $table = 'orders';

    // Hiển thị tất cả các đơn hàng
    public function showAll()
    {
        $sql = " 
        SELECT 
            o.order_id, 
            o.user_id, 
            u.full_name AS customer_name, 
            u.email AS customer_email, 
            u.phone_number AS customer_phone, 
            o.total_amount AS order_total, 
            o.status AS order_status, 
            o.payment_status AS payment_status, 
            o.payment_method AS payment_method, 
            o.created_at AS order_date, 
            oi.order_item_id, 
            oi.product_name, 
            oi.variant_name, 
            oi.quantity, 
            oi.price, 
            oi.total_price, 
            oi.product_image
        FROM Orders o
        JOIN Users u ON o.user_id = u.user_id
        JOIN Order_Items oi ON o.order_id = oi.order_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hiển thị chi tiết đơn hàng theo ID
    public function showAllID($order_id)
    {
        $sql = "SELECT 
                    o.order_id, 
                    o.user_id, 
                    u.full_name AS customer_name, 
                    u.email AS customer_email, 
                    u.phone_number AS customer_phone, 
                    o.total_amount AS order_total, 
                    o.status AS order_status, 
                    o.payment_status AS payment_status, 
                    o.payment_method AS payment_method, 
                    o.created_at AS order_date, 
                    oi.order_item_id, 
                    oi.product_name, 
                    oi.variant_name, 
                    oi.quantity, 
                    oi.price, 
                    oi.total_price, 
                    oi.product_image
                FROM Orders o
                JOIN Users u ON o.user_id = u.user_id
                JOIN Order_Items oi ON o.order_id = oi.order_id
                WHERE o.order_id = :order_id";  // Lọc theo order_id

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['order_id' => $order_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cập nhật đơn hàng và các mục sản phẩm trong đơn hàng
    public function updateOrderAndItems($order_id, $customer_name, $customer_email, $customer_phone, 
                                        $total_amount, $order_status, $payment_status, $payment_method, 
                                        $order_items) {
        try {
            // Bắt đầu giao dịch (transaction)
            $this->pdo->beginTransaction();

            // Cập nhật thông tin đơn hàng
            $sqlOrder = "UPDATE Orders o
                         JOIN Users u ON o.user_id = u.user_id
                         SET
                             u.full_name = :customer_name,
                             u.email = :customer_email,
                             u.phone_number = :customer_phone,
                             o.total_amount = :total_amount,
                             o.status = :order_status,
                             o.payment_status = :payment_status,
                             o.payment_method = :payment_method,
                             o.updated_at = NOW()
                         WHERE o.order_id = :order_id";

            $stmtOrder = $this->pdo->prepare($sqlOrder);
            $stmtOrder->execute([
                ':customer_name' => $customer_name,
                ':customer_email' => $customer_email,
                ':customer_phone' => $customer_phone,
                ':total_amount' => $total_amount,
                ':order_status' => $order_status,
                ':payment_status' => $payment_status,
                ':payment_method' => $payment_method,
                ':order_id' => $order_id
            ]);

            // Cập nhật các sản phẩm trong đơn hàng
            foreach ($order_items as $item) {
                $sqlItem = "UPDATE Order_Items oi
                            SET
                                oi.product_name = :product_name,
                                oi.variant_name = :variant_name,
                                oi.quantity = :quantity,
                                oi.price = :price,
                                oi.total_price = :total_price
                            WHERE oi.order_item_id = :order_item_id";

                $stmtItem = $this->pdo->prepare($sqlItem);
                $stmtItem->execute([
                    ':product_name' => $item['product_name'],
                    ':variant_name' => $item['variant_name'],
                    ':quantity' => $item['quantity'],
                    ':price' => $item['price'],
                    ':total_price' => $item['total_price'],
                    ':order_item_id' => $item['order_item_id']
                ]);
            }

            // Commit giao dịch sau khi cập nhật thành công
            $this->pdo->commit();

        } catch (Exception $e) {
            // Nếu có lỗi, rollback giao dịch và ném lỗi
            $this->pdo->rollBack();
            throw $e;  // Hoặc xử lý lỗi theo cách khác nếu cần
        }
    }

    // Thêm phương thức getAll() tương tự showAll()
    public function getAll()
    {
        return $this->showAll();
    }
}
