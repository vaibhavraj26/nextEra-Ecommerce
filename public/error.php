<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Something went wrong - nextEra</title>
    <script src="https://cdn.tailwindcss.com"></script>
   
</head>
<body class=" text-gray-900 pb-8">
    <!-- Header -->
    <header class="">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center px-4 pt-4">
                <h1 class="font-mono text-3xl sm:text-4xl font-bold text-black">
                    nextEra
                </h1>
                <nav>
                    <a href="/" class="text-gray-500 hover:text-blue-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        <span class="hidden sm:inline">Home</span>
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl ">
        <div class="bg-white rounded-lg  ">
            <div class="md:flex">
                <!-- Left illustration column -->
                <div class="md:w-5/12 flex items-center justify-center">
                    <div class="max-w-sm">
                        <img src="resource/error.png" alt="Something went wrong" class="w-full">
                    </div>
                </div>
                
                <!-- Right content column -->
                <div class="md:w-7/12 px-6 md:px-8 ">
                    <!-- Error Header -->
                    <div class="pb-4 space-y-3">
                        <h2 class="text-2xl md:text-3xl font-bold text-red-600 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            Something went wrong!
                            <img src="resource/sad.png" alt="" class="h-6 w-6 ml-4">
                        </h2>
                        <p class="text-gray-600">
                            We're sorry, but we encountered an unexpected error. Don't worry, we can help you get back on track.
                        </p>
                    </div>
                    
                    <!-- Error Details -->
                    <div class="py-6">
                        <div class="bg-red-100 border border-red-500 rounded-lg shadow-sm">
                            <div class="p-4">
                                <div class="flex justify-between items-start">
                                    <h3 class="font-semibold text-red-600 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                                            <path d="M14.31 8l5.74 9.94M9.69 8h11.48M7.38 12l5.74-9.94M9.69 16L3.95 6.06M14.31 16H2.83M16.62 12l-5.74 9.94"/>
                                        </svg>
                                        Error Details
                                    </h3>
                                    <button 
                                        class="text-blue-700 hover:text-blue-900 font-medium text-sm flex items-center" 
                                        onclick="copyErrorText()"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"></path>
                                        </svg>
                                        <span>Copy</span>
                                    </button>
                                </div>
                                
                                <div class="mt-2 font-mono text-sm text-gray-800 bg-white p-3 rounded border border-gray-200 overflow-x-auto max-h-32">
                                    <code id="errorText">TypeError: Cannot read property 'data' of undefined at processResponse (app.js:1275)</code>
                                </div>
                                
                                <div id="copiedMessage" class="mt-2 text-green-600 text-sm flex items-center hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                    Error copied to clipboard!
                                </div>
                            </div>
                        </div>
                        
                        <!-- Browser Info -->
                        <div class="text-sm text-gray-500">
                            <p><strong>Browser:</strong> <span id="browserInfo">Chrome on Windows</span></p>
                            <p><strong>Time:</strong> <span id="timestamp"></span></p>
                        </div>
                    </div>
                    
                    <!-- Troubleshooting Steps -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Try These Steps:</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start">
                                <span class="mt-1 mr-2 text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M23 4v6h-6"></path>
                                        <path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"></path>
                                    </svg>
                                </span>
                                <span>Refresh the page and try again</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mt-1 mr-2 text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </span>
                                <span>Clear your browser cache and cookies</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mt-1 mr-2 text-blue-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"></path>
                                        <polyline points="10 17 15 12 10 7"></polyline>
                                        <line x1="15" y1="12" x2="3" y2="12"></line>
                                    </svg>
                                </span>
                                <span>Try signing out and back in again</span>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                        <a 
                            href="dashboard.php" 
                            class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            Return Home
                        </a>
                        
                        <button 
                            class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
                            onclick="openReportModal()"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                            Report Error
                        </button>
                        
                        <button 
                            class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors"
                            onclick="openSupportModal()"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 1a3 3 0 00-3 3v8a3 3 0 006 0V4a3 3 0 00-3-3z"></path>
                                <path d="M19 10v2a7 7 0 01-14 0v-2"></path>
                                <line x1="12" y1="19" x2="12" y2="23"></line>
                                <line x1="8" y1="23" x2="16" y2="23"></line>
                            </svg>
                            Get Support
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Report Error Modal -->
    <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-screen overflow-auto transform transition-all">
            <div class="bg-blue-500 text-white p-4 rounded-t-lg">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium">Report Error</h3>
                    <button onclick="closeReportModal()" class="text-white hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>
            
            <form id="reportForm" class="p-6">
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label for="additionalInfo" class="block text-sm font-medium text-gray-900">
                            Additional Information
                        </label>
                        <textarea 
                            id="additionalInfo" 
                            rows="3"
                            class="w-full px-1 border-2 border-blue-300 rounded-md shadow-sm resize-none"
                            placeholder="Please describe what you were doing when the error occurred."
                        ></textarea>
                        <p class="text-xs text-gray-600">
                            *Please describe what you were doing when the error occurred.
                        </p>
                    </div>
                    
                    <div class="space-y-1">
                        <label for="contactEmail" class="block text-sm font-medium text-gray-900">
                            Your Email (optional)
                        </label>
                        <input 
                            type="email" 
                            id="contactEmail"
                            class="w-full px-1 border-2 border-blue-300 rounded-md shadow-sm "
                            placeholder="your.email@example.com"
                        >
                        <p class="text-xs text-gray-500">
                            *We'll contact you if we need more information.
                        </p>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <input 
                            type="checkbox" 
                            id="includeSystemInfo" 
                            checked
                            class="h-4 w-4 text-blue-600 border-gray-300 rounded"
                        >
                        <label 
                            for="includeSystemInfo"
                            class="text-sm text-gray-800"
                        >
                            Include system information (browser, OS)
                        </label>
                    </div>
                </div>
                
                <div class="mt-5 flex justify-end space-x-3">
                    <button 
                        type="button" 
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
                        onclick="closeReportModal()"
                    >
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-600"
                    >
                        Send Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Support Modal -->
    <div id="supportModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full max-h-screen overflow-auto transform transition-all">
            <div class="bg-amber-600 text-white p-4 rounded-t-lg">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium">Contact Support</h3>
                    <button onclick="closeSupportModal()" class="text-white hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="p-6">
                <h4 class="font-medium text-gray-900 mb-2">Support Options</h4>
                <div class="space-y-3">
                    <a 
                        href="#"
                        class="flex items-start p-3 rounded-md border border-gray-200 hover:border-amber-500 hover:bg-amber-50 transition-colors block"
                    >
                        <span class="mt-1 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"></path>
                            </svg>
                        </span>
                        <div class="ml-3">
                            <h5 class="font-medium text-gray-900">Live Chat</h5>
                            <p class="text-sm text-gray-500">Available Monday-Friday, 9am-5pm</p>
                        </div>
                    </a>
                    
                    <a 
                        href="mailto:support@nextera.com"
                        class="flex items-start p-3 rounded-md border border-gray-200 hover:border-amber-500 hover:bg-amber-50 transition-colors block"
                    >
                        <span class="mt-1 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </span>
                        <div class="ml-3">
                            <h5 class="font-medium text-gray-900">Email Support</h5>
                            <p class="text-sm text-gray-500">support@nextera.com</p>
                        </div>
                    </a>
                    
                    <a 
                        href="tel:+18001234567"
                        class="flex items-start p-3 rounded-md border border-gray-200 hover:border-amber-500 hover:bg-amber-50 transition-colors block"
                    >
                        <span class="mt-1 text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"></path>
                            </svg>
                        </span>
                        <div class="ml-3">
                            <h5 class="font-medium text-gray-900">Phone Support</h5>
                            <p class="text-sm text-gray-500">1-800-123-4567</p>
                        </div>
                    </a>
                </div>
                
                <div class="mt-5 flex justify-end">
                    <button 
                        type="button" 
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 "
                        onclick="closeSupportModal()"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 bg-white rounded-lg shadow-lg max-w-sm w-full p-4 border-l-4 border-green-500 transform translate-y-10 opacity-0 transition-all duration-300 hidden">
        <div class="flex items-center">
            <div class="flex-shrink-0 text-green-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="ml-3 w-0 flex-1">
                <p class="text-sm font-medium text-gray-900">Error report sent successfully!</p>
                <p class="mt-1 text-sm text-gray-500">Thank you for helping us improve.</p>
            </div>
            <div class="ml-4 flex-shrink-0 flex">
                <button onclick="closeToast()" class="inline-flex text-gray-400 hover:text-gray-500">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Set current timestamp
        document.getElementById('timestamp').textContent = new Date().toLocaleString();
        
        // Detect browser info
        function detectBrowser() {
            const userAgent = navigator.userAgent;
            let browserName = "Unknown Browser";
            let platform = navigator.platform || "Unknown OS";
            
            if (userAgent.match(/chrome|chromium|crios/i)) {
                browserName = "Chrome";
            } else if (userAgent.match(/firefox|fxios/i)) {
                browserName = "Firefox";
            } else if (userAgent.match(/safari/i)) {
                browserName = "Safari";
            } else if (userAgent.match(/opr\//i)) {
                browserName = "Opera";
            } else if (userAgent.match(/edg/i)) {
                browserName = "Edge";
            }
            
            document.getElementById('browserInfo').textContent = `${browserName} on ${platform}`;
        }
        
        // Copy error text
        function copyErrorText() {
            const errorText = document.getElementById('errorText').textContent;
            navigator.clipboard.writeText(errorText)
                .then(() => {
                    const copiedMessage = document.getElementById('copiedMessage');
                    copiedMessage.classList.remove('hidden');
                    setTimeout(() => {
                        copiedMessage.classList.add('hidden');
                    }, 3000);
                })
                .catch(err => {
                    console.error('Failed to copy: ', err);
                });
        }
        
        // Modal functions
        function openReportModal() {
            document.getElementById('reportModal').classList.remove('hidden');
        }
        
        function closeReportModal() {
            document.getElementById('reportModal').classList.add('hidden');
        }
        
        function openSupportModal() {
            document.getElementById('supportModal').classList.remove('hidden');
        }
        
        function closeSupportModal() {
            document.getElementById('supportModal').classList.add('hidden');
        }
        
        // Toast functions
        function showToast() {
            const toast = document.getElementById('toast');
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.remove('translate-y-10', 'opacity-0');
            }, 50);
            
            setTimeout(() => {
                closeToast();
            }, 5000);
        }
        
        function closeToast() {
            const toast = document.getElementById('toast');
            toast.classList.add('translate-y-10', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 300);
        }
        
        // Form submission
        document.getElementById('reportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const additionalInfo = document.getElementById('additionalInfo').value;
            const contactEmail = document.getElementById('contactEmail').value;
            const includeSystemInfo = document.getElementById('includeSystemInfo').checked;
            
            console.log('Error report submitted:', {
                errorMessage: document.getElementById('errorText').textContent,
                additionalInfo,
                contactEmail,
                browserInfo: includeSystemInfo ? document.getElementById('browserInfo').textContent : null,
                timestamp: document.getElementById('timestamp').textContent
            });
            
            closeReportModal();
            showToast();
            
            // Reset form
            this.reset();
            document.getElementById('includeSystemInfo').checked = true;
        });
        
        // Initialize
        detectBrowser();
    </script>
</body>
</html>