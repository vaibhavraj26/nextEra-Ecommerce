<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>nextEra - Reset Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <link href="../../src/css/tailwind.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body class="bg-gradient-to-tl from-slate-500 via-slate-200 to-slate-500 flex items-center justify-center min-h-screen transition-all duration-500">
    <div x-data="resetPassword()" class="bg-white my-4 p-8 rounded-xl shadow-2xl w-full max-w-md transform transition-transform duration-300">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8 tracking-tight">Reset Your Password</h2>

        <!-- Email Input -->
        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Registered Email</label>
            <input type="email" id="email" x-model="email" placeholder="Enter your email" 
                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 text-gray-800 placeholder-gray-400" 
                   aria-label="Registered Email" required>
                   <p class="text-gray-500 text-xs mt-2">*We will send an OTP to this email.</p>
        </div>

        <!-- Phone Number Input -->
        <div class="mb-6">
            <label for="contact" class="block text-sm font-medium text-gray-700 mb-2">Registered Phone Number</label>
            <input type="tel" id="contact" x-model="contact" placeholder="Enter your phone number" 
                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 text-gray-800 placeholder-gray-400" 
                   aria-label="Registered Phone Number" required>
            
        </div>

        <!-- Send OTP Button -->
        <button @click="sendOTP()" :disabled="otpSent" 
                :class="{ 'opacity-50 cursor-not-allowed': otpSent }" 
                class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition-all duration-200 shadow-md mb-6">
            <span x-text="otpSent ? 'OTP Sent' : 'Send OTP'"></span>
        </button>

        <!-- OTP Input -->
        <div x-show="otpSent" class="mb-6 animate-fade-in">
            <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">Enter OTP</label>
            <input type="text" id="otp" x-model="otp" placeholder="Enter OTP" 
                   class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:outline-none focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gray-50 text-gray-800 placeholder-gray-400" 
                   aria-label="OTP">
            <button @click="verifyOTP()" :disabled="otpVerified" 
                    :class="{ 'opacity-50 cursor-not-allowed': otpVerified }" 
                    class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700  focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-offset-2 transition-all duration-200 shadow-md mt-3">
                <span x-text="otpVerified ? 'OTP Verified' : 'Verify OTP'"></span>
            </button>
        </div>

        <!-- New Password Inputs -->
        <div x-show="otpVerified" class="animate-fade-in">
            <div class="mb-6">
                <label for="newPassword" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                <input type="password" id="newPassword" x-model="newPassword" placeholder="Enter new password" 
                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 text-gray-800 placeholder-gray-400" 
                       aria-label="New Password">
            </div>
            <div class="mb-6">
                <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                <input type="password" id="confirmPassword" x-model="confirmPassword" placeholder="Confirm new password" 
                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none focus:border-blue-500 transition-all duration-200 bg-gray-50 text-gray-800 placeholder-gray-400" 
                       aria-label="Confirm New Password">
                <p x-show="newPassword !== confirmPassword && confirmPassword !== ''" 
                   class="text-red-500 text-xs mt-2 font-medium animate-pulse">Passwords do not match.</p>
            </div>

            <!-- Reset Password Button -->
            <button @click="resetPassword()" :disabled="newPassword !== confirmPassword || newPassword === ''" 
                    :class="{ 'opacity-50 cursor-not-allowed': newPassword !== confirmPassword || newPassword === '' }" 
                    class="w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 transition-all duration-200 shadow-md">
                Reset Password
            </button>

            <!-- Success Message -->
            <p x-show.transition.opacity.duration.500ms.delay.200ms="resetSuccess" 
               class="text-green-600 font-semibold mt-4 text-center bg-green-100 p-2 rounded-lg shadow-inner">Your password has been reset successfully!</p>
        </div>
    </div>

    <script>
    function resetPassword() {
        return {
            email: '',
            contact: '',
            otp: '',
            newPassword: '',
            confirmPassword: '',
            otpSent: false,
            otpVerified: false,
            resetSuccess: false,

            sendOTP() {
                if (this.contact) {
                    this.otpSent = true;
                    alert('OTP has been sent to your phone/email.');
                } else {
                    alert('Please enter your phone number or email.');
                }
            },

            verifyOTP() {
                if (this.otp) {
                    this.otpVerified = true;
                    alert('OTP verified successfully!');
                } else {
                    alert('Please enter the OTP.');
                }
            },

            resetPassword() {
                if (this.newPassword === this.confirmPassword) {
                    this.resetSuccess = true;
                    alert('Your password has been reset successfully!');
                }
            }
        }
    }
    </script>
</body>
</html>