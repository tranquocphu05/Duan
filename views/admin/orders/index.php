<table class="table">
    <tr>
        <th>Order ID</th>
        <th>Customer Name</th>
        <th>Customer Email</th>
        <th>Customer Phone</th>
        <th>Total Amount</th>
        <th>Order Status</th>
        <th>Payment Status</th>
        <th>Payment Method</th>
        <th>Order Date</th>
        <th>Order Item ID</th>
        <th>Product Name</th>
        <th>Variant Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total Price</th>
        <th>Product Image</th>
        <th>Action</th> <!-- Thêm cột Action -->
    </tr>

    <?php foreach ($data as $order): ?>
        <tr>
            <td><?= $order['order_id'] ?></td>
            <td><?= $order['customer_name'] ?></td>
            <td><?= $order['customer_email'] ?></td>
            <td><?= $order['customer_phone'] ?></td>
            <td><?= number_format($order['order_total'], 2) ?></td>
            <td><?= $order['order_status'] ?></td>
            <td><?= $order['payment_status'] ?></td>
            <td><?= $order['payment_method'] ?></td>
            <td><?= date('d/m/Y H:i:s', strtotime($order['order_date'])) ?></td>
            <td><?= $order['order_item_id'] ?></td>
            <td><?= $order['product_name'] ?></td>
            <td><?= $order['variant_name'] ?></td>
            <td><?= $order['quantity'] ?></td>
            <td><?= number_format($order['price'], 2) ?></td>
            <td><?= number_format($order['total_price'], 2) ?></td>
            <td>
                <?php if (!empty($order['product_image'])): ?>
                    <img src="<?= BASE_ASSETS_UPLOADS . $order['product_image'] ?>" width="100px" alt="Product Image">
                <?php endif; ?>
            </td>
            <td>
                <!-- Nút xem chi tiết -->
                <a href="<?= BASE_URL_ADMIN . '&action=orders-show&id=' . $order['order_id'] ?>" class="btn btn-info">Xem Chi Tiết</a>
                
                <!-- Nút sửa -->
                <a href="<?= BASE_URL_ADMIN . '&action=orders-edit&id=' . $order['order_id'] ?>" class="btn btn-warning">Sửa</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
