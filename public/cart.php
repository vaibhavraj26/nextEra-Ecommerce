<?php
session_start();
require_once __DIR__ . '/../src/database/Database.php';

if (!isset($_SESSION['user'])) {
    header('Location: ./login/login.php');
    exit();
}

$userId = $_SESSION['user']['user_id'];
$db = Database::getInstance();

// Handle order cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_order'])) {
    $orderId = (int)$_POST['order_id'];
    $userId = $_SESSION['user']['user_id'];

    // Delete the order if it belongs to the logged-in user
    $stmt = $db->prepare("DELETE FROM orders WHERE order_id = ? AND user_id = ?");
    $stmt->execute([$orderId, $userId]);

    header('Location: cart.php');
    exit();
}

// Fetch pending orders
$pendingOrders = $db->prepare("
    SELECT orders.order_id, products.name, products.image_url, orders.quantity AS order_quantity, orders.total_price, orders.status, orders.size, product_variants.quantity AS size_quantity 
    FROM orders 
    JOIN products ON orders.product_id = products.product_id 
    JOIN product_variants ON orders.product_id = product_variants.product_id AND orders.size = product_variants.size
    WHERE orders.user_id = ? AND orders.status = 'pending'
");
$pendingOrders->execute([$userId]);
$pendingOrders = $pendingOrders->fetchAll(PDO::FETCH_ASSOC);

// Fetch confirmed orders
$confirmedOrders = $db->prepare("
    SELECT orders.order_id, products.name, products.image_url, orders.quantity AS order_quantity, orders.total_price, orders.status, orders.size, product_variants.quantity AS size_quantity 
    FROM orders 
    JOIN products ON orders.product_id = products.product_id 
    JOIN product_variants ON orders.product_id = product_variants.product_id AND orders.size = product_variants.size
    WHERE orders.user_id = ? AND orders.status != 'pending'
");
$confirmedOrders->execute([$userId]);
$confirmedOrders = $confirmedOrders->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nextEra - My Cart</title>
    <link href="css/tailwind.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-slate-300">

    <div class="fixed top-0 left-0 w-full bg-white h-6 drop-shadow-md z-50">
        <div class="max-md:hidden text-center font-bold">
            <?php
        echo "Welcome to your dashboard, " . htmlspecialchars($_SESSION['user']['user_name']) . "!";
        echo '<hr class="h-0.5 bg-gray-200">';
        ?>
        </div>

        <!-- navbar -->
        <div class="navbar flex justify-between bg-white h-16 drop-shadow-md px-2 fixed w-full z-50">
            <div class="flex" x-data="{ open: false }">
                <img src="resource/nextEra.jpg" alt="logo" class="h-10 my-3" />
            </div>
            <div class="flex space-x-1 sm:space-x-4 sm:mr-4">
                <a href="dashboard.php">
                    <img src="resource/home.png" alt="Home" class="h-10 m-3" />
                </a>
                <a href="profile.php">
                    <img src="resource/profile.png" alt="Profile" class="h-14 m-1" />
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto p-5 mt-20">
        <h1 class="text-3xl font-bold mb-5">🛒 My Cart</h1>

        <!-- Pending Orders Section -->
        <h2 class="text-2xl font-semibold mt-4 mb-4">⏳ Pending Orders</h2>
        <div class="space-y-4">
            <?php if (count($pendingOrders) > 0): ?>
            <?php foreach ($pendingOrders as $order): ?>
            <div class="bg-white p-2 rounded-lg shadow-md flex max-sm:flex-col sm:items-center justify-between">
                <div class="flex items-center">
                    <img src="../uploads/product/<?= htmlspecialchars($order['image_url']) ?>"
                        alt="<?= htmlspecialchars($order['name']) ?>"
                        class="bg-red-300 w-24 aspect-square object-cover rounded-md mr-4">
                    <div>
                        <h3 class="text-lg font-semibold"><?= htmlspecialchars($order['name']) ?></h3>
                        <p>Size: <?= htmlspecialchars($order['size']) ?></p>
                        <p>Ordered Quantity: <?= htmlspecialchars($order['order_quantity']) ?></p>
                        <p>Total: ₹<?= htmlspecialchars($order['total_price']) ?></p>

                        <!-- Display size stock status -->
                        <?php if ($order['size_quantity'] <= 0): ?>
                        <p class="text-red-600 font-semibold">Out of Stock</p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex max-sm:mx-auto block gap-x-2 mr-6">
                    <form method="POST" action="cart.php"
                        onsubmit="return confirm('Are you sure you want to cancel this order?');">
                        <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                        <button type="submit" name="remove_order"
                            class="bg-yellow-600 hover:bg-yellow-500 text-white px-4 py-2 mt-2 rounded-lg">
                            Remove Order
                        </button>
                    </form>
                    <form method="POST" action="payment.php">
                        <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 mt-2 rounded-lg <?= $order['size_quantity'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                            <?= $order['size_quantity'] <= 0 ? 'disabled' : '' ?>>
                            Proceed to Payment
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="text-gray-600">No pending orders.</p>
            <?php endif; ?>
        </div>

        <!-- Confirmed Orders Section -->
        <h2 class="text-2xl font-semibold mt-12 mb-4">✅ Confirmed Orders</h2>
        <div class="space-y-4">
            <?php if (count($confirmedOrders) > 0): ?>
            <?php foreach ($confirmedOrders as $order): ?>
            <div class="bg-white p-2 rounded-lg shadow-md flex items-center">
                <img src="../uploads/poster/<?= htmlspecialchars($order['image_url']) ?>"
                    alt="<?= htmlspecialchars($order['name']) ?>"
                    class="bg-red-300 w-24 aspect-square object-cover rounded-md mr-4">
                <div>
                    <h3 class="text-lg font-semibold"><?= htmlspecialchars($order['name']) ?></h3>
                    <p>Size: <?= htmlspecialchars($order['size']) ?></p>
                    <p>Quantity: <?= htmlspecialchars($order['order_quantity']) ?></p>
                    <p>Total: ₹<?= htmlspecialchars($order['total_price']) ?></p>
                    <p class="font-semibold <?= match($order['status']) {
                            'confirmed' => 'text-blue-600',
                            'shipped'   => 'text-yellow-600',
                            'cancelled' => 'text-red-600',
                            'delivered' => 'text-green-600',
                            default     => 'text-gray-600',
                        } ?>">Order <?= htmlspecialchars($order['status']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="text-gray-600">No confirmed orders yet.</p>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>