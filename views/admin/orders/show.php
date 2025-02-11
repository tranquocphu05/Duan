<h1>Chi tiết đơn hàng có ID = <?php echo $orderDetails[0]['order_id']; ?></h1>

<table class="table">
    <tr>
        <th>TRƯỜNG DỮ LIỆU</th>
        <th>GIÁ TRỊ</th>
    </tr>

    <!-- Hiển thị thông tin khách hàng -->
    <tr>
        <th>Tên khách hàng</th>
        <td><?php echo $orderDetails[0]['customer_name']; ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo $orderDetails[0]['customer_email']; ?></td>
    </tr>
    <tr>
        <th>Số điện thoại</th>
        <td><?php echo $orderDetails[0]['customer_phone']; ?></td>
    </tr>
    
    <!-- Hiển thị thông tin đơn hàng -->
    <tr>
        <th>Trạng thái đơn hàng</th>
        <td><?php echo $orderDetails[0]['order_status']; ?></td>
    </tr>
    <tr>
        <th>Trạng thái thanh toán</th>
        <td><?php echo $orderDetails[0]['payment_status']; ?></td>
    </tr>
    <tr>
        <th>Phương thức thanh toán</th>
        <td><?php echo $orderDetails[0]['payment_method']; ?></td>
    </tr>
    <tr>
        <th>Tổng giá trị đơn hàng</th>
        <td><?php echo $orderDetails[0]['order_total']; ?> VND</td>
    </tr>
    <tr>
        <th>Ngày đặt</th>
        <td><?php echo $orderDetails[0]['order_date']; ?></td>
    </tr>
</table>

<h3>Danh sách sản phẩm trong đơn hàng:</h3>
<table class="table">
    <tr>
        <th>Product Name</th>
        <th>Variant</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total Price</th>
    </tr>
    <?php foreach ($orderDetails as $item): ?>
        <tr>
            <td><?php echo $item['product_name']; ?></td>
            <td><?php echo $item['variant_name']; ?></td>
            <td><?php echo $item['quantity']; ?></td>
            <td><?php echo $item['price']; ?> VND</td>
            <td><?php echo $item['total_price']; ?> VND</td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="<?= BASE_URL_ADMIN . '&action=orders-index' ?>" class="btn btn-danger">Quay lại danh sách đơn hàng</a>
