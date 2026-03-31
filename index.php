<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_TITLE ?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js para Informes -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Highlight.js para código Swagger -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/atom-one-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <span class="logo-icon">💠</span>
                    <h2>CodaERP</h2>
                </div>
                <p class="subtitle">Cloud Workspace</p>
            </div>
            
            <!-- User Profile Snippet (Demo) -->
            <div class="user-snippet">
                <div class="avatar">A</div>
                <div class="user-info">
                    <span class="name">Admin User</span>
                    <span class="role">Owner</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <h3>PRINCIPAL</h3>
                    <a href="#dashboard" class="nav-item active" data-target="dashboard">
                        <span class="nav-icon">📊</span> Dashboard
                    </a>
                    <a href="#clientes" class="nav-item" data-target="clientes">
                        <span class="nav-icon">👥</span> CRM Clientes
                    </a>
                </div>
                <div class="nav-section">
                    <h3>SISTEMA</h3>
                    <a href="#seguridad" class="nav-item" data-target="seguridad">
                        <span class="nav-icon">🔒</span> Seguridad
                    </a>
                    <a href="#apidocs" class="nav-item" data-target="apidocs">
                        <span class="nav-icon">🔌</span> API Developers
                    </a>
                </div>
            </nav>
            <div class="sidebar-footer">
                <p>Versión <?= APP_VERSION ?></p>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <header class="top-header">
                <h1 id="page-title">Dashboard Analítico</h1>
                <div class="header-actions">
                    <!-- Notifications, Search, etc -->
                    <div class="search-bar">
                        <input type="text" placeholder="Buscar global (Ctrl+K)...">
                    </div>
                    <span class="status-badge"><span class="dot pulse"></span> Online</span>
                </div>
            </header>

            <div class="content-wrapper">
                <!-- Vistas de la aplicación (SPA routing) -->
                <?php include 'pages/dashboard.php'; ?>
                <?php include 'pages/clientes.php'; ?>
                <?php include 'pages/seguridad.php'; ?>
                <?php include 'pages/apidocs.php'; ?>
            </div>
        </main>
    </div>

    <!-- Modals Overlay -->
    <div id="modal-overlay" class="modal-overlay"></div>

    <script src="assets/js/app.js"></script>
    <script src="assets/js/crm-logic.js"></script>
    <script>hljs.highlightAll();</script>
</body>
</html>
