// assets/js/crm-logic.js

document.addEventListener('DOMContentLoaded', () => {
    
    // --- 1. ROUTING TITLES ---
    const pageTitle = document.getElementById('page-title');
    const titles = {
        'dashboard': 'Dashboard Analítico',
        'clientes': 'Directorio de Clientes',
        'seguridad': 'Seguridad y Credenciales',
        'apidocs': 'Documentación de Integración'
    };

    // Escuchar cambios de hash para actualizar títulos y recargar datos si procede
    window.addEventListener('hashchange', () => {
        const hash = window.location.hash.substring(1) || 'dashboard';
        if (titles[hash]) pageTitle.textContent = titles[hash];

        if (hash === 'clientes') {
            loadClientes();
        } else if (hash === 'dashboard') {
            loadDashboard();
        }
    });

    // --- 2. DASHBOARD (Pregunta 12: Informes) ---
    let chartsLoaded = false;
    let chartVentas, chartSegmentos;

    async function loadDashboard() {
        if (chartsLoaded) return;
        try {
            const res = await fetch('/api/stats');
            const data = await res.json();
            
            // Stats KPI
            let totalRevenue = 0;
            let totalClients = 0;
            
            // Prepare Chart 1 data (Ventas)
            let ventasLabels = ['Ene', 'Feb', 'Mar', 'Abr'];
            let ventasData = [1200, 1900, 3000, 1550]; // Fallback
            if (data?.data?.ventas?.length > 0) {
                ventasLabels = data.data.ventas.map(v => v.mes);
                ventasData = data.data.ventas.map(v => {
                    totalRevenue += parseFloat(v.revenue);
                    return v.revenue;
                });
            }
            
            // Prepare Chart 2 data (Segmentos)
            let segLabels = ['VIP', 'B2B', 'B2C', 'General'];
            let segData = [1, 2, 5, 2]; // Fallback
            if (data?.data?.clientes?.length > 0) {
                segLabels = data.data.clientes.map(c => c.segmento);
                segData = data.data.clientes.map(c => {
                    totalClients += parseInt(c.cantidad);
                    return c.cantidad;
                });
            }

            // Update UI KPIs
            document.getElementById('kpi-ingresos').textContent = totalRevenue.toLocaleString('es-ES') + ' €';
            document.getElementById('kpi-clientes').textContent = totalClients;

            // Render Charts
            const ctx1 = document.getElementById('ventasChart').getContext('2d');
            chartVentas = new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ventasLabels,
                    datasets: [{
                        label: 'Ingresos Brutos (€)',
                        data: ventasData,
                        backgroundColor: 'rgba(59, 130, 246, 0.7)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { labels: { color: '#f8fafc' } } }, scales: { y: { grid: { color: 'rgba(255,255,255,0.1)' } } } }
            });

            const ctx2 = document.getElementById('segmentosChart').getContext('2d');
            chartSegmentos = new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: segLabels,
                    datasets: [{ data: segData, backgroundColor: ['#3b82f6', '#10b981', '#a78bfa', '#f59e0b'], borderWidth: 0 }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right', labels: { color: '#f8fafc' } } } }
            });

            chartsLoaded = true;
        } catch(e) { console.error("Error cargando dashboard:", e); }
    }

    const btnRefreshCharts = document.getElementById('btn-refresh-charts');
    if (btnRefreshCharts) {
        btnRefreshCharts.addEventListener('click', () => {
            if (chartVentas) chartVentas.destroy();
            if (chartSegmentos) chartSegmentos.destroy();
            chartsLoaded = false;
            loadDashboard();
        });
    }


    // --- 3. CRM CLIENTES (Preguntas 1-3, 9-11: Consumo API CRUD) ---
    const tableBody = document.querySelector('#crm-clientes-table tbody');
    const modal = document.getElementById('modal-nuevo-cliente');
    const modalOverlay = document.getElementById('modal-overlay');
    const btnNuevoCliente = document.getElementById('btn-nuevo-cliente');
    const btnsCloseModal = document.querySelectorAll('.close-modal');
    const formCliente = document.getElementById('form-cliente');
    const btnSubmitCliente = document.getElementById('submit-cliente');

    function getSegmentBadge(segmento) {
        const colors = { 'VIP': 'bg-purple', 'B2B': 'bg-blue', 'B2C': 'bg-green', 'General': 'bg-gray' };
        return `<span class="badge ${colors[segmento] || 'bg-gray'}">${segmento}</span>`;
    }

    async function loadClientes() {
        if (!tableBody) return;
        tableBody.innerHTML = '<tr><td colspan="6" style="text-align:center;">Cargando directorio...</td></tr>';
        try {
            const res = await fetch('/api/clientes');
            const resJson = await res.json();
            
            if (resJson.status === 'success' && resJson.data.length > 0) {
                tableBody.innerHTML = '';
                resJson.data.forEach(c => {
                    tableBody.innerHTML += `
                        <tr>
                            <td>#${c.id}</td>
                            <td>
                                <strong>${c.nombre}</strong><br>
                                <span style="font-size:0.8rem; color:var(--text-secondary);">${c.empresa || '-'}</span>
                            </td>
                            <td>${c.email}</td>
                            <td>${getSegmentBadge(c.segmento)}</td>
                            <td style="font-size:0.85rem; color:var(--text-secondary);">${new Date(c.fecha_registro).toLocaleDateString()}</td>
                            <td class="action-btns">
                                <button class="btn btn-sm btn-secondary" onclick="alert('Demo: Editar ${c.id}')">✏️</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tableBody.innerHTML = '<tr><td colspan="6" style="text-align:center;">No hay clientes en la base de datos.</td></tr>';
            }
        } catch (e) {
            tableBody.innerHTML = `<tr><td colspan="6" style="text-align:center; color:red;">Error API: ${e.message}</td></tr>`;
        }
    }

    // Modal logic
    if (btnNuevoCliente) {
        btnNuevoCliente.addEventListener('click', () => {
            modal.classList.add('active');
            modalOverlay.classList.add('active');
        });
    }

    btnsCloseModal.forEach(btn => btn.addEventListener('click', () => {
        modal.classList.remove('active');
        modalOverlay.classList.remove('active');
    }));

    if (btnSubmitCliente) {
        btnSubmitCliente.addEventListener('click', async (e) => {
            e.preventDefault();
            const nombre = document.getElementById('fc-nombre').value;
            const email = document.getElementById('fc-email').value;
            if(!nombre || !email) return alert("Nombre y Email son obligatorios");

            btnSubmitCliente.disabled = true;
            btnSubmitCliente.textContent = "Impactando en DB...";

            const payload = {
                nombre: nombre,
                email: email,
                empresa: document.getElementById('fc-empresa').value,
                segmento: document.getElementById('fc-segmento').value
            };

            try {
                const res = await fetch('/api/clientes', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                if (res.ok) {
                    modal.classList.remove('active');
                    modalOverlay.classList.remove('active');
                    formCliente.reset();
                    loadClientes(); // Reload DB changes
                } else {
                    const error = await res.json();
                    alert("Error servidor: " + error.error);
                }
            } catch(e) { alert("Error red: " + e.message); }
            
            btnSubmitCliente.disabled = false;
            btnSubmitCliente.textContent = "Guardar Cliente (API POST)";
        });
    }


    // --- 4. SEGURIDAD & CRYPTO (Preguntas 4-5) ---
    async function callCryptoApi(accion, texto, resultBoxSelector) {
        const resultBox = document.querySelector(resultBoxSelector);
        try {
            const res = await fetch('/api/crypto', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ accion, texto })
            });
            const data = await res.json();
            resultBox.textContent = JSON.stringify(data, null, 2);
            if (window.hljs) hljs.highlightElement(resultBox);
            return data;
        } catch (e) {
            resultBox.textContent = JSON.stringify({error: e.message}, null, 2);
        }
    }

    const btnSecCifrar = document.getElementById('btn-sec-cifrar');
    if (btnSecCifrar) {
        btnSecCifrar.addEventListener('click', () => {
            const val = document.getElementById('sec-input-crypto').value;
            if(val) callCryptoApi('cifrar', val, '#sec-res-crypto').then(data => {
                if(data && data.resultado) document.getElementById('sec-input-crypto').value = data.resultado;
            });
        });

        document.getElementById('btn-sec-descifrar').addEventListener('click', () => {
            const val = document.getElementById('sec-input-crypto').value;
            if(val) callCryptoApi('descifrar', val, '#sec-res-crypto');
        });

        document.getElementById('btn-sec-hash').addEventListener('click', () => {
            const val = document.getElementById('sec-input-hash').value;
            if(val) callCryptoApi('hash', val, '#sec-res-hash');
        });
    }

    // Trigger initial load manually if no hashchange happens
    const currentHash = window.location.hash.substring(1) || 'dashboard';
    if(titles[currentHash]) pageTitle.textContent = titles[currentHash];
    if (currentHash === 'dashboard') loadDashboard();
    if (currentHash === 'clientes') loadClientes();
});
