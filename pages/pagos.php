<!-- pages/pagos.php -->
<section id="pagos" class="view-section">
    <div class="card">
        <div class="card-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
            <h2>Facturación y Pagos</h2>
            <button class="btn btn-secondary">📥 Exportar CSV</button>
        </div>

        <table class="crm-table" id="crm-pagos-table">
            <thead>
                <tr>
                    <th>Ref. Pedido</th>
                    <th>Cliente Asociado</th>
                    <th>Fecha</th>
                    <th>Importe</th>
                    <th>Método</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="6" style="text-align:center; padding: 2rem;">Cargando pagos desde API...</td></tr>
            </tbody>
        </table>
    </div>
</section>
