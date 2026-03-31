<!-- pages/empleados.php -->
<section id="empleados" class="view-section">
    <div class="card">
        <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
            <h2>Directorio de Personal</h2>
            <button class="btn">👤 Añadir Empleado</button>
        </div>

        <p style="color:var(--text-secondary); margin-bottom: 2rem; font-size: 0.9rem;">
            Este módulo es de uso restringido (Sólo Administradores). Permite gestionar la plantilla interna y sus privilegios (RBAC).
        </p>

        <table class="crm-table" id="crm-empleados-table">
            <thead>
                <tr>
                    <th>ID Empleado</th>
                    <th>Nombre y Apellidos</th>
                    <th>Email Corporativo</th>
                    <th>Rol de Acceso</th>
                    <th>Alta en Sistema</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="5" style="text-align:center; padding: 2rem;">Cargando empleados desde API...</td></tr>
            </tbody>
        </table>
    </div>
</section>
