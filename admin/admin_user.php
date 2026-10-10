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
        <a href="admin_dashboard.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700">Dashboard</a>
        <a href="#" class="block  px-4 py-2 my-2 rounded bg-blue-700">Users</a>
        <a href="admin_product.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700">Products</a>
        <a href="admin_orders.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700">Orders</a>
        <a href="admin_setting.php" class="block  px-4 py-2 my-2 rounded hover:bg-blue-700">Settings</a>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6">
      <h2 class="text-3xl font-semibold mb-6">Welcome, Admin!</h2>

      <!-- Stats Overview -->
      <div class="grid grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-xl shadow">
          <h3 class="text-xl font-medium">Total Users</h3>
          <p class="text-2xl font-bold">1,254</p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow">
          <h3 class="text-xl font-medium">Total Orders</h3>
          <p class="text-2xl font-bold">984</p>
        </div>
        <div class="bg-white p-5 rounded-xl shadow">
          <h3 class="text-xl font-medium">Revenue</h3>
          <p class="text-2xl font-bold">$45,320</p>
        </div>
      </div>

      <!-- Recent Activity -->
      <div class="mt-8">
        <h3 class="text-2xl font-medium mb-4">Recent Orders</h3>
        <div class="bg-white p-5 rounded-xl shadow">
          <table class="w-full text-left">
            <thead>
              <tr>
                <th class="py-2">Order ID</th>
                <th class="py-2">Customer</th>
                <th class="py-2">Status</th>
                <th class="py-2">Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="py-2">#001</td>
                <td class="py-2">John Doe</td>
                <td class="py-2 text-green-500">Completed</td>
                <td class="py-2">$120</td>
              </tr>
              <tr>
                <td class="py-2">#002</td>
                <td class="py-2">Jane Smith</td>
                <td class="py-2 text-yellow-500">Pending</td>
                <td class="py-2">$85</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
