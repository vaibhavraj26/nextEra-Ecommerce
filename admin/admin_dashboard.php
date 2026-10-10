<?php
      require_once __DIR__ . '/../src/database/Database.php';
      $db = Database::getInstance();

      // Fetch user count
      try {
          $stmt = $db->query("SELECT COUNT(*) AS user_count FROM users");
          $userCount = $stmt->fetch(PDO::FETCH_ASSOC)['user_count'];
      } catch (PDOException $e) {
          $userCount = 'Error fetching user count';
          error_log("Database error: " . $e->getMessage()); // Log the error

      }

      // Fetch order count
      try {
          $stmt = $db->query("SELECT COUNT(*) AS order_count FROM orders");
          $orderCount = $stmt->fetch(PDO::FETCH_ASSOC)['order_count'];
      } catch (PDOException $e) {
          $orderCount = 'Error fetching order count';
          error_log("Database error: " . $e->getMessage()); // Log the error
      }

      // Fetch recent orders

      ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://unpkg.com/alpinejs" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-blue-900 text-white p-5 space-y-6">
      <h1 class="text-2xl font-bold">Admin Dashboard</h1>
      <nav>
        <a href="#" class="block  px-4 py-2 my-2 rounded bg-blue-700 font-semibold text-lg">Dashboard</a>
        <a href="admin_user.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Users</a>
        <a href="admin_product.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Products</a>
        <a href="admin_orders.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Orders</a>
        <a href="admin_offer.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Offer Banner</a>
        <a href="admin_setting.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Settings</a>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6">
      <h2 class="text-3xl font-semibold mb-6">Welcome, Admin!</h2>

      <!-- Stats Overview -->
      <div class="grid grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-xl shadow">
          <h3 class="text-xl font-medium">Active Users</h3>
          <p class="text-2xl font-bold"><?php echo htmlspecialchars($userCount); ?></p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow">
          <h3 class="text-xl font-medium">Total Orders</h3>
          <p class="text-2xl font-bold"><?php echo htmlspecialchars($orderCount); ?></p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow">
          <h3 class="text-xl font-medium">Revenue</h3>
          <p class="text-2xl font-bold">$45,320</p>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="mt-8">
        <h3 class="text-2xl font-medium ">Recent Orders </h3>
        <p class="text-green-600">Completed:123</p>
        <p class="text-red-500">Pending:123</p>
        <div class="bg-white p-5 rounded-xl shadow mt-2">
          <table class="w-full text-left">
            <thead>
              <tr>
              <th class="py-2">Order ID</th>
              <th class="py-2">Customer</th>
              <th class="py-2">Quantity</th>
              <th class="py-2">Total Price</th>
              <th class="py-2">Status</th>
              <th class="py-2">Date</th>
              </tr>
            </thead>
              <tbody>
                
                  <td class="py-2">1</td>
                  <td class="py-2">John</td>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
