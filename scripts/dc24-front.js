import "./dc24-accordion-menu.js";
import "./dc24-offcanvas.js";

// Header scroll functionality
document.addEventListener("DOMContentLoaded", function() {
    const header = document.getElementById("menu-container");
    const logoImg = document.querySelector(".logo-img");
    const logoContainer = document.querySelector(".logo-container");
    const navigation = document.querySelector("#primary-menu");
    
    if (!header) return;
    
    function handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 50) {
            // Scrolled down - apply compact styles
            header.classList.add("header-scrolled");
            if (logoImg) {
                logoImg.classList.add("logo-scrolled");
            }
            if (logoContainer) {
                logoContainer.classList.add("logo-container-scrolled");
            }
            if (navigation) {
                navigation.classList.add("navigation-scrolled");
            }
        } else {
            // At top - remove compact styles
            header.classList.remove("header-scrolled");
            if (logoImg) {
                logoImg.classList.remove("logo-scrolled");
            }
            if (logoContainer) {
                logoContainer.classList.remove("logo-container-scrolled");
            }
            if (navigation) {
                navigation.classList.remove("navigation-scrolled");
            }
        }
    }
    
    // Add scroll event listener
    window.addEventListener("scroll", handleScroll);
    
    // Call once on load to set initial state
    handleScroll();
});

document.querySelectorAll('mark').forEach(mark => {
    const bg = getComputedStyle(mark).backgroundColor;
    if (bg && bg !== 'rgba(0, 0, 0, 0)' && bg !== 'transparent') {
      mark.style.setProperty('--highlight-color', bg);
    }
  });