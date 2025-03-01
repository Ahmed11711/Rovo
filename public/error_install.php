<!DOCTYPE html>
<html>
<head>
    <title>Tabletrack Not Installed</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-50 font-['Inter']">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-2xl w-full">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Installation Error Detected</h1>
                <p class="text-gray-600">Please address the following issues to complete your installation</p>
            </div>

            <?php if ($GLOBALS['error_type'] == 'php-version') { ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm mb-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-red-800 mb-2">PHP Version Requirement Not Met</h3>
                            <p class="text-red-700 mb-4">Your server's PHP version is lower than the required version <span class="font-semibold">8.2.0</span>. Please upgrade to continue with the installation.</p>

                            <div class="bg-white bg-opacity-50 rounded p-4 border border-red-200">
                                <p class="text-red-600">Current PHP Version: <span class="font-semibold"><?php echo phpversion(); ?></span></p>
                                <p class="text-sm text-red-500 mt-2">Required Version: ≥ 8.2.0</p>
                            </div>

                            <div class="mt-4">
                                <h4 class="font-medium text-red-800 mb-2">Next Steps:</h4>
                                <ul class="list-disc list-inside text-red-700 space-y-1">
                                    <li>Contact your hosting provider to upgrade PHP</li>
                                    <li>Ensure your server meets all system requirements</li>
                                    <li>Restart the installation process after upgrading</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg shadow-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-red-800 mb-2">Missing Environment File</h3>
                            <p class="text-red-700 mb-4">The <span class="font-mono bg-red-100 px-1 rounded">.env</span> file is missing from your installation.</p>

                            <div class="bg-white bg-opacity-50 rounded p-4 border border-red-200">
                                <h4 class="font-medium text-red-800 mb-2">How to fix this:</h4>
                                <ol class="list-decimal list-inside text-red-700 space-y-1">
                                    <li>Locate the <span class="font-mono">.env.example</span> file in your project</li>
                                    <li>Make a copy and rename it to <span class="font-mono">.env</span></li>
                                    <li>Update the configuration values as needed</li>
                                </ol>
                            </div>

                            <div class="mt-4">
                                <a href="https://froiden.freshdesk.com/support/solutions/articles/43000491463"
                                   target="_blank"
                                   class="inline-flex items-center text-red-700 hover:text-red-800 font-medium">
                                    <span>View detailed instructions</span>
                                    <svg class="ml-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

            <div class="text-center mt-8">
                <p class="text-gray-600">Need help? Contact our support team for assistance.</p>
            </div>
        </div>
    </div>
</body>
</html>
