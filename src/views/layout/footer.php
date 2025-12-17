    </main> <!-- Cierre del contenido-principal -->
    
    <!-- FOOTER CON TU ESTILO -->
    <footer class="footer-jardin">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start text-center">
                    <p class="mb-0">
                        <i class="fas fa-copyright"></i> <?php echo date('Y'); ?> 
                        Sistema de Gestión de Jardinería
                    </p>
                </div>
                <div class="col-md-6 text-md-end text-center mt-md-0 mt-2">
                    <p class="mb-0">
                        <i class="fas fa-envelope me-2"></i> contacto@jardineria.com 
                        <span class="mx-2 d-none d-md-inline">•</span>
                        <br class="d-md-none">
                        <i class="fas fa-phone me-2"></i> +1 234 567 890
                    </p>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12 text-center">
                    <p class="mb-0" style="font-size: 13px; opacity: 0.8;">
                        <i class="fas fa-leaf"></i> Cultivando el futuro, un jardín a la vez
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="<?php echo asset('assets/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    
    <!-- jQuery (opcional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Scripts personalizados -->
    <script src="<?php echo asset('assets/js/app.js'); ?>"></script>
    
    <!-- Scripts adicionales -->
    <script>
        // Activar tooltips de Bootstrap
        document.addEventListener('DOMContentLoaded', function() {
            // Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Auto-ocultar alertas después de 5 segundos
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
            
            // Confirmar antes de eliminar
            document.addEventListener('click', function(e) {
                if (e.target.matches('.btn-eliminar') || e.target.closest('.btn-eliminar')) {
                    if (!confirm('¿Estás seguro de que deseas eliminar este elemento? Esta acción no se puede deshacer.')) {
                        e.preventDefault();
                        return false;
                    }
                }
                
                // Confirmar antes de cancelar
                if (e.target.matches('.btn-cancelar') || e.target.closest('.btn-cancelar')) {
                    if (!confirm('¿Estás seguro de que deseas cancelar esta acción?')) {
                        e.preventDefault();
                        return false;
                    }
                }
            });
            
            // Validación de formularios
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
            
            // Auto-focus en el primer campo de formularios
            var firstInput = document.querySelector('form input[type="text"], form input[type="email"], form input[type="password"], form textarea, form select');
            if (firstInput && !firstInput.value) {
                firstInput.focus();
            }
        });
        
        // Función para formatear números
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
</body>
</html>