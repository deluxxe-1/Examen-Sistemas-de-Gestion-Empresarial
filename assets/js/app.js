// assets/js/app.js
document.addEventListener('DOMContentLoaded', () => {
    const navItems = document.querySelectorAll('.nav-item');
    const viewSections = document.querySelectorAll('.view-section');

    function navigateTo(targetId) {
        // Actualizar nav
        navItems.forEach(item => {
            item.classList.remove('active');
            if(item.getAttribute('data-target') === targetId) {
                item.classList.add('active');
            }
        });

        // Actualizar vistas
        viewSections.forEach(section => {
            section.classList.remove('active');
            if(section.id === targetId) {
                section.classList.add('active');
            }
        });

        // Actualizar URL hash sin salto extra
        if (history.pushState) {
            history.pushState(null, null, '#' + targetId);
        } else {
            window.location.hash = '#' + targetId;
        }
    }

    // Interceptar clicks de nav
    navItems.forEach(item => {
        item.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = e.currentTarget.getAttribute('data-target');
            navigateTo(targetId);
        });
    });

    // Manejar carga inicial con hash
    if (window.location.hash) {
        const hash = window.location.hash.substring(1);
        const match = Array.from(navItems).find(i => i.getAttribute('data-target') === hash);
        if (match) {
            navigateTo(hash);
        } else {
            navigateTo('dashboard'); // por defecto
        }
    } else {
        navigateTo('dashboard'); // por defecto
    }
});
