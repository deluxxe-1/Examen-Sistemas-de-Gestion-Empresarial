<!-- pages/apidocs.php -->
<section id="apidocs" class="view-section">
    <div class="card">
        <h2>Centro de Desarrolladores API (Interoperabilidad)</h2>
        <p style="color:var(--text-secondary); margin-bottom: 2rem; font-size: 0.9rem;">
            Aquí encontrarás los detalles técnicos (Contrato API RESTful) para integrar servicios de terceros (como un CMS o ERP externo) con este sistema y leer o escribir datos.
        </p>

        <!-- Mock Swagger Header -->
        <div style="background-color: var(--bg-secondary); padding: 1rem; border-radius: 8px; border-left: 4px solid var(--success); margin-bottom: 2rem;">
            <strong>Base URL:</strong> <code>https://codaerp.empresa.com/api/v1/</code><br>
            <strong>Autenticación:</strong> <code>Bearer Token</code> en la cabecera <code>Authorization</code>
        </div>

        <h3>Endpoints Disponibles</h3>
        <table class="crm-table" style="margin-top: 1rem;">
            <thead>
                <tr>
                    <th>Método</th>
                    <th>Ruta</th>
                    <th>Descripción</th>
                    <th>Formato Datos</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="badge bg-blue" style="font-size: 0.7rem;">GET</span></td>
                    <td><code>/clientes</code></td>
                    <td>Listado en tiempo real de toda la cartera de CRM. Recupera el directorio completo.</td>
                    <td><code>application/json</code></td>
                </tr>
                <tr>
                    <td><span class="badge bg-green" style="font-size: 0.7rem;">POST</span></td>
                    <td><code>/clientes</code></td>
                    <td>Impacta un nuevo cliente en el sistema. Utilizado para formularios y webhooks.</td>
                    <td><code>application/json</code></td>
                </tr>
                <tr>
                    <td><span class="badge bg-blue" style="font-size: 0.7rem;">GET</span></td>
                    <td><code>/stats</code></td>
                    <td>Genera métricas consolidadas del Data Warehouse usando agregaciones SUM/COUNT SQL.</td>
                    <td><code>application/json</code></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>
