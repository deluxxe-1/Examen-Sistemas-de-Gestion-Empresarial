<!-- pages/seguridad.php -->
<section id="seguridad" class="view-section">
    <div class="card">
        <h2>Herramientas de Seguridad del Workspace</h2>
        <p style="color:var(--text-secondary); font-size: 0.9rem; margin-bottom: 2rem;">
            Administra secretos, genera credenciales cifradas y comprueba hashes antes de inyectarlos en la BD.
        </p>
        
        <div class="demo-grid">
            <!-- Left: Cifrado Simétrico (AES) -->
            <div class="sec-card" style="border:1px solid rgba(255,255,255,0.1); border-radius:8px; padding:1.5rem;">
                <h3 style="color:#3b82f6; margin-bottom: 1rem;"><span class="logo-icon">🔐</span> Encriptación (AES-256)</h3>
                <p style="font-size:0.8rem; color:var(--text-secondary); margin-bottom:1rem;">
                    Ideal para guardar Tokens de terceros. Cifrado de ida y vuelta recuperable con la Master Key del SSGG.
                </p>
                <div class="form-group">
                    <input type="text" id="sec-input-crypto" placeholder="Ej: Token de Pasarela Pago">
                </div>
                <div style="display:flex; gap:0.5rem; margin-bottom:1rem;">
                    <button id="btn-sec-cifrar" class="btn btn-sm">Cifrar</button>
                    <button id="btn-sec-descifrar" class="btn btn-sm btn-secondary">Descifrar</button>
                </div>
                <div class="sec-console">
                    <pre><code class="language-json" id="sec-res-crypto">Esperando instrucción...</code></pre>
                </div>
            </div>

            <!-- Right: Hashing Irreversible -->
            <div class="sec-card" style="border:1px solid rgba(255,255,255,0.1); border-radius:8px; padding:1.5rem;">
                <h3 style="color:#a78bfa; margin-bottom: 1rem;"><span class="logo-icon">🔑</span> Hash de Credenciales</h3>
                <p style="font-size:0.8rem; color:var(--text-secondary); margin-bottom:1rem;">
                    Generación de Hashes irreversibles (Bcrypt / SHA-256). Destinado a campos como <code>password</code> de los Usuarios del SSGG.
                </p>
                <div class="form-group">
                    <input type="password" id="sec-input-hash" placeholder="Ej: Contraseña Usuario Adm">
                </div>
                <div style="display:flex; gap:0.5rem; margin-bottom:1rem;">
                    <button id="btn-sec-hash" class="btn btn-sm" style="background-color:#8b5cf6;">Generar Hashes</button>
                </div>
                <div class="sec-console">
                    <pre><code class="language-json" id="sec-res-hash">Esperando instrucción...</code></pre>
                </div>
            </div>
        </div>
    </div>
</section>
