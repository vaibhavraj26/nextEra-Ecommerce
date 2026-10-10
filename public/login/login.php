<?php
require_once '../../src/controllers/AuthController.php';
require_once '../../src/models/User.php';

session_start();
// Redirect to dashboard if user is already logged in
if (isset($_SESSION['user'])) {
  header("Location: ../../public/dashboard.php");
  exit();
} elseif (isset($_COOKIE['remember_token'])) {
  $user = User::findByToken($_COOKIE['remember_token']);
  if ($user) {
    $_SESSION['user'] = $user; // Recreate session
    header("Location: ../../public/dashboard.php");
    exit();
  } else {
    setcookie('remember_token', '', time() - 3600, '/', '', true, true);
  }
}
$authController = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['login-email']) && isset($_POST['login-password'])) {
    $message = $authController->login($_POST['login-email'], $_POST['login-password'], isset($_POST['remember_me']));
  } elseif (isset($_POST['signup-name']) && isset($_POST['signup-email']) && isset($_POST['phone_no']) && isset($_POST['signup-password']) && isset($_POST['signup-confirmPassword'])) {
    $message = $authController->signup($_POST['signup-name'], $_POST['signup-email'], $_POST['phone_no'], $_POST['signup-password'], $_POST['signup-confirmPassword']);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>nextEra clothing - Login & Signup</title>
  <link href="../../src/css/tailwind.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

  <style>
.background-box {
  position: fixed;
  width: 100%;
  height: 100%;
  z-index: 0;
  overflow: hidden;
}

.floating-img {
  position: absolute;
  width: 60px;
  animation: floatRandom infinite linear;
}

.opicity {
  opacity: 0.5;
}

.img1 { top: 0%; left: 27%;  }
.img2 { top: 70%; left: 4%;  }
.img3 { top: 4%; left: 4%;   }
.img4 { top: 35%; left: 10%; }
.img5 { top: 40%; left: 89%; }
.img6 { top: 30%; left: 65%; }
.img7 { top: 65%; left: 70%; }
.img8 { top: 65%; left: 22%; }
.img9 { top: 5%; left: 80%;  }
.img10{ top: 75%; left: 83%; } 
  </style>

</head>

<body class="bg-gradient-to-br from-fuchsia-500/50 via-violet-600/30 to-blue-700/50 flex items-center justify-center min-h-screen">


  <div x-data="{ showLogin: true, showLoginPassword: false, showSignupPassword: false }" class="bg-white bg-opacity-50 px-8 py-4 my-4 rounded-lg shadow-lg w-full max-w-md z-20">
    <div class="text-2xl font-bold text-center mb-2 rounded-lg bg-gradient-to-bl from-violet-500 to-fuchsia-500 bg-clip-text text-transparent">
      creating your nextEra...
    </div>

    <div class="flex justify-center mb-6">
      <button @click="showLogin = true" :class="{'text-blue-600 border-blue-600 border-b-2': showLogin, 'text-gray-500 border-transparent': !showLogin}" class="px-4 py-2 text-lg font-semibold focus:outline-none cursor-pointer">
        LogIn
      </button>
      <button @click="showLogin = false" :class="{'text-blue-600 border-blue-600 border-b-2': !showLogin, 'text-gray-500 border-transparent': showLogin}" class="px-4 py-2 text-lg font-semibold focus:outline-none cursor-pointer">
        SignUp
      </button>
    </div>

    <?php if (isset($message)): ?>
      <div x-data="{ showError: true }" x-show="showError" @click.away="showError = false" class="mb-4 text-red-500">
        <?php echo $message; ?>
      </div>
      <?php unset($message); ?>
    <?php endif; ?>

    <!-- Login Form -->
    <form x-show="showLogin" class="space-y-4" id="login-form" method="POST" action="login.php">
      <div>
        <label for="login-email" class="block text-md font-medium text-gray-700">Email*</label>
        <input type="email" id="login-email" name="login-email" aria-label="Email" placeholder="Enter your registered email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
      </div>
      <div>
        <label for="login-password" class="block text-md font-medium text-gray-700">Password*</label>
        <div class="relative">
          <input :type="showLoginPassword ? 'text' : 'password'"
            id="login-password"
            name="login-password"
            aria-label="Password"
            placeholder="Enter your password"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
          <button type="button"
            @click="showLoginPassword = !showLoginPassword"
            class="absolute inset-y-0 right-0 pr-3 flex items-center mt-1">
            <svg x-show="!showLoginPassword" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg x-show="showLoginPassword" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            </svg>
          </button>
        </div>
      </div>
      <div>
        <label>
          <input type="checkbox" aria-label="remember user for seemless login" name="remember_me"> Remember Me
        </label>
      </div>
      <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer">
        LogIn
      </button>
      <div class="text-center">
        <a class="text-blue-700 active:text-red-600 hover:underline" href="forgetPassword.php">forget password ?</a>
      </div>
      <button @click="showLogin = false" class="text-center w-full">
        don't have an account ? <span class="text-blue-700 active:text-red-600 hover:underline">SignUp first</span>
      </button>
    </form>

    <!-- Signup Form -->
    <form x-show="!showLogin" class="space-y-4" id="signup-form" method="POST" action="login.php" x-data="signupForm()">
      <div>
        <label for="signup-name" class="block text-sm font-medium text-gray-700">Name*</label>
        <input type="text" id="signup-name" name="signup-name" aria-label="Name" placeholder="Enter your name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
      </div>
      <div>
        <label for="signup-email" class="block text-sm font-medium text-gray-700">Email*</label>
        <input type="email" id="signup-email" name="signup-email" aria-label="Email" placeholder="Enter your email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
      </div>
      <div>
        <label for="phone_no" class="block text-sm font-medium text-gray-700">Phone Number*</label>
        <input type="tel"
          id="phone_no"
          name="phone_no"
          aria-label="Phone Number"
          placeholder="Enter 10-digit phone number"
          pattern="[0-9]{10}"
          maxlength="10"
          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
          required
          x-model="phone"
          :class="{'border-red-500 focus:ring-red-500 focus:border-red-500': phone && phoneError, 'border-green-500 focus:ring-green-500 focus:border-green-500': phone && !phoneError}">
        <p x-show="phoneError" class="mt-1 text-sm text-red-500" x-text="phoneError"> </p>
      </div>
      <div>
        <label for="signup-password" class="block text-sm font-medium text-gray-700">Password*</label>
        <div class="relative">
          <input :type="showSignupPassword ? 'text' : 'password'"
            id="signup-password"
            name="signup-password"
            placeholder="Enter your password"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            x-model="password">
          <button type="button"
            @click="showSignupPassword = !showSignupPassword"
            class="absolute inset-y-0 right-0 pr-3 flex items-center mt-1">
            <svg x-show="!showSignupPassword" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg x-show="showSignupPassword" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            </svg>
          </button>
        </div>
        <p x-show="passwordError" x-text="passwordError" class="text-red-500 text-sm"></p>
        <p x-show="password" class="text-sm" :class="{'text-red-500': passwordStrength === 'Weak', 'text-yellow-500': passwordStrength === 'Medium', 'text-green-500': passwordStrength === 'Strong'}" x-text="passwordStrength"></p>
      </div>
      <div>
        <label for="signup-confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password*</label>
        <input type="password" id="signup-confirmPassword" name="signup-confirmPassword" placeholder="Enter password again" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" x-model="confirmPassword">
        <p x-show="matchError" x-text="matchError" class="text-red-500 text-sm"></p>

      </div>
      <!-- disable button until valid password -->
      <button type="submit" :disabled="!isFormValid" :class="{'bg-gray-500 cursor-not-allowed': !isFormValid, 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 cursor-pointer focus:ring-2 focus:ring-offset-2': isFormValid}"
        class="w-full text-white py-2 px-4 rounded-md focus:outline-none ">SignUp
      </button>
      <button @click="showLogin = true" class="text-center w-full">
        have account ? <span class="text-blue-700 active:text-red-600 hover:underline">LogIn</span>
      </button>
    </form>
  </div>

  <script>
    function signupForm() {
      return {
        password: '',
        confirmPassword: '',
        showSignupPassword: false,
        phone: '',
        get phoneError() {
          if (!this.phone) return '';
          return /^[0-9]{10}$/.test(this.phone) ? '' : 'Please enter a valid 10-digit number';
        },
        get passwordError() {
          if (!this.password) return '';
          if (!/[A-Z]/.test(this.password)) return 'Password must contain at least one uppercase letter.';
          if (!/[a-z]/.test(this.password)) return 'Password must contain at least one lowercase letter.';
          if (!/\d/.test(this.password)) return 'Password must contain at least one number.';
          if (this.password.length < 6) return 'Password must be at least 6 characters.';
          return '';
        },
        get matchError() {
          if (!this.confirmPassword) return '';
          return this.password !== this.confirmPassword ? 'Passwords do not match!' : '';
        },
        get passwordStrength() {
          if (this.password.length < 6) return 'Weak';
          if (/[A-Z]/.test(this.password) && /[a-z]/.test(this.password) && /\d/.test(this.password) && /[^A-Za-z0-9]/.test(this.password)) return 'Strong';
          return 'Medium';
        },
        get isFormValid() {
          return this.password &&
            this.confirmPassword &&
            this.phone &&
            !this.passwordError &&
            !this.matchError &&
            !this.phoneError;
        }
      }
    }
  </script>
</body>

</html>