<?php
session_start();
require_once __DIR__ . '/../src/database/Database.php';

// Fetch product details from the database based on the ID
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check for alert message in session
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Alpine.store('alert').showMessage('" . addslashes($alert['message']) . "', '" . $alert['type'] . "');
            });
        </script>";
        unset($_SESSION['alert']); // Clear the alert after showing
    }

    $productId = $_GET['id'] ?? null;
    $productId = filter_var($productId, FILTER_SANITIZE_NUMBER_INT);
    if (!$productId) {
        header('Location: dashboard.php');
        exit();
    }

    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    // echo "<script>console.log(" . json_encode($product) . ");</script>";

    if (!$product) {
        echo "<script>
            Alpine.store('alert').showMessage('Product not found. Please report this to the admin.', 'warning');
            setTimeout(() => window.location.href = 'dashboard.php', 2000);
        </script>";
        exit();
    }
    // Fetch sizes and quantities
    $product['quantity_xs'] = $product['quantity_xs'] ?? 0;
    $product['quantity_s'] = $product['quantity_s'] ?? 0;
    $product['quantity_m'] = $product['quantity_m'] ?? 0;
    $product['quantity_l'] = $product['quantity_l'] ?? 0;
    $product['quantity_xl'] = $product['quantity_xl'] ?? 0;

    $product['image_url'] = $product['image_url'] ?? 'nextEra_default.jpg';
    $product['image_url2'] = $product['image_url2'] ?? 'nextEra_default.jpg';
    $product['image_url3'] = $product['image_url3'] ?? 'nextEra_default.jpg';
    $product['image_url4'] = $product['image_url4'] ?? 'nextEra_default.jpg';
    
    $totalStock = $product['quantity_xs'] + $product['quantity_s'] + $product['quantity_m'] + $product['quantity_l'] + $product['quantity_xl'];

    $sizes = [
        ['size' => 'XS', 'quantity' => $product['quantity_xs']],
        ['size' => 'S', 'quantity' => $product['quantity_s']],
        ['size' => 'M', 'quantity' => $product['quantity_m']],
        ['size' => 'L', 'quantity' => $product['quantity_l']],
        ['size' => 'XL', 'quantity' => $product['quantity_xl']]
    ];

    // Get the category ID of the current product
    $categoryId = $product['category_id'];

    // Fetch similar products (same category, excluding current product)
    $similarStmt = $db->prepare("SELECT * FROM products WHERE category_id = ? AND product_id != ?");
    $similarStmt->execute([$categoryId, $productId]);
    $similarProducts = $similarStmt->fetchAll();

    foreach ($similarProducts as &$similarProduct) {
        $similarProduct['image_url'] = $similarProduct['image_url'] ?? 'nextEra_default.jpg';
    }
    unset($similarProduct); // Unset reference to avoid accidental modifications
    
}

// adding to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['user']) || !isset($_SESSION['user']['user_id'])) {
        echo "<script>
        alert('Please login to add items to cart');
        window.location.href = 'login/login.php';
        </script>";
        exit();
    }

    $productId = $_POST['product_id'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    $price = $_POST['price'] ?? null;
    $size = $_POST['size'] ?? null;

    if (!$productId || !$quantity || $quantity < 1 || !$price) {
        $_SESSION['alert'] = [
            'message' => 'Error While Adding to Cart. Please report this to the admin.',
            'type' => 'warning'
        ];
        header("Location: Product.php?id=" . $productId);
        exit();
    }

    try {
        $userId = $_SESSION['user']['user_id'];
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO orders (user_id, product_id, size, quantity, price, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        $stmt->execute([$userId, $productId, $size, $quantity, $price]);

        $_SESSION['alert'] = [
            'message' => 'Item added to cart successfully!',
            'type' => 'success'
        ];
    } catch (PDOException $e) {
        $_SESSION['alert'] = [
            'message' => 'Error adding item to cart. Please try again.',
            'type' => 'warning'
        ];
    }

    header("Location: Product.php?id=" . $productId);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nextEra - <?php echo htmlspecialchars($product['name']); ?></title>
    <link href="css/tailwind.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-fade-out {
            animation: fadeOut 0.5s ease-out forwards;
        }

        @keyframes shiny-border-glow {
            0% {
                background-position: 0% 50%;
            }
            100% {
                background-position: 100% 50%;
            }
        }

        .animate-shiny-border-glow {
            background: linear-gradient(90deg,rgb(255, 0, 166),rgb(51, 51, 255),rgb(0, 242, 255),rgb(219, 175, 0));
            background-size: 300% 300%;
            animation: shiny-border-glow 4s linear infinite;
            border-radius: 9999px;
            filter: drop-shadow(0 0 6px rgb(207, 17, 160))
                    drop-shadow(0 0 8px rgb(13, 214, 150))
                    drop-shadow(0 0 10px rgb(198, 158, 10));
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: 0;
        }

    </style>
</head>

<body class="bg-gradient-to-br from-fuchsia-500/50 via-violet-600/30 to-blue-700/50">
    
    <!-- Alert -->
    <div x-data="{ showAlert: false }" class="fixed top-0 left-0 right-0 z-[9999] mt-16" x-show="$store.alert.show" x-transition:enter="animate-fade-in" x-transition:leave="animate-fade-out">
        <div class="p-4 mb-4 sm:w-1/2 w-fit mx-auto mt-1 text-sm rounded-xl font-normal shadow-lg"
            :class="$store.alert.type === 'success' ? 'text-green-600 bg-green-100' : 'text-amber-600 bg-amber-100'"
            role="alert">
            <div class="flex items-center">
                <span class="font-semibold mr-2" x-text="$store.alert.type === 'success' ? 'Success' : 'Warning'"></span>
                <span x-text="$store.alert.message"></span>
                <button @click="$store.alert.show = false" class="pl-3 ml-auto hover:opacity-70 transition-opacity">
                    <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.833497 9.16659L9.16683 0.833253M9.16683 9.16658L0.833496 0.833252" stroke="#9CA3AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Navbar -->
    <div class="navbar flex justify-between bg-white h-16 drop-shadow-md px-2 fixed w-full z-50">
        <div class="flex" x-data="{ open: false }">
            <img src="resource/nextEra.jpg" alt="logo" class="sm:h-10 h-8 sm:my-3 my-4" />
        </div>
        <div class="flex space-x-4 sm:mr-4 mr-2">
            <?php
            if (isset($_SESSION['user'])) {
                echo '<a href="order.php">
                    <img src="resource/order.png" alt="Order" class="sm:h-10 h-8 sm:m-3 my-4" /></a>
                    <a href="cart.php">
                    <img src="resource/cart.png" alt="Cart" class="sm:h-10 h-8 sm:m-3 my-4" /></a>
                    <a href="profile.php">
                    <img src="resource/profile1.png" alt="Profile" class="sm:h-12 h-10 sm:m-2 my-3 rounded-full" />
                    </a>';
            } else {
                echo '<button onclick="window.location.href=\'login/login.php\'" class="bg-gradient-to-r from-fuchsia-500 via-violet-600 to-blue-500 text-white h-10 my-3 px-6 font-semibold rounded-full hover:opacity-90 transition-opacity">Login</button>';
                }
                ?>

        </div>
    </div>

    <!-- Product Modal -->
    <div class=" flex flex-col z-50 ">
        <div class=" sm:mt-4  flex justify-center items-center">
            <div x-data="carousel()" 
                class="bg-white p-5 sm:rounded-t-lg sm:w-[80%] xl:w-[92%] w-full  h-full   xl:flex relative overflow-y-auto mt-16">
                <div
                    class="bg-red-200 xl:w-1/2 md:w-4/5 lg:w-3/5 w-full xl:h-full aspect-square xl:aspect-auto relative rounded-lg overflow-hidden md:mx-auto">
                    <!-- Images -->
                    <div class="relative flex transition-transform duration-500 w-full h-full"
                        :style="{ transform: `translateX(-${active * 100}%)` }">
                        <template x-for="(image, index) in images" :key="index">
                            <div class="w-full h-full flex-shrink-0 bg-green-200 aspect-square">
                                <img :src="image" alt="<?php echo htmlspecialchars($product['name']); ?>"
                                    class="w-full h-full object-cover">
                            </div>
                        </template>
                    </div>

                    <!-- Navigation Buttons -->
                    <button @click="prev()"
                        class="absolute top-1/2 left-0 transform -translate-y-1/2 bg-black text-white p-2 rounded-full focus:outline-none sm:border-4 border-2 border-white">
                        <svg class="sm:w-6 sm:h-6 w-4 h-4 text-white dark:text-gray-800" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 1 1.3 6.326a.91.91 0 0 0 0 1.348L7 13" />
                        </svg>
                    </button>

                    <button @click="next()"
                        class="absolute top-1/2 right-0 transform -translate-y-1/2 bg-black p-2 rounded-full focus:outline-none sm:border-4 border-2 border-white">
                        <svg class="sm:w-6 sm:h-6 w-4 h-4 text-white dark:text-gray-800" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 13 5.7-5.326a.909.909 0 0 0 0-1.348L1 1" />
                        </svg>
                    </button>

                    <!-- Indicators -->
                    <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                        <template x-for="(image, index) in images" :key="index">
                            <button @click="active = index"
                                :class="{ 'bg-gray-800': active === index, 'bg-gray-400': active !== index }"
                                class="w-3 h-3 rounded-full focus:outline-none">
                            </button>
                        </template>
                    </div>
                </div>
                <div class="xl:mx-8 xl:w-1/2 my-2" >
                    
                    <div x-data="{ tags: '<?php echo htmlspecialchars($product['tags']); ?>' }"
                        x-show="tags"
                        class="relative inline-block px-6 py-1 rounded-full font-semibold text-white bg-gray-800 text-md overflow-hidden"
                        @click="throwConfetti($event)">

                        <!-- Glowing Border -->
                        <span class="absolute inset-0 rounded-full animate-shiny-border-glow z-0"></span>

                        <!-- Tag Text -->
                        <span class="relative z-10" x-text="'🌟 ' + tags + ' 🌟'"></span>
                    </div>

                    <h2 class="text-xl font-bold mt-2"><?php echo htmlspecialchars($product['name']); ?></h2>
                    <p class="text-gray-700 mt-2 font-semibold">Price:
                        ₹<?php echo htmlspecialchars($product['price']); ?></p>
                    <p class="text-gray-500  line-through">Original Price:
                        ₹<?php echo htmlspecialchars($product['original_price']); ?></p>

                    <div class="mt-4">
                        <?php if ($totalStock > 0 && $totalStock <= 10): ?>
                            <div class="text-red-600 font-semibold">Hurry! Only <?= $totalStock ?> left</div>
                        <?php elseif ($totalStock <= 0): ?>
                            <div class="text-red-600 font-semibold">Out of Stock</div>
                        <?php else: ?>
                            <div class="text-green-600 font-semibold">High on sell! order now</div>
                        <?php endif; ?>
                    </div>
                    <p class="my-4">🌟Premium Products, Guaranteed Satisfaction!<br>💯 Trusted. Tested. 100%
                        Assured. </p>

                    <!-- size selector -->
                    <div x-data="{selectedSize: '', orderQuantity: 1, sizes: <?= htmlspecialchars(json_encode($sizes)) ?>, maxQuantity: 0, setSize(size) {
                        let selected = this.sizes.find(s => s.size === size);
                        this.maxQuantity = selected ? parseInt(selected.quantity) : 0;
                        this.orderQuantity = Math.min(1, this.maxQuantity);
                        this.selectedSize = size;
                        },
                        increaseQuantity() {
                        if (!this.selectedSize) {
                            $store.alert.showAlert();
                            return;
                        }
                        if (this.orderQuantity < this.maxQuantity) {
                            this.orderQuantity++;
                        }
                        },
                        decreaseQuantity() {
                        if (this.orderQuantity > 1) {
                            this.orderQuantity--;
                        }
                        },
                        validateBeforeSubmit() {
                        if (!this.selectedSize) {
                            $store.alert.showAlert();
                            event.preventDefault();
                        }
                        }
                        }">

                        <!-- Size Selector -->
                        <div class=" mx-auto border border-gray-300 rounded-lg p-4">
                            <h2 class=" font-semibold mb-4">Select Size</h2>
                            <div class="flex space-x-2">
                                <?php foreach ($sizes as $size): ?>
                                    <button @click="setSize('<?= $size['size'] ?>')" :class="{ 
                                    'border-blue-700 text-blue-700': selectedSize === '<?= $size['size'] ?>'
                                    }" class="flex flex-col items-center justify-center border rounded-xl p-2 w-16 text-sm font-medium hover:border-blue-700 hover:text-blue-700 transition
                                    <?= $size['quantity'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                        <?= $size['quantity'] <= 0 ? 'disabled' : '' ?>>
                                        <?= $size['size'] ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>

                            <!-- Display Selected Size -->
                            <div class="mt-4">
                                <span x-show="selectedSize" class="text-gray-700">
                                    Selected Size: <strong x-text="selectedSize"></strong>
                                </span>
                            </div>
                        </div>
                        <!-- Quantity Selector -->
                        <div class="flex mt-6">
                            <p class="font-semibold text-lg">Select Quantity: &nbsp;</p>
                            <div class="flex">
                                <button @click.prevent="decreaseQuantity()"
                                    class="bg-gray-300 hover:bg-gray-400 border-t border-b border-l border-black text-black px-4 py-1 rounded-l-lg" 
                                    :class="{ 'opacity-50 cursor-not-allowed': <?= $totalStock ?> <= 0 }"
                                    :disabled="<?= $totalStock ?> <= 0">➖</button>

                                <input type="text" x-model="orderQuantity"
                                    class="w-12 py-1 text-center border-t border-b border-black" readonly>

                                <button @click.prevent="increaseQuantity()"
                                    class="bg-gray-300 hover:bg-gray-400 border-t border-b border-r border-black text-black px-4 py-1 rounded-r-lg"
                                    :class="{ 'opacity-50 cursor-not-allowed': <?= $totalStock ?> <= 0 }"
                                    :disabled="<?= $totalStock ?> <= 0">➕</button>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <!-- Add to Cart Button -->
                            <form method="POST" action="Product.php?id=<?= $productId ?>" @submit="validateBeforeSubmit()" class="w-1/2">
                                <input type="hidden" name="product_id" value="<?= $productId ?>">
                                <input type="hidden" name="quantity" :value="orderQuantity">
                                <input type="hidden" name="price" :value="<?= $product['price'] ?>">
                                <input type="hidden" name="size" :value="selectedSize">

                                <button type="submit" class="mt-4 mb-4 bg-amber-50 font-semibold text-amber-900 box-border border-2 border-amber-900 py-2 rounded-lg w-full flex items-center justify-center  "
                                    :class="{ 'opacity-50 cursor-not-allowed': <?= $totalStock ?> <= 0 }"
                                    :disabled="<?= $totalStock ?> <= 0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                    Add to Cart&nbsp;(<span x-text="orderQuantity"></span>)
                                </button>
                            </form>

                            <!-- Buy Now Button -->
                            <form method="POST" action="payment.php" 
                                  @submit.prevent="validateBeforeSubmit() || checkLoginStatus()" 
                                  class="w-1/2">
                                <input type="hidden" name="product_id" value="<?= $productId ?>">
                                <input type="hidden" name="quantity" :value="orderQuantity">
                                <input type="hidden" name="price" :value="<?= $product['price'] ?>">
                                <input type="hidden" name="size" :value="selectedSize">

                                <button type="submit" class="mt-4 mb-4 bg-blue-600 box-border border-2 border-blue-400 text-white px-4 py-2 rounded-lg w-full flex items-center justify-center"
                                    :class="{ 'opacity-50 cursor-not-allowed': <?= $totalStock ?> <= 0 }"
                                    :disabled="<?= $totalStock ?> <= 0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                        <line x1="3" y1="6" x2="21" y2="6"></line>
                                    </svg>
                                    Buy Now&nbsp;(<span x-text="orderQuantity"></span>)
                                </button>
                            </form>

                        </div>
                    </div>
                    <p class="font-semibold mt-4 text-lg">Product Details:</p>
                    <p class="text-gray-600 mt-2 pb-4 mb-4 border border-gray-300 rounded-lg p-2">
                        <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                    </p>
                </div>
            </div>
        </div>
        <!-- similar products -->
        <div class=" mx-auto px-6 py-2 w-full h-full bg-white xl:w-[92%] sm:w-[80%]">
            <h2 class="text-2xl font-semibold mb-2">Similar Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 py-8">
                <!-- Product Card 1 -->

                <?php if (count($similarProducts) > 0): ?>
                    <?php foreach ($similarProducts as $similar): ?>
                        <div class="bg-white rounded-lg shadow-md p-2 transition-transform hover:scale-110 relative">
                            <a href="Product.php?id=<?= $similar['product_id'] ?>">
                                <!-- Tag Display -->
                                <?php if (!empty($similar['tags'])): ?>
                                    <div class="absolute top-2 right-2 bg-gray-800 text-white text-xs font-semibold px-4 py-1 rounded-tr-lg rounded-bl-lg border-white border-b-2 border-l-2">
                                        <?= htmlspecialchars($similar['tags']); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Product Image -->
                                <img src="../uploads/product/<?= htmlspecialchars($similar['image_url']) ?>"
                                    alt="<?= htmlspecialchars($similar['name']) ?>"
                                    class="w-full h-56 object-cover rounded-lg bg-red-200">

                                <!-- Product Details -->
                                <h3 class="text-lg font-semibold mt-2"><?= htmlspecialchars($similar['name']) ?></h3>
                                <p class="text-gray-600 mt-1">₹<?= htmlspecialchars($similar['price']) ?> &nbsp; 
                                    <span class="line-through">₹<?= htmlspecialchars($similar['original_price']) ?></span>
                                </p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-500">No similar products found.</p>
                <?php endif; ?>
            </div>
        </div>
        <footer class="flex mx-auto max-lg:flex-col lg:h-96 h-fit bg-white xl:w-[92%] sm:w-[80%] border-t-2 border-gray-500">
        <div class="flex flex-col p-10 lg:w-1/3 w-full lg:border-r-2 border-b-2 border-gray-500 h-full">
            <h1 class="text-4xl font-bold">nextEra</h1>
            <p class="text-xl mb-10">Wear Your Imagination</p>
            <strong>
                Follow us on Instagram:
                <a href="https://www.instagram.com/nextera_clothing/" class="text-blue-500" target="_blank">@nextEra</a>
                <br />
                Follow us on Facebook:
                <a href="https://www.facebook.com/nextera.clothing" class="text-blue-500" target="_blank">@nextEra</a>
                <br />
                Follow us on Twitter:
                <a href="https://x.com/nextera_clothing" class="text-blue-500" target="_blank">@nextEra</a>
            </strong>
        </div>
        <div class="flex flex-col items-center lg:w-1/3 w-full lg:border-r-2 border-b-2 border-gray-500 h-full">
            <h1 class="text-3xl font-semibold py-6">contact us</h1>
            <p class="text-md">
                <strong>
                    Email:
                    <a href="mailto:nextera@gmail.com" class="text-blue-500" target="_blank">nextera@gmail.com</a>
                    <br />
                    Phone:
                    <a href="tel:+919708681252" class="text-blue-500" target="_blank">+91 9708681252</a>
                    <br />
                    Whatsapp:
                    <a href="https://wa.me/919708681252" class="text-blue-500" target="_blank">+91 9708681252</a>
                    <br />
                    Address:
                    <a href="https://www.google.com/maps/place/123,+Main+Street,+Anytown,+India" class="text-blue-500"
                        target="_blank">123, Main Street, Anytown, India</a>
                </strong>
                <br />
            </p>
            <div class="flex justify-center items-center gap-x-4 mt-8 mb-4">
                <a class="w-10 h-10" target="_blank" href="https://www.instagram.com/nextera_clothing/">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path
                            d="M194.4 211.7a53.3 53.3 0 1 0 59.3 88.7 53.3 53.3 0 1 0 -59.3-88.7zm142.3-68.4c-5.2-5.2-11.5-9.3-18.4-12c-18.1-7.1-57.6-6.8-83.1-6.5c-4.1 0-7.9 .1-11.2 .1c-3.3 0-7.2 0-11.4-.1c-25.5-.3-64.8-.7-82.9 6.5c-6.9 2.7-13.1 6.8-18.4 12s-9.3 11.5-12 18.4c-7.1 18.1-6.7 57.7-6.5 83.2c0 4.1 .1 7.9 .1 11.1s0 7-.1 11.1c-.2 25.5-.6 65.1 6.5 83.2c2.7 6.9 6.8 13.1 12 18.4s11.5 9.3 18.4 12c18.1 7.1 57.6 6.8 83.1 6.5c4.1 0 7.9-.1 11.2-.1c3.3 0 7.2 0 11.4 .1c25.5 .3 64.8 .7 82.9-6.5c6.9-2.7 13.1-6.8 18.4-12s9.3-11.5 12-18.4c7.2-18 6.8-57.4 6.5-83c0-4.2-.1-8.1-.1-11.4s0-7.1 .1-11.4c.3-25.5 .7-64.9-6.5-83l0 0c-2.7-6.9-6.8-13.1-12-18.4zm-67.1 44.5A82 82 0 1 1 178.4 324.2a82 82 0 1 1 91.1-136.4zm29.2-1.3c-3.1-2.1-5.6-5.1-7.1-8.6s-1.8-7.3-1.1-11.1s2.6-7.1 5.2-9.8s6.1-4.5 9.8-5.2s7.6-.4 11.1 1.1s6.5 3.9 8.6 7s3.2 6.8 3.2 10.6c0 2.5-.5 5-1.4 7.3s-2.4 4.4-4.1 6.2s-3.9 3.2-6.2 4.2s-4.8 1.5-7.3 1.5l0 0c-3.8 0-7.5-1.1-10.6-3.2zM448 96c0-35.3-28.7-64-64-64H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96zM357 389c-18.7 18.7-41.4 24.6-67 25.9c-26.4 1.5-105.6 1.5-132 0c-25.6-1.3-48.3-7.2-67-25.9s-24.6-41.4-25.8-67c-1.5-26.4-1.5-105.6 0-132c1.3-25.6 7.1-48.3 25.8-67s41.5-24.6 67-25.8c26.4-1.5 105.6-1.5 132 0c25.6 1.3 48.3 7.1 67 25.8s24.6 41.4 25.8 67c1.5 26.3 1.5 105.4 0 131.9c-1.3 25.6-7.1 48.3-25.8 67z" />
                    </svg>
                </a>
                <a class="w-10 h-10" target="_blank" href="https://wa.me/919708681252">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path
                            d="M92.1 254.6c0 24.9 7 49.2 20.2 70.1l3.1 5-13.3 48.6L152 365.2l4.8 2.9c20.2 12 43.4 18.4 67.1 18.4h.1c72.6 0 133.3-59.1 133.3-131.8c0-35.2-15.2-68.3-40.1-93.2c-25-25-58-38.7-93.2-38.7c-72.7 0-131.8 59.1-131.9 131.8zM274.8 330c-12.6 1.9-22.4 .9-47.5-9.9c-36.8-15.9-61.8-51.5-66.9-58.7c-.4-.6-.7-.9-.8-1.1c-2-2.6-16.2-21.5-16.2-41c0-18.4 9-27.9 13.2-32.3c.3-.3 .5-.5 .7-.8c3.6-4 7.9-5 10.6-5c2.6 0 5.3 0 7.6 .1c.3 0 .5 0 .8 0c2.3 0 5.2 0 8.1 6.8c1.2 2.9 3 7.3 4.9 11.8c3.3 8 6.7 16.3 7.3 17.6c1 2 1.7 4.3 .3 6.9c-3.4 6.8-6.9 10.4-9.3 13c-3.1 3.2-4.5 4.7-2.3 8.6c15.3 26.3 30.6 35.4 53.9 47.1c4 2 6.3 1.7 8.6-1c2.3-2.6 9.9-11.6 12.5-15.5c2.6-4 5.3-3.3 8.9-2s23.1 10.9 27.1 12.9c.8 .4 1.5 .7 2.1 1c2.8 1.4 4.7 2.3 5.5 3.6c.9 1.9 .9 9.9-2.4 19.1c-3.3 9.3-19.1 17.7-26.7 18.8zM448 96c0-35.3-28.7-64-64-64H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96zM148.1 393.9L64 416l22.5-82.2c-13.9-24-21.2-51.3-21.2-79.3C65.4 167.1 136.5 96 223.9 96c42.4 0 82.2 16.5 112.2 46.5c29.9 30 47.9 69.8 47.9 112.2c0 87.4-72.7 158.5-160.1 158.5c-26.6 0-52.7-6.7-75.8-19.3z" />
                    </svg>
                </a>
                <a class="w-10 h-10" target="_blank" href="https://www.facebook.com/nextera.clothing">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z" />
                    </svg>
                </a>
                <a class="w-10 h-10" target="_blank" href="https://www.messenger.com/t/nextera.clothing">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M256.6 8C116.5 8 8 110.3 8 248.6c0 72.3 29.7 134.8 78.1 177.9 8.4 7.5 6.6 11.9 8.1 58.2A19.9 19.9 0 0 0 122 502.3c52.9-23.3 53.6-25.1 62.6-22.7C337.9 521.8 504 423.7 504 248.6 504 110.3 396.6 8 256.6 8zm149.2 185.1l-73 115.6a37.4 37.4 0 0 1 -53.9 9.9l-58.1-43.5a15 15 0 0 0 -18 0l-78.4 59.4c-10.5 7.9-24.2-4.6-17.1-15.7l73-115.6a37.4 37.4 0 0 1 53.9-9.9l58.1 43.5a15 15 0 0 0 18 0l78.4-59.4c10.4-8 24.1 4.5 17.1 15.6z" />
                    </svg>
                </a>
                <a class="w-10 h-10" target="_blank" href="https://x.com/nextera_clothing">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path
                            d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm297.1 84L257.3 234.6 379.4 396H283.8L209 298.1 123.3 396H75.8l111-126.9L69.7 116h98l67.7 89.5L313.6 116h47.5zM323.3 367.6L153.4 142.9H125.1L296.9 367.6h26.3z" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="flex flex-col p-8 gap-y-4 lg:w-1/3 w-full h-full border-b-2 border-gray-500">
            <div class="flex gap-x-4">
                <div class="w-1/2 h-24 ">
                    <h1 class="text-3xl text-center font-semibold">20k+</h1>
                    <p class="text-center">Happy Customers</p>
                </div>
                <div class="w-1/2 h-24 ">
                    <h1 class="text-3xl text-center font-semibold">1000+</h1>
                    <p class="text-center">Products Sold every day</p>
                </div>
            </div>
            <div class="flex gap-x-4">
                <div class="w-1/2 h-24 ">
                    <h1 class="text-3xl text-center font-semibold">25+</h1>
                    <p class="text-center">States of India</p>
                </div>
                <div class="w-1/2 h-24 ">
                    <h1 class="text-3xl text-center font-semibold">4.9 ★</h1>
                    <p class="text-center">Customer Rating</p>
                </div>
            </div>
            <div class="flex gap-x-4">
                <div class="w-1/2 h-24 ">
                    <h1 class="text-3xl text-center font-semibold">500+</h1>
                    <p class="text-center">Custom Designs Created</p>
                </div>
                <div class="w-1/2 h-24 ">
                    <h1 class="text-3xl text-center font-semibold">99%</h1>
                    <p class="text-center">Customer Satisfaction</p>
                </div>
            </div>
        </div>
        </footer>
    </div>

    <script>
        function carousel() {
            return {
                active: 0,
                images: [
                    '../uploads/product/<?php echo htmlspecialchars($product['image_url']); ?>',
                    '../uploads/product/<?php echo htmlspecialchars($product['image_url2']); ?>',
                    '../uploads/product/<?php echo htmlspecialchars($product['image_url3']); ?>',
                    '../uploads/product/<?php echo htmlspecialchars($product['image_url4']); ?>'
                ],
                next() {
                    this.active = (this.active + 1) % this.images.length;
                },
                prev() {
                    this.active = (this.active - 1 + this.images.length) % this.images.length;
                }
            }
        }

        document.addEventListener('alpine:init', () => {
            Alpine.store('alert', {
                show: false,
                type: 'warning',
                message: '',
                showMessage(message, type = 'warning') {
                    this.message = message;
                    this.type = type;
                    this.show = true;
                    setTimeout(() => {
                        this.show = false;
                    }, 3000);
                },
                showAlert() {
                    this.showMessage('Please select a size first', 'warning');
                }
            });
        });

        function checkLoginStatus() {
    const isLoggedIn = <?= isset($_SESSION['user']) ? 'true' : 'false' ?>;
    setTimeout(() => {
        if (!isLoggedIn) {
            const confirmRedirect = confirm("You are not logged in. log in now to continue... \n Click 'OK' to log in or 'Cancel' to stay on this page.");  
            if (confirmRedirect) {
                window.location.href = 'login/login.php';
            }
        } else {
            // Allow form submission if logged in
            document.querySelector('form[action="payment.php"]').submit();
        }
    }, 1500); // Delay of 1.5 second (1500ms)
    return false; // Prevent immediate form submission
}
    </script>
    <script>
    function throwConfetti(event) {
        const count = 30;
        const colors = ['#ff00cc', '#00ffcc', '#ffcc00', '#ffffff'];
        const parent = event.currentTarget;

        for (let i = 0; i < count; i++) {
            const particle = document.createElement('span');
            const size = Math.random() * 6 + 4 + 'px';

            particle.style.position = 'absolute';
            particle.style.width = size;
            particle.style.height = size;
            particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
            particle.style.borderRadius = '50%';
            particle.style.left = event.offsetX + 'px';
            particle.style.top = event.offsetY + 'px';
            particle.style.pointerEvents = 'none';
            particle.style.zIndex = 50;

            const angle = Math.random() * 360;
            const distance = Math.random() * 100;

            particle.style.transform = `translate(${Math.cos(angle) * distance}px, ${Math.sin(angle) * distance}px)`;
            particle.style.opacity = 1;
            particle.style.transition = 'transform 0.8s ease-out, opacity 0.8s ease-out';

            parent.appendChild(particle);

            setTimeout(() => {
                particle.style.opacity = 0;
                particle.remove();
            }, 800);
        }
    }
</script>
</body>

</html>