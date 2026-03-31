<!-- pages/clientes.php -->
<section id="clientes" class="view-section">
    <div class="card">
        <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
            <h2>Gestión de Clientes Activos</h2>
            <button id="btn-nuevo-cliente" class="btn">
                <span class="nav-icon">+</span> Nuevo Cliente
            </button>
        </div>

        <!-- Data Table -->
        <table class="crm-table" id="crm-clientes-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre / Empresa</th>
                    <th>Email Contacto</th>
                    <th>Segmento</th>
                    <th>Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Se llenará dinamicamente con JS (crm-logic.js) vía fetch API -->
                <tr>
                    <td colspan="6" style="text-align:center; padding: 2rem;">Cargando directorio de clientes por API...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal Form -->
    <div id="modal-nuevo-cliente" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Añadir Nuevo Cliente al CRM</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="form-cliente">
                    <div class="form-group">
                        <label>Nombre Completo *</label>
                        <input type="text" id="fc-nombre" required placeholder="Ej: Elena Torres">
                    </div>
                    <div class="form-group">
                        <label>Correo Electrónico *</label>
                        <input type="email" id="fc-email" required placeholder="elena@empresa.com">
                    </div>
                    <div class="form-group">
                        <label>Nombre Empresa</label>
                        <input type="text" id="fc-empresa" placeholder="Opcional">
                    </div>
                    <div class="form-group">
                        <label>Segmento de Mercado</label>
                        <select id="fc-segmento">
                            <option value="B2B">B2B (Empresa)</option>
                            <option value="B2C">B2C (Consumidor)</option>
                            <option value="VIP">Cliente VIP</option>
                            <option value="General" selected>General</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary close-modal" style="margin-right: 0.5rem;">Cancelar</button>
                <button id="submit-cliente" class="btn">Guardar Cliente (API POST)</button>
            </div>
        </div>
    </div>
</section>
