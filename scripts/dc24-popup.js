document.addEventListener("DOMContentLoaded", function() {
    var infobox = document.getElementById("infobox");
    var infoboxButton = document.getElementById("infobox_button");
    var infoboxContent = document.getElementById("infobox-content");

    infobox.addEventListener("click", function() {
        if (infoboxContent.classList.contains("max-h-0")) {
            infoboxContent.classList.remove("max-h-0");
            infoboxContent.classList.add("max-h-screen");
        } else {
            infoboxContent.classList.remove("max-h-screen");
            infoboxContent.classList.add("max-h-0");
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var popupCloseButton = document.getElementById("popup-close");
    if (popupCloseButton) {
        popupCloseButton.addEventListener("click", function() {
            document.getElementById("popup").style.display = "none";
            setCookie("popupClosed", "true", 1);
        });
    }
});

function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}