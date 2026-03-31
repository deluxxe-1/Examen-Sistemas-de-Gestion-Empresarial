<!-- pages/dashboard.php -->
<section id="dashboard" class="view-section active">
    <!-- Top KPI Cards -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-title">Ingresos Brutos MTD</div>
            <div class="kpi-value" id="kpi-ingresos">-- €</div>
            <div class="kpi-trend up">↑ 12.5% vs Mes Anterior</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Nuevos Clientes (30d)</div>
            <div class="kpi-value" id="kpi-clientes">--</div>
            <div class="kpi-trend up">↑ 8.1% vs Mes Anterior</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Valor Medio de Pedido</div>
            <div class="kpi-value">652.50 €</div>
            <div class="kpi-trend down">↓ 2.4% vs Mes Anterior</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-title">Tasa de Conversión</div>
            <div class="kpi-value">4.2%</div>
            <div class="kpi-trend neutral">→ Sin Cambios</div>
        </div>
    </div>

    <!-- Charts Area -->
    <div class="demo-grid">
        <div class="card" style="height: 380px;">
            <div class="card-header">
                <h2>Crecimiento de Ventas (YTD)</h2>
                <div class="card-actions">
                    <button id="btn-refresh-charts" class="btn btn-sm btn-secondary">↺ Recalcular</button>
                </div>
            </div>
            <div style="position:relative; height:280px; width:100%;">
                <canvas id="ventasChart"></canvas>
            </div>
        </div>
        <div class="card" style="height: 380px;">
            <div class="card-header">
                <h2>Distribución Segmentos CRM</h2>
            </div>
            <div style="position:relative; height:280px; width:100%;">
                <canvas id="segmentosChart"></canvas>
            </div>
        </div>
    </div>
</section>
