// =====================================================================
// SCRIPT.JS - Bloom & Gold Salon (Home Page)
// This file only handles pure front-end visual behavior.
// No PHP, no forms, no database logic lives here.
// =====================================================================

// -----------------------------------------------------------------
// 1. NAVBAR SCROLL EFFECT
// -----------------------------------------------------------------
// When the page loads, the navbar is transparent (see .hero background
// showing through it). Once the user scrolls down even a little,
// we add the "scrolled" class, which style.css uses to give the
// navbar a solid blush background and a soft shadow.
// -----------------------------------------------------------------
const mainNavbar = document.getElementById("mainNavbar");

function handleNavbarScroll() {
    // window.scrollY tells us how many pixels the user has scrolled down.
    if (window.scrollY > 40) {
        mainNavbar.classList.add("scrolled");
    } else {
        mainNavbar.classList.remove("scrolled");
    }
}

// Run once on page load (in case the page is refreshed mid-scroll)
handleNavbarScroll();

// Run every time the user scrolls
window.addEventListener("scroll", handleNavbarScroll);


// -----------------------------------------------------------------
// 2. AUTO-UPDATE FOOTER YEAR
// -----------------------------------------------------------------
// Instead of hardcoding "2026" in the footer (which becomes outdated
// every year), we grab the current year using JavaScript's Date object
// and insert it into the <span id="year"> element automatically.
// -----------------------------------------------------------------
const yearSpan = document.getElementById("year");
if (yearSpan) {
    yearSpan.textContent = new Date().getFullYear();
}


// -----------------------------------------------------------------
// 3. SMOOTH SCROLL FOR ON-PAGE ANCHOR LINKS
// -----------------------------------------------------------------
// Links like "View Services" point to "#services" on the SAME page.
// By default, clicking them jumps instantly. This makes that jump
// smooth and animated instead, which feels more polished.
// -----------------------------------------------------------------
document.querySelectorAll('a[href^="#"]').forEach(function (link) {
    link.addEventListener("click", function (event) {
        const targetId = this.getAttribute("href");

        // Ignore empty "#" links (like carousel buttons use "#" sometimes)
        if (targetId.length > 1) {
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                event.preventDefault(); // stop the instant jump
                targetElement.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            }
        }
    });
});


// -----------------------------------------------------------------
// 4. CLOSE MOBILE MENU AFTER CLICKING A LINK
// -----------------------------------------------------------------
// On mobile, the nav menu opens as a dropdown. Without this, clicking
// "About" would navigate away but the menu might still look "open"
// for a split second. This closes it immediately for a cleaner feel.
// -----------------------------------------------------------------
const navMenu = document.getElementById("navMenu");
const navLinks = document.querySelectorAll("#navMenu .nav-link, #navMenu .btn-nav-register");

navLinks.forEach(function (link) {
    link.addEventListener("click", function () {
        if (navMenu.classList.contains("show")) {
            // Use Bootstrap's own Collapse JS class to close the menu properly
            const bsCollapse = bootstrap.Collapse.getOrCreateInstance(navMenu);
            bsCollapse.hide();
        }
    });
});