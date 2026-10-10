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
      try {
        $stmt = $db->query("SELECT 
          o.id AS order_id,
          u.name AS customer_name,
          o.quantity,
          o.total_price,
          o.status,
          o.created_at
      FROM orders o
      JOIN users u ON o.user_id = u.id
      ORDER BY 
            o.status = 'confirmed' ASC, -- Pending orders first
            o.created_at DESC");
      $recentOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
      } catch (PDOException $e) {
      $recentOrders = [];
      error_log("Database error: " . $e->getMessage()); // Log the error
    }
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
    <aside class="w-64 bg-blue-900 text-white p-5 space-y-6  h-screen">
      <h1 class="text-2xl font-bold">Admin Dashboard</h1>
      <nav>
        <a href="admin_dashboard.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700">Dashboard</a>
        <a href="admin_user.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700">Users</a>
        <a href="admin_product.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700">Products</a>
        <a href="#" class="block  px-4 py-2 my-2 rounded bg-blue-700">Orders</a>
        <a href="admin_setting.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700">Settings</a>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 px-6 py-2">
      <h2 class="text-3xl font-semibold mb-4">Welcome, Admin!</h2>

      <!-- Stats Overview -->
      <div class="grid grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-xl shadow">
          <h3 class="text-xl font-medium">Total Users</h3>
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
      <div class="mt-6">
        <h3 class="text-2xl font-medium ">Recent Orders </h3>
        <div class="flex">
            <p class="text-green-600">Completed:123 &nbsp; &nbsp;</p>
            <p class="text-red-500">Pending:123</p>
        </div>
        <div class="bg-white px-5 rounded-xl shadow mt-2 h-80 overflow-y-auto">
          <table class="w-full text-left">
            <thead class="sticky top-0 bg-white ">
              <tr>
              <th class="py-4">Order ID</th>
              <th class="py-4">Customer</th>
              <th class="py-4">Quantity</th>
              <th class="py-4">Total Price</th>
              <th class="py-4">Status</th>
              <th class="py-4">Date</th>
              </tr>
            </thead>
              <tbody class="divide-y  ">
                <?php if (!empty($recentOrders)): ?>
                  <?php foreach ($recentOrders as $order): ?>
                    <tr>
                      <td class="py-2">#<?php echo htmlspecialchars($order['order_id']); ?></td>
                      <td class="py-2"><?php echo htmlspecialchars($order['customer_name']); ?></td>
                      <td class="py-2"><?php echo htmlspecialchars($order['quantity']); ?></td>
                      <td class="py-2">$<?php echo htmlspecialchars($order['total_price']); ?></td>
                      <td class="py-2 <?php echo $order['status'] === 'confirmed' ? 'text-green-500' : 'text-yellow-500'; ?>">
                        <?php echo htmlspecialchars($order['status']); ?>
                      </td>
                      <td class="py-2"><?php echo htmlspecialchars(date("d - m - Y", strtotime($order['created_at']))); ?></td>
                      <!-- Format to display only the date -->
                      
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="py-2 text-center">No recent orders found.</td>
                  </tr>
                <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
