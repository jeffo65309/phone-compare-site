// navbar.js
// Handle opening and closing the burger menu manually (bootstrap not working as hoped)
document.addEventListener('DOMContentLoaded', function() {
    const toggler = document.querySelector('.navbar-toggler');
    const menu = document.getElementById('navbarNav');

    if (toggler && menu) {
        toggler.addEventListener('click', function() {
            if (menu.classList.contains('show')) {
                menu.classList.remove('show');
            } else {
                menu.classList.add('show');
            }
        });

      // close the menu if you click on any nav link 
        const navLinks = document.querySelectorAll('#navbarNav .nav-link, #navbarNav .btn');
        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (menu.classList.contains('show')) {
                    menu.classList.remove('show');
                }
            });
        });
    }
});