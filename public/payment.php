<?php
session_start();
require_once __DIR__ . '/../src/database/Database.php';

if (!isset($_SESSION['user'])) {
    header('Location: ./login/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'] ?? null;

    if (!$orderId) {
        echo "Invalid order!";
        exit();
    }

    $db = Database::getInstance();

    // Get order details (including size)
    $stmt = $db->prepare("
        SELECT o.*, v.size, v.quantity AS size_quantity
        FROM orders o
        JOIN product_variants v ON o.product_id = v.product_id AND o.size = v.size
        WHERE o.order_id = ? AND o.user_id = ? AND o.status = 'pending'
    ");
    $stmt->execute([$orderId, $_SESSION['user']['user_id']]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$order) {
        echo "Order not found or already confirmed!";
        exit();
    }
    // Mock payment success
    if (isset($_POST['confirm_payment'])) {
        // Update order status to 'confirmed'
        $updateOrder = $db->prepare("UPDATE orders SET status = 'confirmed' WHERE order_id = ?");
        $updateOrder->execute([$orderId]);

        // Fetch product and size-specific quantity
        $productId = $order['product_id'];
        $orderedQuantity = $order['quantity'];
        $size = $order['size'];

        // Update the size-specific stock in product_variants
        $updateVariant = $db->prepare("
            UPDATE product_variants 
            SET quantity = GREATEST(quantity - ?, 0) 
            WHERE product_id = ? AND size = ?
        ");
        $updateVariant->execute([$orderedQuantity, $productId, $size]);

        header('Location: cart.php?payment=success');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>nextEra Payment</title>
    <link href="css/tailwind.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-slate-300">
    <div class="container mx-auto p-5">
        <h1 class="text-3xl font-bold mb-5">💳 Payment</h1>
        <div class="bg-white p-5 rounded-lg shadow-md">
            <p>Order ID: <?= htmlspecialchars($order['order_id']) ?></p>
            <p>Product ID: <?= htmlspecialchars($order['product_id']) ?></p>
            <p>Size: <?= htmlspecialchars($order['size']) ?></p>
            <p>Ordered Quantity: <?= htmlspecialchars($order['quantity']) ?></p>
            <p>Total Amount: ₹<?= htmlspecialchars($order['total_price']) ?></p>

            <form method="POST">
                <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                <button type="submit" name="confirm_payment" class="bg-green-500 text-white px-4 py-2 rounded-lg">
                    Confirm Payment
                </button>
            </form>
        </div>
    </div>
</body>

</html>