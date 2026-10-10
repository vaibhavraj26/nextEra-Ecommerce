<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once __DIR__ . '/../src/database/Database.php';

$db = Database::getInstance();

$editProduct = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (isset($_POST['add_product'])) {
            $name = $_POST['name'];
            $quantity_xs = $_POST['quantity_xs'];
            $quantity_s = $_POST['quantity_s'];
            $quantity_m = $_POST['quantity_m'];
            $quantity_l = $_POST['quantity_l'];
            $quantity_xl = $_POST['quantity_xl'];
            $category_id = $_POST['category_id'];
            $price = $_POST['price'];
            $original_price = $_POST['original_price'];
            $description = $_POST['description'];
            $tags = $_POST['tags'];

            $images = [];
            for ($i = 1; $i <= 4; $i++) {
                if (!empty($_FILES["image_$i"]['name'])) {
                    $target_dir = "../uploads/product/";
                    $target_file = $target_dir . basename($_FILES["image_$i"]['name']);
                    if (move_uploaded_file($_FILES["image_$i"]['tmp_name'], $target_file)) {
                        $images[] = $target_file;
                    } else {
                        $_SESSION['error'] = "Failed to upload image: " . $_FILES["image_$i"]['name'];
                        header("Location: admin_product.php");
                        exit();
                    }
                }
            }

            $stmt = $db->prepare("INSERT INTO products (name, quantity_xs, quantity_s, quantity_m, quantity_l, quantity_xl, category_id, price, original_price, description, tags, images) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt->execute([$name, $quantity_xs, $quantity_s, $quantity_m, $quantity_l, $quantity_xl, $category_id, $price, $original_price, $description, $tags, implode(',', $images)])) {
                $_SESSION['success'] = "New product added successfully!";
            } else {
                $_SESSION['error'] = "Failed to add product.";
            }
        } elseif (isset($_POST['edit_product'])) {
            $id = $_POST['product_id'];
            $stmt = $db->prepare("SELECT * FROM products WHERE product_id = ?");
            $stmt->execute([$id]);
            $editProduct = $stmt->fetch(PDO::FETCH_ASSOC);
        } elseif (isset($_POST['update_product'])) {
            $id = $_POST['product_id'];
            $name = $_POST['name'];
            $quantity_xs = $_POST['quantity_xs'];
            $quantity_s = $_POST['quantity_s'];
            $quantity_m = $_POST['quantity_m'];
            $quantity_l = $_POST['quantity_l'];
            $quantity_xl = $_POST['quantity_xl'];
            $category_id = $_POST['category_id'];
            $price = $_POST['price'];
            $original_price = $_POST['original_price'];
            $description = $_POST['description'];
            $tags = $_POST['tags'];

            $stmt = $db->prepare("UPDATE products SET name = ?, quantity_xs = ?, quantity_s = ?, quantity_m = ?, quantity_l = ?, quantity_xl = ?, category_id = ?, price = ?, original_price = ?, description = ?, tags = ? WHERE product_id = ?");
            if ($stmt->execute([$name, $quantity_xs, $quantity_s, $quantity_m, $quantity_l, $quantity_xl, $category_id, $price, $original_price, $description, $tags, $id])) {
                $_SESSION['success'] = "Product updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update product.";
            }
        } elseif (isset($_POST['delete_product'])) {
            $id = $_POST['product_id'];

            $stmt = $db->prepare("DELETE FROM products WHERE product_id = ?");
            if ($stmt->execute([$id])) {
                $_SESSION['success'] = "Product deleted successfully!";
            } else {
                $_SESSION['error'] = "Failed to delete product.";
            }
        } elseif (isset($_POST['add_category'])) {
            $category_name = $_POST['category_name'];

            $stmt = $db->prepare("INSERT INTO categories (name) VALUES (?)");
            if ($stmt->execute([$category_name])) {
                $_SESSION['success'] = "New category added successfully!";
            } else {
                $_SESSION['error'] = "Failed to add category.";
            }
        } elseif (isset($_POST['delete_category'])) {
            $category_id = $_POST['category_id'];

            $stmt = $db->prepare("DELETE FROM categories WHERE category_id = ?");
            if ($stmt->execute([$category_id])) {
                $_SESSION['success'] = "Category deleted successfully!";
            } else {
                $_SESSION['error'] = "Failed to delete category.";
            }
        } elseif (isset($_POST['add_stock'])) {
            $id = $_POST['product_id'];
            $add_quantity_xs = $_POST['add_quantity_xs'] ?? 0;
            $add_quantity_s = $_POST['add_quantity_s'] ?? 0;
            $add_quantity_m = $_POST['add_quantity_m'] ?? 0;
            $add_quantity_l = $_POST['add_quantity_l'] ?? 0;
            $add_quantity_xl = $_POST['add_quantity_xl'] ?? 0;

            $stmt = $db->prepare("UPDATE products SET quantity_xs = quantity_xs + ?, quantity_s = quantity_s + ?, quantity_m = quantity_m + ?, quantity_l = quantity_l + ?, quantity_xl = quantity_xl + ? WHERE product_id = ?");
            if ($stmt->execute([$add_quantity_xs, $add_quantity_s, $add_quantity_m, $add_quantity_l, $add_quantity_xl, $id])) {
                $_SESSION['success'] = "Stock updated successfully!";
            } else {
                $_SESSION['error'] = "Failed to update stock.";
            }
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error: " . $e->getMessage();
    }

    header("Location: admin_product.php");
    exit();
}

try {
    $stmt = $db->query("SELECT * FROM products");
    $productsLs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $productCount = count($productsLs);
} catch (PDOException $e) {
    echo "Error fetching products: " . $e->getMessage();
    exit();
}

try {
    // Fetch categories from the database
    $categories = $db->query("SELECT category_id, name FROM categories")->fetchAll(PDO::FETCH_ASSOC);

    // Create an associative array for quick lookup
    $categoryLookup = [];
    foreach ($categories as $category) {
        $categoryLookup[$category['category_id']] = $category['name'];
    }
} catch (PDOException $e) {
    echo "Error fetching categories: " . $e->getMessage();
    exit();
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="../../public/css/tailwind.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <script src="https://unpkg.com/@tailwindcss/browser@4"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<style>
    /* Custom scrollbar styles */
    .scrollbar-thin::-webkit-scrollbar {
        width: 4px; /* Adjust the width of the scrollbar */
    }
    .scrollbar-thin::-webkit-scrollbar-track {
        background: #f1f1f1; /* Color of the track */
        border-radius: 3px; /* Rounded corners for the track */
    }
    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: #888; /* Color of the scrollbar thumb */
        border-radius: 3px; /* Rounded corners for the thumb */
    }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: #555; /* Color of the scrollbar thumb on hover */
    }
</style>

<body class="bg-gray-100 font-sans" x-data="{ showForm: false, showEditForm: false, showAddCategoryForm: false,
            showRemoveCategoryForm: false, editProduct: {}, showAddQuantityForm: false, selectedProduct: {} }">
<div class="flex h-screen" :class="{ 'blur-sm': showForm || showEditForm }">
    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-blue-900 text-white p-5 fixed space-y-6 h-screen ">
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        <nav>
            <a href="admin_dashboard.php" class="block px-2 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Dashboard</a>
            <a href="admin_user.php" class="block px-2 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Users</a>
            <a href="#" class="block px-2 py-2 my-2 rounded bg-blue-700 font-semibold text-lg">Products</a>
            <a href="admin_orders.php" class="block px-2 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Orders</a>
            <a href="admin_offer.php" class="block px-2 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Offer Banner</a>
            <a href="admin_setting.php" class="block px-2 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Settings</a>
        </nav>
    </aside>

    <!-- Toggle Button -->
    <!-- <button id="toggle-sidebar" class="fixed top-4 left-4 z-50 bg-blue-500 text-white py-2 px-4 rounded-full lg:hidden focus:outline-none focus:ring-2 focus:ring-blue-500">
        ☰
    </button> -->

    <!-- Main content -->

    <main class="flex-1 p-4 ml-64 overflow-x-hidden">

    <?php 
      if (session_status() === PHP_SESSION_NONE) {
      session_start();
}    ?>
    <?php if (isset($_SESSION['success'])): ?>
      <p class="text-green-500"><?php echo $_SESSION['success']; ?></p>
    <?php unset($_SESSION['success']); ?>
    <?php elseif (isset($_SESSION['error'])): ?>
      <p class="text-red-500"><?php echo $_SESSION['error']; ?></p>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>



      <h2 class="text-3xl font-semibold mb-6  ">Welcome, Admin!</h2>

      <!-- Stats Overview -->
      <div class="flex flex-row gap-6 ">
        <!-- //add product -->
        <div @click="showForm = true" class="bg-white px-5 py-2 rounded-xl shadow hover:text-blue-500 cursor-pointer w-32 h-36">
          <h3 class="text-lg font-medium">Add items (product)</h3>
          <img src="../public/resource/add1.png" alt="" class="w-20 h-20  p-4">
        </div>
        <!-- // Add Category  -->
        <div @click="showAddCategoryForm = true" class="bg-white px-5 py-2 rounded-xl shadow hover:text-blue-500 cursor-pointer w-32 h-36">
          <h3 class="text-lg font-medium">Add category</h3>
          <img src="../public/resource/add1.png" alt="" class="w-20 h-20  p-4">
        </div>
        <!-- //remove category -->
        <div @click="showRemoveCategoryForm = true" class="bg-white px-5 py-2 rounded-xl shadow hover:text-blue-500 cursor-pointer w-32  h-36">
          <h3 class="text-lg font-medium">delete category</h3>
          <img src="../public/resource/delete.png" alt="" class="w-20 h-20 p-4">
        </div>
      </div>

      <!-- Product List -->
      <div class="mt-10">
        <h1 class="text-xl font-semibold">Product List</h1>
        <p class="text-lg mb-4">Total Products: <?php echo $productCount; ?></p>
      </div>
        <!-- Scrollable Product List -->
        <div class="overflow-x-auto -mr-4  pb-4 h-[90vh]">
            <ul class="">
                <?php foreach ($productsLs as $product): ?>
                    <li class="bg-white p-2 rounded-lg shadow-md flex justify-between items-center mb-4 min-w-fit">
                        <div class="flex space-x-2 max-h-24">
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="bg-red-300 w-24 object-cover aspect-square">
                            
                            <div class="w-96 pl-2 bg-gray-100 overflow-y-auto scrollbar-thin rounded-lg">
                                <div class="relative group inline-block">
                                    <strong class="w-52 overflow-hidden text-ellipsis whitespace-nowrap inline-block" 
                                        title="<?php echo htmlspecialchars($product['name']); ?>">
                                        <?php echo htmlspecialchars($product['name']); ?>
                                    </strong>
                                </div>

                                <span>- ₹<?php echo htmlspecialchars($product['price']); ?> </span>
                                <span class="text-gray-600"> (₹<?php echo htmlspecialchars($product['original_price']) ?>) </span>
                                <p class="text-sm text-green-600">
                                    XS:<?php echo htmlspecialchars($product['quantity_xs']); ?>, 
                                    S:<?php echo htmlspecialchars($product['quantity_s']); ?>, 
                                    M:<?php echo htmlspecialchars($product['quantity_m']); ?>, 
                                    L:<?php echo htmlspecialchars($product['quantity_l']); ?>, 
                                    XL:<?php echo htmlspecialchars($product['quantity_xl']); ?> 
                                    <button @click="showAddQuantityForm = true; selectedProduct = <?php echo htmlspecialchars(json_encode($product)); ?>" class="text-yellow-600 hover:underline mx-2">Add Quantity</button>
                                </p>

                                <span>
                                    <?php $categoryId = $product['category_id'];
                                    if (isset($categoryLookup[$categoryId])) {
                                        echo '<span class="font-semibold text-blue-500">' . htmlspecialchars($categoryLookup[$categoryId]) . '</span>';
                                    } else {
                                        echo '<span style="color: red;">Error: Category not found</span>';
                                    }
                                    ?>
                                </span>
                                <p class="text-sm text-gray-500">Tags: <?php echo htmlspecialchars($product['tags']); ?></p>
                                
                            </div>
                            <div class="w-80 bg-gray-100 p-2 rounded-lg overflow-y-auto scrollbar-thin">
                                <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                            </div>
                            
                            
                        </div>
                        <div class="flex space-x-8 mx-8">
                            <button @click="showEditForm = true; editProduct = <?php echo htmlspecialchars(json_encode($product)); ?>" class="text-yellow-600 hover:underline font-semibold">Edit</button>

                            <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                <input type="hidden" name="id" value="<?php echo $product['product_id']; ?>">
                                <button type="submit" name="delete_product" class="text-red-500 font-semibold hover:underline">Delete</button>
                            </form>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
      
    </main>
  </div>

  <!-- Add Product Form Modal -->
  <div x-show="showForm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <form class="bg-white p-6 rounded-lg shadow-md w-3/5 overflow-y-auto scrollbar-thin overscroll-contain h-[95%] relative" method="POST" action="admin_product.php" enctype="multipart/form-data">
        <button type="button" class="sticky top-0 float-right text-white font-semibold p-2 bg-gray-700 rounded-full z-50" @click="showForm = false">❌</button>

        <!-- Form Header -->
        <h2 class="text-2xl font-bold mb-6">Add New Product</h2>

        <!-- Product Name -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold">Product Name</label>
            <input type="text" name="name" class="w-full p-3 border rounded" placeholder="Enter product name" required>
        </div>

        <!-- Product Sizes and Quantities -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Product Quantities by Size</h3>
            <div class="grid grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium">XS</label>
                    <input type="number" name="quantity_xs" class="w-full p-2 border rounded" placeholder="0" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium">S</label>
                    <input type="number" name="quantity_s" class="w-full p-2 border rounded" placeholder="0" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium">M</label>
                    <input type="number" name="quantity_m" class="w-full p-2 border rounded" placeholder="0" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium">L</label>
                    <input type="number" name="quantity_l" class="w-full p-2 border rounded" placeholder="0" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium">XL</label>
                    <input type="number" name="quantity_xl" class="w-full p-2 border rounded" placeholder="0" min="0">
                </div>
            </div>
        </div>

        <!-- Select Category -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold">Select Category</label>
            <select name="category_id" class="w-full p-3 border rounded" required>
                <option value="" disabled selected>Choose Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Pricing -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block mb-2 font-semibold">Sell Price / pc.</label>
                <input type="number" name="price" class="w-full p-3 border rounded" placeholder="Enter product sell price" required>
            </div>
            <div>
                <label class="block mb-2 font-semibold">Original Price / pc.</label>
                <input type="number" name="original_price" class="w-full p-3 border rounded" placeholder="Enter original price" required>
            </div>
        </div>

        <!-- Upload Multiple Images -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Product Images</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium">Image 1</label>
                    <input type="file" name="image_1" accept="image/*" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Image 2</label>
                    <input type="file" name="image_2" accept="image/*" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Image 3</label>
                    <input type="file" name="image_3" accept="image/*" class="w-full p-2 border rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Image 4</label>
                    <input type="file" name="image_4" accept="image/*" class="w-full p-2 border rounded">
                </div>
            </div>
        </div>

        <!-- Product Tags -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold">Custom Tags</label>
            <input type="text" name="tags" class="w-full p-3 border rounded" placeholder="Enter tags (e.g., Trending, New Arrival)">
        </div>

        <!-- Product Description -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold">Product Description</label>
            <textarea name="description" class="w-full p-3 border rounded" placeholder="Enter product details.." required></textarea>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between">
            <button type="submit" name="add_product" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">Save Product</button>
            <button type="button" @click="showForm = false" class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700">Go Back</button>
        </div>
    </form>
</div>

  <!-- Update Product Form Modal -->
  <div x-show="showEditForm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <form method="POST" class="bg-white p-6 rounded-lg shadow-md w-3/5 mx-auto relative overflow-y-auto scrollbar-thin overscroll-contain h-[95%]">
        <button type="button" class="sticky top-0 float-right text-white font-semibold p-2 bg-gray-700 rounded-full z-50" @click="showEditForm = false">❌</button>

        <!-- Form Header -->
        <h2 class="text-2xl font-bold mb-6">Update Product</h2>

        <input type="hidden" name="product_id" :value="editProduct.product_id">

        <!-- Product Name -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold">Product Name</label>
            <input type="text" name="name" :value="editProduct.name" class="w-full p-3 border rounded" placeholder="Enter product name" required>
        </div>

        <!-- Product Sizes and Quantities -->
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-4">Product Quantities by Size</h3>
            <div class="grid grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium">XS</label>
                    <input type="number" name="quantity_xs" :value="editProduct.quantity_xs" class="w-full p-2 border rounded" placeholder="0" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium">S</label>
                    <input type="number" name="quantity_s" :value="editProduct.quantity_s" class="w-full p-2 border rounded" placeholder="0" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium">M</label>
                    <input type="number" name="quantity_m" :value="editProduct.quantity_m" class="w-full p-2 border rounded" placeholder="0" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium">L</label>
                    <input type="number" name="quantity_l" :value="editProduct.quantity_l" class="w-full p-2 border rounded" placeholder="0" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium">XL</label>
                    <input type="number" name="quantity_xl" :value="editProduct.quantity_xl" class="w-full p-2 border rounded" placeholder="0" min="0">
                </div>
            </div>
        </div>

        <!-- Select Category -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold">Select Category</label>
            <select name="category_id" class="w-full p-3 border rounded" required>
                <option value="" disabled>Choose Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo htmlspecialchars($category['category_id']); ?>" 
                        :selected="editProduct.category_id == <?php echo htmlspecialchars($category['category_id']); ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Pricing -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block mb-2 font-semibold">Sell Price / pc.</label>
                <input type="number" name="price" :value="editProduct.price" class="w-full p-3 border rounded" placeholder="Enter product sell price" required>
            </div>
            <div>
                <label class="block mb-2 font-semibold">Original Price / pc.</label>
                <input type="number" name="original_price" :value="editProduct.original_price" class="w-full p-3 border rounded" placeholder="Enter original price" required>
            </div>
        </div>

        <!-- Product Tags -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold">Custom Tags</label>
            <input type="text" name="tags" :value="editProduct.tags" class="w-full p-3 border rounded" placeholder="Enter tags (e.g., Trending, New Arrival)">
        </div>

        <!-- Product Description -->
        <div class="mb-6">
            <label class="block mb-2 font-semibold">Product Description</label>
            <textarea name="description" class="w-full p-3 border rounded" placeholder="Enter product details.." x-text="editProduct.description" required></textarea>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between">
            <button type="submit" name="update_product" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">Update Product</button>
            <button type="button" @click="showEditForm = false" class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700">Go Back</button>
        </div>
    </form>
</div>

  <!-- Add Category Form Modal-->
  <div x-show="showAddCategoryForm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <form class="bg-white p-6 rounded-lg shadow-md w-1/3" method="POST" action="admin_product.php">
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Category Name</label>
            <input type="text" name="category_name" class="w-full p-2 border rounded" placeholder="Enter category name" required>
        </div>
        <div class="flex justify-between">
            <button type="submit" name="add_category" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Save Category</button>
            <button type="button" @click="showAddCategoryForm = false" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Go Back</button>
        </div>
    </form>
  </div>


<!-- Remove Category Form Modal-->
<div x-show="showRemoveCategoryForm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <form onsubmit="return confirm('Are you sure you want to delete the selected category?');" class="bg-white p-6 rounded-lg shadow-md w-1/3" method="POST" action="admin_product.php">
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Select Category to Delete</label>
            <select name="category_id" class="w-full p-2 border rounded" required>
                <?php
                foreach ($categories as $category):
                ?>
                    <option value="<?php echo htmlspecialchars($category['category_id']); ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex justify-between">
            <button type="submit"  name="delete_category" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Delete Category</button>
            <button type="button" @click="showRemoveCategoryForm = false" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">Go Back</button>
        </div>
    </form>
</div>

<!-- Add Quantity Form Modal -->
<div x-show="showAddQuantityForm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <form method="POST" class="bg-white p-6 rounded-lg shadow-md w-1/3 mx-auto relative">
        <button type="button" class="absolute top-2 right-2 text-white font-semibold p-2 bg-gray-700 rounded-full z-50" @click="showAddQuantityForm = false">❌</button>

        <!-- Form Header -->
        <h2 class="text-2xl font-bold mb-6">Add Quantity</h2>

        <input type="hidden" name="product_id" :value="selectedProduct.product_id">

        <!-- Product Name -->
        <div class="mb-4">
            <label class="block mb-2 font-semibold">Product Name</label>
            <input type="text" :value="selectedProduct.name" class="w-full p-3 border rounded bg-gray-100" readonly>
        </div>

        <!-- Add Quantities -->
        <div class="grid grid-cols-5 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium">XS</label>
                <input type="number" name="add_quantity_xs" class="w-full p-2 border rounded" placeholder="0" min="0">
            </div>
            <div>
                <label class="block text-sm font-medium">S</label>
                <input type="number" name="add_quantity_s" class="w-full p-2 border rounded" placeholder="0" min="0">
            </div>
            <div>
                <label class="block text-sm font-medium">M</label>
                <input type="number" name="add_quantity_m" class="w-full p-2 border rounded" placeholder="0" min="0">
            </div>
            <div>
                <label class="block text-sm font-medium">L</label>
                <input type="number" name="add_quantity_l" class="w-full p-2 border rounded" placeholder="0" min="0">
            </div>
            <div>
                <label class="block text-sm font-medium">XL</label>
                <input type="number" name="add_quantity_xl" class="w-full p-2 border rounded" placeholder="0" min="0">
            </div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between">
            <button type="submit" name="add_stock" class="bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">Add Stock</button>
            <button type="button" @click="showAddQuantityForm = false" class="bg-blue-500 text-white px-6 py-3 rounded hover:bg-blue-700">Cancel</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        const sidebar = document.getElementById("sidebar");
        const toggleButton = document.getElementById("toggle-sidebar");

        // Toggle sidebar visibility
        toggleButton.addEventListener("click", function () {
            if (sidebar.classList.contains("-translate-x-full")) {
                sidebar.classList.remove("-translate-x-full");
            } else {
                sidebar.classList.add("-translate-x-full");
            }
        });
    });
</script> -->

</body>
</html>