<form method="POST" action="<?= BASE_URL_ADMIN ?>&action=orders-update">
    <input type="hidden" name="order_id" value="<?= isset($orderDetails[0]['order_id']) ? $orderDetails[0]['order_id'] : '' ?>">

    <label for="customer_name">Customer Name</label>
    <input type="text" id="customer_name" name="customer_name" value="<?= isset($orderDetails[0]['customer_name']) ? $orderDetails[0]['customer_name'] : '' ?>">

    <label for="customer_email">Customer Email</label>
    <input type="email" id="customer_email" name="customer_email" value="<?= isset($orderDetails[0]['customer_email']) ? $orderDetails[0]['customer_email'] : '' ?>">

    <label for="customer_phone">Customer Phone</label>
    <input type="text" id="customer_phone" name="customer_phone" value="<?= isset($orderDetails[0]['customer_phone']) ? $orderDetails[0]['customer_phone'] : '' ?>">

    <label for="total_amount">Total Amount</label>
    <input type="text" id="total_amount" name="total_amount" value="<?= isset($orderDetails[0]['order_total']) ? $orderDetails[0]['order_total'] : '' ?>">

    <label for="order_status">Order Status</label>
    <select id="order_status" name="order_status">
        <option value="pending" <?= isset($orderDetails[0]['order_status']) && $orderDetails[0]['order_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="completed" <?= isset($orderDetails[0]['order_status']) && $orderDetails[0]['order_status'] == 'completed' ? 'selected' : '' ?>>Completed</option>
        <!-- Add other statuses as needed -->
    </select>

    <label for="payment_status">Payment Status</label>
    <select id="payment_status" name="payment_status">
        <option value="pending" <?= isset($orderDetails[0]['payment_status']) && $orderDetails[0]['payment_status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
        <option value="paid" <?= isset($orderDetails[0]['payment_status']) && $orderDetails[0]['payment_status'] == 'paid' ? 'selected' : '' ?>>Paid</option>
        <!-- Add other statuses as needed -->
    </select>

    <label for="payment_method">Payment Method</label>
    <select id="payment_method" name="payment_method">
        <option value="credit_card" <?= isset($orderDetails[0]['payment_method']) && $orderDetails[0]['payment_method'] == 'credit_card' ? 'selected' : '' ?>>Credit Card</option>
        <option value="paypal" <?= isset($orderDetails[0]['payment_method']) && $orderDetails[0]['payment_method'] == 'paypal' ? 'selected' : '' ?>>PayPal</option>
        <!-- Add other methods as needed -->
    </select>

    <h3>Order Items</h3>
    <?php if (isset($orderDetails) && is_array($orderDetails)) : ?>
        <?php foreach ($orderDetails as $item) : ?>
            <div class="order-item">
                <input type="hidden" name="order_item_id[]" value="<?= $item['order_item_id'] ?>">
                
                <label for="product_name_<?= $item['order_item_id'] ?>">Product Name</label>
                <input type="text" id="product_name_<?= $item['order_item_id'] ?>" name="product_name[]" value="<?= $item['product_name'] ?>">

                <label for="variant_name_<?= $item['order_item_id'] ?>">Variant Name</label>
                <input type="text" id="variant_name_<?= $item['order_item_id'] ?>" name="variant_name[]" value="<?= $item['variant_name'] ?>">

                <label for="quantity_<?= $item['order_item_id'] ?>">Quantity</label>
                <input type="number" id="quantity_<?= $item['order_item_id'] ?>" name="quantity[]" value="<?= $item['quantity'] ?>">

                <label for="price_<?= $item['order_item_id'] ?>">Price</label>
                <input type="text" id="price_<?= $item['order_item_id'] ?>" name="price[]" value="<?= $item['price'] ?>">

                <label for="total_price_<?= $item['order_item_id'] ?>">Total Price</label>
                <input type="text" id="total_price_<?= $item['order_item_id'] ?>" name="total_price[]" value="<?= $item['total_price'] ?>">
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <button type="submit">Cập nhật</button>
</form>
