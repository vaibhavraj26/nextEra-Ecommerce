<?php
session_start();
require_once __DIR__ . '/../src/database/Database.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../src/views/login.php');
    exit();
}

$db = Database::getInstance();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link href="css/tailwind.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-slate-300">

<div class="fixed top-0 left-0 w-full bg-white h-6 drop-shadow-md z-50">
    <div class="max-md:hidden text-center font-bold">
        <?php
        echo "Welcome to your dashboard, " . htmlspecialchars($_SESSION['user']['name']) . "!";
        echo '<hr class="h-0.5 bg-gray-200">';
        ?>
    </div>

    <!-- navbar -->
    <div class="navbar flex justify-between bg-white h-16 drop-shadow-md px-2 fixed w-full z-50">
        <div class="flex" x-data="{ open: false }">
            <img src="resource/nextEra.jpg" alt="logo" class="h-10 my-3" />
        </div>
        <div class="flex sm:space-x-4 sm:mr-4">
            <a href="dashboard.php">
                <img src="resource/home.png" alt="" class="h-10 m-3" />
            </a>
            <div >
                <button class="bg-blue-500 p-2 my-3 rounded-lg sm:font-bold font-semibold text-white">Log Out</button>
            </div>
        </div>
    </div>
</div>




<div x-data="profilePage()" class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-10">
    <!-- Profile Header -->
    <div class="flex items-center space-x-4 mb-6">
        <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center text-white text-xl font-bold">
            <span x-text="user.name[0]"></span> <!-- Display first letter of the user's name -->
        </div>
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Welcome, <span x-text="user.name"></span></h2>
            <p class="text-gray-600">Manage your profile below.</p>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Contact Information</h3>
        <div class="space-y-2">
            <p><strong>Phone:</strong> <span x-text="user.phone"></span></p>
            <button @click="editPhone = true" class="text-blue-500 hover:underline">Change Phone</button>
            <div x-show.transition.duration.300ms="editPhone" class="mt-2">
                <input type="text" x-model="user.phone" placeholder="Enter new phone number"
                       class="border rounded px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500">
                <button @click="editPhone = false" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Save</button>
            </div>

            <p><strong>Email:</strong> <span x-text="user.email"></span></p>
            <button @click="editEmail = true" class="text-blue-500 hover:underline">Change Email</button>
            <div x-show.transition.duration.300ms="editEmail" class="mt-2">
                <input type="email" x-model="user.email" placeholder="Enter new email"
                       class="border rounded px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500">
                <button @click="editEmail = false" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Save</button>
            </div>

            <p><strong>Name:</strong> <span x-text="user.name"></span></p>
            <button @click="editName = true" class="text-blue-500 hover:underline">Change Name</button>
            <div x-show.transition.duration.300ms="editName" class="mt-2">
                <input type="text" x-model="user.name" placeholder="Enter new name"
                       class="border rounded px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500">
                <button @click="editName = false" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Save</button>
            </div>
        </div>
    </div>

    <!-- Address Section -->
    <div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Addresses</h3>
        <!-- Display Addresses -->
        <template x-for="(address, index) in user.addresses" :key="'address-' + index">
            <div class="border p-4 rounded mb-4 relative">
                <p><strong>Address:</strong> <span x-text="address"></span></p>
                <!-- Edit Address -->
                <button @click.prevent="$set(user.addresses, index, prompt('Edit Address:', address))"
                        class="absolute top-2 right-2 text-blue-500 hover:underline">Edit</button>
            </div>
        </template>

        <!-- Add Address -->
        <button @click.prevent="
          user.addresses.length >= 3 
          ? alert('You can only add up to 3 addresses.') 
          : user.addresses.push(prompt('Enter new address:'))
          "
                class="
                  bg-green-500 
                  hover:bg-green-600 text-white px-4 py-2 rounded mt-4"
                >
            Add Address
        </button>

        <!-- Go to Cart and View Orders -->
        <div class="mt-6 flex space-x-4">
            <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Go to Cart</a>
            <a href="#" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">View Orders</a>
        </div>

        <!-- Help Center -->
        <div class="mt-6">
            <a href="#" class="text-blue-600 hover:underline">Help Center</a>
        </div>
    </div>

</div>

<script>
function profilePage() {
    return {
        user: {
            name: 'John Doe',
            phone: '1234567890',
            email: 'john.doe@example.com',
            addresses: [
                '123 Main St, Springfield',
                '456 Elm St, Springfield',
                '789 Maple St, Springfield'
            ]
        },
        editPhone: false,
        editEmail: false,
        editName: false
    }
}
</script>





</body>
</html>