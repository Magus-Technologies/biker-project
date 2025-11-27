 <!-- Modal de Detalles de Compra - NUEVO DISEÑO RESPONSIVO -->
    <div class="modal fade" id="buyDetailsModal" tabindex="-1" aria-labelledby="buyDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-gradient-to-r from-indigo-600 to-indigo-800 text-white">
                    <h5 class="modal-title d-flex align-items-center" id="buyDetailsModalLabel">
                        <i class="fas fa-shopping-cart me-2"></i>
                        <span>Detalles de Compra #<span id="buyNumber"></span></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body p-0">
                    <div id="buyDetailsContent" class="h-100 overflow-auto">
                        <div class="text-center py-5">
                            <div class="spinner-border text-indigo-600 mb-3" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                            <h6 class="text-muted">Cargando detalles de la compra...</h6>
                            <p class="text-muted mb-0">Por favor espere un momento</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>