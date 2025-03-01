<script>
    function updateLivewireScript() {
        const livewireScript = document.querySelector('script[data-update-uri]');

        if (livewireScript) {
            const updateUri = livewireScript.getAttribute('data-update-uri');
            const currentUrl = window.location.href;

            if (currentUrl.includes('/public')) {
                const publicIndex = currentUrl.indexOf('/public');
                const baseUrl = currentUrl.substring(0, publicIndex + 7); // +7 to include '/public'
                livewireScript.setAttribute('data-update-uri', baseUrl + '/livewire/update');
            }
        }
    }

    // Run on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', () => {
        updateLivewireScript();
    });

    // Run on load
    window.addEventListener('load', () => {
        updateLivewireScript();
    });


    document.addEventListener('livewire:navigated', () => {
            // Your function to be called on every route change
        updateLivewireScript();

    });
</script>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.hook('request', ({ fail }) => {
            fail(({ status, preventDefault }) => {
                if (status === 419) {
                    console.log('Your custom page expiration behavior...');
                    window.location.reload();
                }
            })
        })
    })
    </script>
