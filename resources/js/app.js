import "./bootstrap";
import "flowbite";
// import './sidebar';
// import './sidebar';
// import './charts';
import ApexCharts from "apexcharts";
import swal from "sweetalert2";
window.Swal = swal;
window.ApexCharts = ApexCharts;

// import './dark-mode';

// Check localStorage immediately to set initial state
if (localStorage.getItem("menu-collapsed") === "true") {
    // Add a class to body or html to handle initial state
    document.documentElement.classList.add('menu-collapsed');
}

document.addEventListener("livewire:navigating", () => {
    // Mutate the HTML before the page is navigated away...
    initFlowbite();
});

document.addEventListener("livewire:navigated", () => {
    // Check initial state on page load
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');

    // Initial state without transitions
    if (window.innerWidth >= 1024 && sidebar != null) { // Only apply on desktop (lg breakpoint)
        if (localStorage.getItem("menu-collapsed") === "true") {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('flex', 'lg:flex', 'translate-x-0');
            mainContent.classList.remove('ltr:lg:ml-64', 'rtl:lg:mr-64');
        } else {
            sidebar.classList.remove('hidden', '-translate-x-full');
            sidebar.classList.add('flex', 'lg:flex', 'translate-x-0');
            mainContent.classList.add('ltr:lg:ml-64', 'rtl:lg:mr-64');
        }
    }

    const openIcon = document.getElementById('toggle-sidebar-open');
    const closeIcon = document.getElementById('toggle-sidebar-close');

    // Initial state
    if (localStorage.getItem("menu-collapsed") === "true" && openIcon != null) {
        openIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
    } else if (openIcon != null) {
        openIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
    }

    const toggleSidebar = document.getElementById('toggle-sidebar');
    if (toggleSidebar != null) {
        toggleSidebar.addEventListener('click', function(event) {
        // Toggle icons
        openIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');

        // Add transition classes only during click events
        sidebar.classList.add('transition-transform', 'duration-300', 'ease-in-out');
        mainContent.classList.add('transition-all', 'duration-300', 'ease-in-out');

        if (localStorage.getItem("menu-collapsed") === "true") {
            localStorage.setItem("menu-collapsed", "false");
            sidebar.classList.remove('hidden');
            sidebar.classList.add('flex', 'lg:flex', 'translate-x-0');
            mainContent.classList.add('ltr:lg:ml-64', 'rtl:lg:mr-64');
        } else {
            localStorage.setItem("menu-collapsed", "true");
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            mainContent.classList.remove('ltr:lg:ml-64', 'rtl:lg:mr-64');

            sidebar.addEventListener('transitionend', function handler() {
                if (localStorage.getItem("menu-collapsed") === "true") {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('flex', 'lg:flex');
                    // Remove transition classes after animation
                    sidebar.classList.remove('transition-transform', 'duration-300', 'ease-in-out');
                    mainContent.classList.remove('transition-all', 'duration-300', 'ease-in-out');
                }
                sidebar.removeEventListener('transitionend', handler);
            });
        }
        });
    }

    const themeToggleDarkIcon = document.getElementById(
        "theme-toggle-dark-icon"
    );
    const themeToggleLightIcon = document.getElementById(
        "theme-toggle-light-icon"
    );

    // Change the icons inside the button based on previous settings
    if (
        localStorage.getItem("color-theme") === "dark" ||
        (!("color-theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
        themeToggleLightIcon.classList.remove("hidden");
    } else {
        themeToggleDarkIcon.classList.remove("hidden");
    }

    const themeToggleBtn = document.getElementById("theme-toggle");

    let event = new Event("dark-mode");

    themeToggleBtn.addEventListener("click", function () {
        // toggle icons
        themeToggleDarkIcon.classList.toggle("hidden");
        themeToggleLightIcon.classList.toggle("hidden");

        // if set via local storage previously
        if (localStorage.getItem("color-theme")) {
            if (localStorage.getItem("color-theme") === "light") {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            } else {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            }

            // if NOT set via local storage previously
        } else {
            if (document.documentElement.classList.contains("dark")) {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            } else {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            }
        }

        document.dispatchEvent(event);
    });

    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }

    if (sidebar) {
        const toggleSidebarMobile = (
            sidebar,
            sidebarBackdrop,
            toggleSidebarMobileHamburger,
            toggleSidebarMobileClose
        ) => {
            sidebar.classList.toggle("hidden");
            sidebarBackdrop.classList.toggle("hidden");
            toggleSidebarMobileHamburger.classList.toggle("hidden");
            toggleSidebarMobileClose.classList.toggle("hidden");
        };

        const toggleSidebarMobileEl = document.getElementById(
            "toggleSidebarMobile"
        );
        const sidebarBackdrop = document.getElementById("sidebarBackdrop");
        const toggleSidebarMobileHamburger = document.getElementById(
            "toggleSidebarMobileHamburger"
        );
        const toggleSidebarMobileClose = document.getElementById(
            "toggleSidebarMobileClose"
        );
        const toggleSidebarMobileSearch = document.getElementById(
            "toggleSidebarMobileSearch"
        );

        toggleSidebarMobileSearch.addEventListener("click", () => {
            toggleSidebarMobile(
                sidebar,
                sidebarBackdrop,
                toggleSidebarMobileHamburger,
                toggleSidebarMobileClose
            );
        });

        toggleSidebarMobileEl.addEventListener("click", () => {
            toggleSidebarMobile(
                sidebar,
                sidebarBackdrop,
                toggleSidebarMobileHamburger,
                toggleSidebarMobileClose
            );
        });

        sidebarBackdrop.addEventListener("click", () => {
            toggleSidebarMobile(
                sidebar,
                sidebarBackdrop,
                toggleSidebarMobileHamburger,
                toggleSidebarMobileClose
            );
        });
    }

    // Reinitialize Flowbite components
    initFlowbite();
});

let attrs = [
    "snapshot",
    "effects",
    // 'click',
    // 'id'
];

function snapKill() {
    document
        .querySelectorAll("div, nav, a, header")
        .forEach(function (element) {
            for (let i in attrs) {
                if (element.getAttribute(`wire:${attrs[i]}`) !== null) {
                    element.removeAttribute(`wire:${attrs[i]}`);
                }
            }
        });
}

window.addEventListener("load", (ev) => {
    snapKill();
});

function initPasswordToggles() {
    // Remove existing listeners to prevent duplicates
    document.removeEventListener('click', handlePasswordToggle);
    // Add single event listener on document
    document.addEventListener('click', handlePasswordToggle);
}

function handlePasswordToggle(event) {
    // Check if clicked element or its parent has toggle-password class
    const toggleButton = event.target.closest('.toggle-password');
    if (!toggleButton) return;

    // Find the closest parent div and get related elements
    const wrapper = toggleButton.closest('.relative');
    const passwordInput = wrapper.querySelector('.password');
    const eyeIcon = wrapper.querySelector('.eye-icon');
    const eyeSlashIcon = wrapper.querySelector('.eye-slash-icon');

    // Toggle password visibility
    const isPassword = passwordInput.type === "password";
    passwordInput.type = isPassword ? "text" : "password";

    // Toggle the icons
    eyeIcon.classList.toggle("hidden", isPassword);
    eyeSlashIcon.classList.toggle("hidden", !isPassword);
}

initPasswordToggles();

// Re-initialize when Livewire updates the DOM
document.addEventListener('livewire:navigated', () => {
    initPasswordToggles();
});

