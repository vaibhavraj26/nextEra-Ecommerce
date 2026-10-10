<?php
session_start(); 


$offerDir = __DIR__ . '/../uploads/poster/';


if (!is_dir($offerDir)) {
    mkdir($offerDir, 0755, true);
}

// Handle Image Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['offer_image'])) {
    $file = $_FILES['offer_image'];
    $fileName = basename($file['name']);
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    // Allowed file types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (in_array($fileType, $allowedTypes)) {
        $targetFile = $offerDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $_SESSION['successMessage'] = "Image uploaded successfully!";
        } else {
            $_SESSION['errorMessage'] = "Error uploading image.";
        }
    } else {
        $_SESSION['errorMessage'] = "Invalid file type.";
    }

    // Redirect to avoid form resubmission
    header("Location: admin_offer.php");
    exit;
}

// Handle Image Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_image'])) {
    $imageToDelete = $_POST['delete_image'];
    $filePath = $offerDir . $imageToDelete;

    if (file_exists($filePath)) {
        unlink($filePath);
        $_SESSION['successMessage'] = "Image deleted successfully!";
    } else {
        $_SESSION['errorMessage'] = "File not found.";
    }

    // Redirect to avoid form resubmission
    header("Location: admin_offer.php");
    exit;
}

// Fetch all images from the offer directory
$offerImages = [];
if (is_dir($offerDir)) {
    $files = scandir($offerDir);
    foreach ($files as $file) {
        if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
            $offerImages[] = $file;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Offers</title>
    <link href="../src/css/tailwind.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #message-container {
            transition: opacity 0.5s ease-out; /* Smooth fade-out effect */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-blue-900 text-white p-5 fixed space-y-6 h-screen transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-50">
            <h1 class="text-2xl max-lg:pt-10 font-bold">Admin Dashboard</h1>
            <nav>
                <a href="admin_dashboard.php" class="block px-2 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Dashboard</a>
                <a href="admin_user.php" class="block px-2 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Users</a>
                <a href="admin_product.php" class="block px-2 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Products</a>
                <a href="admin_orders.php" class="block px-2 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Orders</a>
                <a href="#" class="block px-2 py-2 my-2 rounded bg-blue-700 font-semibold text-lg">Offer Banner</a>
                <a href="admin_setting.php" class="block px-2 py-2 my-2 rounded hover:bg-blue-700 font-semibold text-lg">Settings</a>
            </nav>
        </aside>

        <!-- Toggle Button -->
        <button id="toggle-sidebar" class="fixed lg:hidden top-4 left-4 z-50 bg-blue-500 text-white py-2 px-4 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            ☰
        </button>

        <div class="container p-8 lg:ml-64 mx-auto max-lg:mt-16">
            <h1 class="text-3xl font-bold mb-6">Manage Offer Images</h1>

            <!-- Display Success/Error Message -->
            <div id="message-container">
                <?php if (isset($_SESSION['successMessage'])): ?>
                    <div class="bg-green-200 text-green-700 p-4 rounded-md mb-4"><?= htmlspecialchars($_SESSION['successMessage']) ?></div>
                    <?php unset($_SESSION['successMessage']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['errorMessage'])): ?>
                    <div class="bg-red-200 text-red-700 p-4 rounded-md mb-4"><?= htmlspecialchars($_SESSION['errorMessage']) ?></div>
                    <?php unset($_SESSION['errorMessage']); ?>
                <?php endif; ?>
            </div>

            <!-- Upload Form -->
            <form action="admin_offer.php" method="POST" enctype="multipart/form-data" class="mb-6">
                <label class="block font-bold mb-2">Upload New Image:  
                    <span class="font-semibold text-red-500 mb-2"> Allowed Types = [jpg, jpeg, png, gif, webp]</span>
                </label>
                <div class="relative" >
                    <input type="file" name="offer_image" accept="image/*" required 
                        class="border-2 p-2 rounded-l border-blue-500 md:pr-20" >
                    <button type="submit" 
                        class="-mx-2 bg-blue-500 text-white px-5 py-3 rounded-r hover:bg-blue-700 ">
                        Upload
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 lg:grid-cols-3 sm:grid-cols-2 gap-4">
                <?php if (!empty($offerImages)): ?>
                    <?php foreach ($offerImages as $image): ?>
                        <div class="relative border p-2 bg-white rounded-lg shadow-md">
                            <img src="../uploads/poster/<?= htmlspecialchars($image) ?>" alt="Offer Image" class="w-full h-48 object-cover rounded">
                            <div class="mt-2 flex justify-between items-center">
                                <p><?= htmlspecialchars($image) ?></p>
                                <form action="admin_offer.php" method="POST" class="inline" onsubmit="return confirmDelete();">
                                    <input type="hidden" name="delete_image" value="<?= htmlspecialchars($image) ?>">
                                    <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-700">Delete</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="col-span-3 text-center text-gray-600">No offer images available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

<script>
    // Wait for the DOM to load
    document.addEventListener("DOMContentLoaded", function () {
        // Get the message container
        const messageContainer = document.getElementById("message-container");

        // If the container exists, set a timeout to fade it out
        if (messageContainer) {
            setTimeout(() => {
                messageContainer.style.opacity = "0"; // Gradually fade out
                setTimeout(() => {
                    messageContainer.style.display = "none"; // Hide after fade-out
                }, 500); // Match the CSS transition duration (0.5s)
            }, 3000); // Wait 3 seconds before starting the fade-out
        }

        // Sidebar toggle functionality
        const toggleSidebar = document.getElementById("toggle-sidebar");
        const sidebar = document.getElementById("sidebar");

        toggleSidebar.addEventListener("click", function () {
            sidebar.classList.toggle("-translate-x-full");
        });
    });

    // Function to confirm deletion
    function confirmDelete() {
        return confirm("Are you sure you want to delete this image?");
    }
</script>

</body>
</html>
