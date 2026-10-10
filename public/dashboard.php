<!-- <?php
// session_set_cookie_params([
    // 'lifetime' => 0,           // Cookie expires when the browser is closed
    // 'path' => '/',             // Cookie is available for the entire domain
    // 'domain' => '',            // Cookie is available for all subdomains
    // 'secure' => false,          // Only send cookies over HTTPS
    // 'httponly' => true,        // Prevent JavaScript access to cookies
    // 'samesite' => 'Strict'     // Prevent CSRF attacks
// ]);
// session_start();

// require_once '../src/models/User.php';
// require_once __DIR__ . '/../src/database/Database.php';
// 
// Prevent browser caching (Ensures back button does not take user to index)
// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// header("Pragma: no-cache");

// if (!isset($_SESSION['user']) && isset($_COOKIE['remember_token'])) {
    // $user = User::findByToken($_COOKIE['remember_token']);
    // if ($user) {
        // $_SESSION['user'] = $user; // Recreate session
    // } else {
        // Invalid token, clear cookie
//         setcookie('remember_token', '', time() - 3600, '/');
//     }
// }

// Fetch products from the database based on the selected category
// $db = Database::getInstance();

// Check if a category is selected
// $category_id = isset($_GET['category']) ? (int)$_GET['category'] : null;
// $category_id = filter_var($category_id, FILTER_SANITIZE_NUMBER_INT);

// // Build the SQL query
// $sql = "
//     SELECT 
//         p.product_id, 
//         p.name, 
//         p.description, 
//         p.original_price, 
//         p.price, 
//         p.category_id, 
//         p.tags,
//         p.image_url, 
//         p.image_url2, 
//         p.image_url3, 
//         p.image_url4, 
//         (p.quantity_xs + p.quantity_s + p.quantity_m + p.quantity_l + p.quantity_xl) AS total_quantity
//     FROM products p
//     " . ($category_id ? "WHERE p.category_id = :category_id" : "");

// // Prepare and execute the query
// $stmt = $db->prepare($sql);

// // Bind the category parameter only if a category is selected
// if ($category_id) {
//     $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
// }

// // Fetch products from the database
// $stmt->execute();
// $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// // Ensure a default image is set if no image is provided
// foreach ($products as &$product) {
//     $product['image_url'] = $product['image_url'] ?? 'nextEra_default.jpg';
// }
// unset($product); // Unset reference to avoid accidental modifications

// // Get all categories
// $stmt = $db->query("SELECT * FROM categories");
// $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $offerDir = __DIR__ . '/../uploads/poster/';
// $offerImages = [];

// // Scan the directory for image files
// if (is_dir($offerDir)) {
//     echo "<script>console.log('Fetching offer images...Directory found');</script>";
//     $files = scandir($offerDir);
//     if($files === false) {
//         echo "<script>console.error('Failed to scan offer directory.');</script>";
//     }
//     foreach ($files as $file) {
//         if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
//             $offerImages[] = '../uploads/poster/' . $file;  // Store relative path
//         }
//     }
//     if (empty($offerImages)) {
//         echo "<script>console.warn('No valid image files found in the directory.');</script>";
//     }
// }else {
//     echo "<script>console.error('Offer Directory does not found. Failed to find offer directory');</script>";
// }

?> -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nextEra clothing - Dashboard</title>
    <link rel="stylesheet" href="main.css">
    <script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        /* Custom scrollbar styles */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 2px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 2px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* For Firefox */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #888 #f1f1f1;
        }

        @keyframes breath {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }
        .breathing-arrow {
            animation: breath 2s ease-in-out infinite;
        }

        
        @keyframes blink-border {
        0%, 100% { border-color: #a5b4fc; } 
        50% { border-color:hsl(239, 94.40%, 72.00%); } 
        }
    </style>
</head>

<body class="bg-gradient-to-br from-fuchsia-500/50 via-violet-600/30 to-blue-700/50">
    <div class="fixed top-0 left-0 w-full bg-white h-6  z-50">
        <div class="max-md:hidden text-center font-semibold">
            <?php
            if (isset($_SESSION['user'])) {
                echo "Welcome to your nextEra... " . htmlspecialchars($_SESSION['user']['user_name']) . "!";
            } else {
                echo "Welcome to nextEra clothing! Please login to continue and avail offers.";
            }
            echo '<hr class="h-0.5 bg-gray-200" />';
            ?>

        </div>
        <!-- navbar -->
        <div class="navbar flex justify-between bg-white h-16 drop-shadow-md px-2 fixed w-full z-50">
            <div class="flex" x-data="{ open: false }">
                <img :src="open ? 'resource/hambopen.png' : 'resource/hambclose.png'"
                    @click="open = !open; $dispatch('toggle-menu', open)" alt="menu"
                    class="sm:h-12 h-10 sm:ml-4 sm:my-2 my-3 sm:mr-2 lg:hidden active:bg-slate-300 rounded-md" />
                <img src="resource/nextEra.jpg" alt="logo" class="sm:h-10 h-8 sm:my-3 my-4" />
            </div>
            <div class=" flex space-x-4 sm:mr-4 mr-2">
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
    </div>

    <!-- main container -->
    <main class="mainContainer flex mt-[5.5rem] max-md:mt-16">
        <!-- menu bar(category of products) -->
        <aside x-data="{ open: false }" @toggle-menu.window="open = $event.detail"
            :class="{'max-lg:hidden': !open, 'block': open}"
            class="bg-white h-[calc(100vh-5.5rem)] max-md:h-[calc(100vh-4rem)] fixed lg:block lg:w-1/6 w-48 z-50 overflow-y-auto overscroll-contain mb-12 custom-scrollbar">
            <h2 class="xl:text-xl text-lg text-center font-bold px-2 py-2 border-t-2 border-b-2 sticky top-0 text-gray-600 bg-white">Shop by Category</h2>
            <ul>
                <li><a href="dashboard.php"
                        <!-- class="block py-3 px-4 border-b-2 rounded-lg font-semibold <?= !isset($_GET['category']) ? 'bg-blue-500  text-white text-lg ' : '' ?>">All -->
                        Products</a></li>
                <?php foreach ($categories as $category): ?>
                    <li>
                        <a href="dashboard.php?category=<?= htmlspecialchars($category['category_id']) ?>"
                            class="block py-3 px-4 border-b-2 rounded-lg font-semibold  <?= isset($_GET['category']) && $_GET['category'] == $category['category_id'] ? 'bg-blue-500  text-white text-lg' : '' ?>">
                            <?= htmlspecialchars($category['name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <li class="block py-3 px-4 border-b-2 font-semibold">...</li>
            </ul>
        </aside>

        <!-- list of all items -->
        <div class="productDiv w-5/6 max-lg:w-full m-1 lg:ml-[17%] rounded-lg overscroll-contain"
            x-data="{ products: <?php echo htmlspecialchars(json_encode($products), ENT_QUOTES, 'UTF-8'); ?> }">

            <!--offer banner -->
            <div id="default-carousel" class="relative w-full" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative h-56 overflow-hidden rounded-2xl md:h-96 border-8  shadow-[0_0_20px_rgba(99,102,241,0.8)]" style="animation: blink-border 3s infinite; border-color:hsl(230, 100.00%, 75.30%);">
                    <?php if (!empty($offerImages)): ?>
                        <?php foreach ($offerImages as $index => $image): ?>

                            <div class="<?= $index === 0 ? '' : 'hidden' ?> duration-700 ease-in-out" data-carousel-item>
                                <img src="<?= htmlspecialchars($image) ?>" class="absolute w-full h-full "
                                    alt="offer <?= $index + 1 ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-lg font-semibold text-red-500">look like your internet is slow. <br> don't worry, offer applied on respected products.</p>
                    <?php endif; ?>
                </div>
                <!-- Slider indicators  rtl:space-x-reverse-->
                <div class="absolute z-30 flex justify-center w-full bottom-5 space-x-3 rtl:space-x-reverse">
                    <?php foreach ($offerImages as $index => $image): ?>
                        <button type="button" class="w-3 h-3 rounded-full" aria-label="Slide <?= $index + 1 ?>"
                            data-carousel-slide-to="<?= $index ?>"></button>
                    <?php endforeach; ?>
                </div>
                <!-- Slider controls -->
                <button type="button"
                    class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button"
                    class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
            
            <!-- additional features mid container -->
            <div class="grid sm:grid-cols-2 grid-cols-1 sm:mt-6 mt-4  place-items-center">
                <div onclick="window.location.href='customise.php'" class="flex bg-white/70 h-20 w-72 rounded-lg p-6 sm:m-4 m-2 shadow-md gap-x-4 hover:gap-x-6 items-center cursor-pointer">
                    <div class="flex flex-col justify-center">
                        <h1 class="text-lg font-semibold">Customise T-shirt's</h1>
                        <p class="text-sm text-gray-700">T-shirt's with your own design</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 320 512" class="breathing-arrow">
                        <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 
                        73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
                    </svg>
                </div>

                <div onclick="window.location.href='auction.php'" class="flex bg-white/70 h-20 w-72 rounded-lg p-6 sm:m-4 m-2 shadow-md gap-x-4 hover:gap-x-6 items-center cursor-pointer">
                    <div class="flex flex-col justify-center">
                        <h1 class="text-lg font-semibold">Bet Auction</h1>
                        <p class="text-sm text-gray-700">Dare to bet your favourite</p>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 320 512" class="breathing-arrow">
                        <path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 
                        73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/>
                    </svg>
                </div>
            </div>

            <div>
                <h1 class="text-2xl font-bold text-center mt-4">Explore Our Collection</h1>
                <p class="text-center text-gray-700 mb-4">Discover more, Style more, confidence more</p>
            </div>
            
            <!-- product items -->
            <div>
                <div class="itemList flex flex-wrap justify-between p-1 gap-y-2">
                    <template x-for="product in products" :key="product.product_id">
                        <a target="_blank" rel="noopener noreferrer" :href="'Product.php?id=' + product.product_id"
                            class="item w-[49.5%] bg-white border-black border-2 md:w-[24.5%] sm:w-[32.7%] rounded-lg relative z-10 cursor-pointer ">
                            
                            <div x-show="product.tags" 
                                class="z-50 absolute top-0 right-0 bg-black text-white text-xs font-semibold px-4 py-1 rounded-bl-lg rounded-tr-md border-white border-b-2 border-l-2"
                                x-text="product.tags">
                            </div>
                            
                            <div class="w-full h-0 pb-[100%] relative rounded-t-lg overflow-hidden">
                                <img :src="'../uploads/product/' + product.image_url" :alt="product.name"
                                    class="absolute top-0 left-0 w-full h-full object-cover bg-green-100">
                            </div>
                            <div class="p-2 bg-white rounded-b-lg flex flex-col">
                                <h3 class="font-bold" x-text="product.name"></h3>
                                <div class="flex gap-x-2">
                                    <p x-text="'₹' + product.price"></p>
                                    <p class="text-gray-500 line-through" x-text="'₹' + product.original_price"></p>
                                </div>
                                <div x-show="product.total_quantity > 0 && product.total_quantity <= 10"
                                    class="text-yellow-500 font-semibold">Only few left</div>
                                <div x-show="product.total_quantity <= 0" class="text-red-600 font-semibold">Out of
                                    Stock</div>
                            </div>
                        </a>
                    </template>
                </div>

                <!-- explore more -->
                <div class="w-full mt-10 h-14 rounded-lg bg-blue-500 text-white font-bold text-2xl text-center p-3">
                    <a href="https://www.instagram.com/vaibhavraj23076/" target="_blank">Explore More on instagram</a>
                </div>

                <!-- footer -->
                <footer class="footer flex justify-between bg-white h-96 mt-10 border-2 border-gray-500">
                    <div class="flex flex-col p-6 w-1/3 border-r-2 border-gray-500 h-full max-md:hidden ">
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
                    <div class="flex flex-col items-center p-6 w-1/3 max-md:w-1/2 max-sm:w-full border-r-2 border-gray-500 h-full">
                        <h1 class="text-2xl font-semibold pb-6 ">contact us</h1>
                        <p class="">
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
                        <div class="flex justify-center p-6 items-center gap-x-4 my-8 max-lg:w-[90%]">
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

                    <div class="flex flex-col p-8 gap-y-4 w-1/3 max-md:w-1/2 max-sm:hidden h-full">
                        <div class="flex gap-x-4">
                            <div class="w-1/2 h-24 ">
                                <h1 class="text-2xl text-center font-semibold max-md:text-2xl">20k+</h1>
                                <p class="text-center">Happy Customers</p>
                            </div>
                            <div class="w-1/2 h-24 ">
                                <h1 class="text-2xl text-center font-semibold max-md:text-2xl">1000+</h1>
                                <p class="text-center">Products Sold every day</p>
                            </div>
                        </div>
                        <div class="flex gap-x-4">
                            <div class="w-1/2 h-24 ">
                                <h1 class="text-2xl text-center font-semibold max-md:text-2xl">25+</h1>
                                <p class="text-center">States of India</p>
                            </div>
                            <div class="w-1/2 h-24 ">
                                <h1 class="text-2xl text-center font-semibold max-md:text-2xl">4.9 ★</h1>
                                <p class="text-center">Customer Rating</p>
                            </div>
                        </div>
                        <div class="flex gap-x-4">
                            <div class="w-1/2 h-24 ">
                                <h1 class="text-2xl text-center font-semibold max-md:text-2xl">500+</h1>
                                <p class="text-center">Custom Designs Created</p>
                            </div>
                            <div class="w-1/2 h-24 ">
                                <h1 class="text-2xl text-center font-semibold max-md:text-2xl">99%</h1>
                                <p class="text-center">Customer Satisfaction</p>
                            </div>
                        </div>
                    </div>
                </footer>

            </div>
        </div>
    </main>
    <button id="back-to-top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });" class="fixed bottom-4 right-4 bg-white border-4 border-black h-12 w-12 rounded-full shadow-lg z-50  align-center justify-center flex items-center">
    <svg xmlns="http://www.w3.org/2000/svg" width="28" viewBox="0 0 448 512">
        <path d="M246.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L224 109.3 361.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160zm160 352l-160-160c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L224 301.3 361.4 438.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3z"/></svg>
    </button>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>