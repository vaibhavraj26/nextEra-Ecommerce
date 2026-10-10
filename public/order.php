

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    $price = $_POST['price'] ?? null;
    $size = $_POST['size'] ?? null;

    if (!$productId || !$quantity || $quantity < 1 || !$price) {
        echo "Invalid order data.";
        exit();
    }

    //$totalPrice = $quantity * $price; // auto calculate total_price in the database
    $userId = $_SESSION['user']['user_id']; // Assuming user is logged in and session contains user info

    $db = Database::getInstance();
    $stmt = $db->prepare("INSERT INTO orders (user_id, product_id, size, quantity, price, status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->execute([$userId, $productId, $size, $quantity, $price]);

    header('Location: cart.php');
    exit();
}
