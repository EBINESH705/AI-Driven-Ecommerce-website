document.addEventListener("DOMContentLoaded", function () {
    let menu = document.querySelector('#menu-bars');
    let navbar = document.querySelector('.navbar');

    if (menu) {
        menu.onclick = () => {
            menu.classList.toggle('fa-times');
            navbar.classList.toggle('active');
        };
    }

    let updateButtons = document.querySelectorAll("form button[name='update_status']");
    updateButtons.forEach(button => {
        button.addEventListener("click", function (event) {
            let confirmUpdate = confirm("Are you sure you want to update this order?");
            if (!confirmUpdate) {
                event.preventDefault();
            }
        });
    });
});
