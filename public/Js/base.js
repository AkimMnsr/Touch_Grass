window.onload = function () {
    if (localStorage.getItem("popupShown") === null) {
        document.getElementById("art-info").style.display = "block";
        document.getElementById("close-popup").addEventListener("click", function () {
            document.getElementById("art-info").style.display = "none";
            localStorage.setItem("popupShown", true);
        });
    } else {
        document.getElementById("art-info").style.display = "none";
    }
};

function logout() {
    localStorage.removeItem('popupShown');
}


document.addEventListener('DOMContentLoaded', () => {

    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Add a click event on each of them
    $navbarBurgers.forEach(el => {
        el.addEventListener('click', () => {

            // Get the target from the "data-target" attribute
            const target = el.dataset.target;
            const $target = document.getElementById(target);

            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            el.classList.toggle('is-active');
            $target.classList.toggle('is-active');

        });
    });

});