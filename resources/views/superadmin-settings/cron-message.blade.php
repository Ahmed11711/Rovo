<x-alert type="info">
    <div class="flex flex-col justify-between">
        <div class="flex justify-between">
            <div>
                <h6>Please set the following cron command on your server (Ignore if already done)</h6>

            </div>
            <div class="mb-3 flex justify-between items-center">


                <a href="https://www.youtube.com/watch?v=W-3pKLf3Hq4&t=18s&pp=ygURY3JvbmpvYiB3b3Jrc3VpdGU%3D"
                   target="_blank"
                   class="inline-flex items-center text-sm text-red-600 hover:text-red-700">
                    <svg class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                    Watch Tutorial
                    <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>

        </div>

        <div class="mt-3 mb-2">
            <code>* * * * * (Every Minute)</code>
        </div>




    <div class="flex gap-2 items-center">
        @php
            try {
                $phpPath = PHP_BINDIR.'/php';
            } catch (\Throwable $th) {
                $phpPath = 'php';
            }
            echo '<code id="cron-command" class="flex items-center gap-2 bg-gray-100 dark:bg-gray-800 px-4 py-2 rounded font-mono text-sm"> ' . $phpPath . ' ' . base_path() . '/artisan schedule:run >> /dev/null 2>&1</code>';
        @endphp

        <button type="button" id="copy-cron-command" class="btn text-gray-900 dark:text-white font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
            </svg>
        </button>
    </div>

    <div class="mt-3"><strong>Note:</strong>

        <ins>{{$phpPath}}</ins>
        in the above command is the path of PHP on your server. To ensure it works correctly, please enter the correct PHP path for your server and provide the path to your script. If you're unsure how to set up a cron job, you may want to consult with your server administrator or hosting provider.
    </div>
    </div>
</x-alert>

<script>
    document.getElementById('copy-cron-command').addEventListener('click', async function() {
        const command = document.getElementById('cron-command').textContent;
        try {
            await navigator.clipboard.writeText(command);
            // Optional: Add visual feedback
            this.innerHTML = `Copied`;
            setTimeout(() => {
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-copy" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 5a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1h1v1a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h1v1z"/>
                    </svg>`;
            }, 2000);
        } catch (err) {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = command;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                document.execCommand('copy');
                textArea.remove();
            } catch (err) {
                console.error('Failed to copy text:', err);
            }
        }
    });
</script>
