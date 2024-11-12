// Load offcanvas scripts


document.addEventListener("DOMContentLoaded", function () {
    console.log("offcanvas.js loaded");
    var burgerIcon = document.getElementById("burger-icon");
    var offCanvas = document.getElementById("offcanvas");
    var overlay = document.getElementById("overlay");
    var body = document.body;

    function toggleOffCanvas() {
        // Toggle classes for off-canvas and overlay
        offCanvas.classList.toggle("-right-[500px]");
        offCanvas.classList.toggle("right-0");
        overlay.classList.toggle("hidden");
        body.classList.toggle("overflow-hidden");

        // Toggle the aria-expanded state
        var expanded = burgerIcon.getAttribute("aria-expanded") === "true";
        burgerIcon.setAttribute("aria-expanded", !expanded);
        burgerIcon.classList.toggle("close-mode");
    }

    // Add click event listener to burger icon
    burgerIcon.addEventListener("click", toggleOffCanvas);

    // Add click event listener to overlay
    overlay.addEventListener("click", toggleOffCanvas);
});



// Close offcanvas pressing Escape
// document.addEventListener("keyup", function (event) {
//     if (event.code === "Escape") {
//         if (offcanvasMenu.classList.contains("open")) {
//             offcanvasMenu.classList.remove("open");
//             overlayOffcanvas.classList.remove("open");
//             body.classList.remove("overflow-hidden");
//         }
//     }
// });