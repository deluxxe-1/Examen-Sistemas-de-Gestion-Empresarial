// assets/js/app.js

let currentUser = null;

document.addEventListener('DOMContentLoaded', () => {
    const navItems = document.querySelectorAll('.nav-item');
    const viewSections = document.querySelectorAll('.view-section');
    const loginOverlay = document.getElementById('login-overlay');
    const formLogin = document.getElementById('form-login');
    const btnSubmitLogin = document.getElementById('btn-login-submit');

    // Elementos restringidos a roles (RBAC)
    const elementsAdminOnly = document.querySelectorAll('[data-target="seguridad"], #btn-nuevo-cliente');

    // ---- AUTH LOGIC ----
    async function checkSession() {
        try {
            const res = await fetch('/api/auth/me');
            const data = await res.json();
            if (data.status === 'success' && data.authed) {
                window.currentUser = data.user; // <- FIX
                applyRBAC();
                loginOverlay.classList.remove('active');
                initRouter();
            } else {
                loginOverlay.classList.add('active');
            }
        } catch (e) {
            console.error(e);
            loginOverlay.classList.add('active');
        }
    }

    function applyRBAC() {
        // Enseñar datos del usuario en sidebar
        const userAvatar = document.querySelector('.user-snippet .avatar');
        const userName = document.querySelector('.user-snippet .name');
        const userRole = document.querySelector('.user-snippet .role');
        
        if (userAvatar) userAvatar.textContent = window.currentUser.nombre.charAt(0);
        if (userName) userName.textContent = window.currentUser.nombre;
        if (userRole) userRole.textContent = window.currentUser.rol;

        // Ocultar opciones según rol
        const elementsAdminOnly = document.querySelectorAll('[data-target="seguridad"], [data-target="empleados"], #btn-nuevo-cliente');
        if (window.currentUser.rol !== 'Admin') {
            elementsAdminOnly.forEach(el => el.remove()); // Destrucción directa del DOM
        } else {
            elementsAdminOnly.forEach(el => el.classList.remove('auth-hidden'));
        }
    }

    if (formLogin) {
        formLogin.addEventListener('submit', async (e) => {
            e.preventDefault();
            btnSubmitLogin.disabled = true;
            btnSubmitLogin.textContent = 'Verificando...';

            const payload = {
                email: document.getElementById('login-email').value,
                password: document.getElementById('login-pass').value
            };

            try {
                const res = await fetch('/api/auth/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                
                if (res.ok) {
                    await checkSession(); // Recarga sesión
                } else {
                    alert('Credenciales inválidas');
                }
            } catch(e) {
                alert('Error de red');
            }
            btnSubmitLogin.disabled = false;
            btnSubmitLogin.textContent = 'Iniciar Sesión';
        });
    }

    // Botón de Logout (Inyectaremos uno dinamicamente si no existe)
    if (!document.getElementById('btn-logout')) {
        const logoutBtnMarkup = `<button id="btn-logout" class="btn btn-sm btn-danger" style="margin-top: 1rem; width: 100%;">Cerrar Sesión</button>`;
        const userSnippet = document.querySelector('.user-snippet');
        if(userSnippet) userSnippet.innerHTML += logoutBtnMarkup;
        
        setTimeout(() => {
            document.getElementById('btn-logout')?.addEventListener('click', async () => {
                await fetch('/api/auth/logout', { method: 'POST' });
                window.location.reload();
            });
        }, 500);
    }

    // ---- ROUTING LOGIC ----
    function navigateTo(targetId) {
        if (!window.currentUser) return; // Block routing if not logged in
        
        // Bloquear acceso a sección prohibida por RBAC URL manual
        if (window.currentUser.rol !== 'Admin' && (targetId === 'seguridad' || targetId === 'empleados')) {
            targetId = 'dashboard';
        }

        navItems.forEach(item => {
            item.classList.remove('active');
            if(item.getAttribute('data-target') === targetId) {
                item.classList.add('active');
            }
        });

        viewSections.forEach(section => {
            section.classList.remove('active');
            if(section.id === targetId) {
                section.classList.add('active');
            }
        });

        if (history.pushState) {
            history.pushState(null, null, '#' + targetId);
        } else {
            window.location.hash = '#' + targetId;
        }

        // Emit an event so crm-logic can react
        window.dispatchEvent(new Event('hashchange'));
    }

    function initRouter() {
        navItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = e.currentTarget.getAttribute('data-target');
                navigateTo(targetId);
            });
        });

        if (window.location.hash) {
            const hash = window.location.hash.substring(1);
            const match = Array.from(navItems).find(i => i.getAttribute('data-target') === hash);
            if (match) {
                navigateTo(hash);
            } else {
                navigateTo('dashboard');
            }
        } else {
            navigateTo('dashboard');
        }
    }

    // Boot app
    checkSession();
});
