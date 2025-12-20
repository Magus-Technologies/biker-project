/**
 * ========================================
 * 🔄 SISTEMA DE AUTOGUARDADO LOCAL
 * Sistema para guardar automáticamente ventas sin completar
 * ========================================
 */

let autoguardadoInterval = null;
const AUTOGUARDADO_KEY = 'venta_sin_completar';
const AUTOGUARDADO_INTERVALO = 10000; // 10 segundos

/**
 * Guarda automáticamente los datos de la venta en localStorage
 */
function autoguardarVenta() {
    try {
        // Verificar que salesData existe
        if (typeof salesData === 'undefined') {
            console.warn('⚠️ salesData no está definido aún');
            return;
        }

        // Recopilar todos los datos de las ventas activas
        const ventasActivas = [];
        
        salesData.forEach((data, tabId) => {
            const ventaData = {
                tabId: tabId,
                saleNumber: data.saleNumber,
                // Datos del cliente
                customer_dni: document.getElementById(`dni_personal_${tabId}`)?.value || '',
                customer_names: document.getElementById(`nombres_apellidos_${tabId}`)?.value || '',
                phone: document.getElementById(`phone_${tabId}`)?.value || '',
                motorcycle_model: document.getElementById(`motorcycle_model_${tabId}`)?.value || '',
                // Ubicación
                departamento: document.getElementById(`departamento_${tabId}`)?.value || '',
                provincia: document.getElementById(`provincia_${tabId}`)?.value || '',
                distrito: document.getElementById(`distrito_${tabId}`)?.value || '',
                // Mecánico
                mechanics_id: document.getElementById(`mechanics_id_${tabId}`)?.value || '',
                mecanico_select: document.getElementById(`mecanico_select_${tabId}`)?.value || '',
                // Productos y servicios
                products: data.products || [],
                services: data.services || [],
                quotationItems: data.quotationItems || [],
                // Documento
                documento: data.documento || {},
                // Timestamp
                timestamp: new Date().toISOString()
            };
            
            ventasActivas.push(ventaData);
        });

        // Solo guardar si hay datos
        if (ventasActivas.length > 0) {
            const dataToSave = {
                ventas: ventasActivas,
                savedAt: new Date().toISOString(),
                saleCounter: typeof saleCounter !== 'undefined' ? saleCounter : 0
            };
            
            localStorage.setItem(AUTOGUARDADO_KEY, JSON.stringify(dataToSave));
            console.log('✅ Autoguardado exitoso:', ventasActivas.length, 'venta(s)');
        } else {
            // Si no hay ventas, limpiar el localStorage
            localStorage.removeItem(AUTOGUARDADO_KEY);
        }
    } catch (error) {
        console.error('❌ Error en autoguardado:', error);
    }
}

/**
 * Verifica si hay ventas sin completar al cargar la página
 */
function verificarVentasSinCompletar() {
    try {
        const savedData = localStorage.getItem(AUTOGUARDADO_KEY);
        
        if (savedData) {
            const data = JSON.parse(savedData);
            const savedDate = new Date(data.savedAt);
            const now = new Date();
            const diffHours = (now - savedDate) / (1000 * 60 * 60);
            
            // Solo mostrar si tiene menos de 24 horas
            if (diffHours < 24 && data.ventas && data.ventas.length > 0) {
                // Mostrar banner de recuperación
                const banner = document.getElementById('recoveryBanner');
                const dateSpan = document.getElementById('recoveryDate');
                
                if (banner && dateSpan) {
                    dateSpan.textContent = savedDate.toLocaleString('es-PE', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    banner.classList.remove('hidden');
                }
                
                return true;
            }
        }
        
        return false;
    } catch (error) {
        console.error('❌ Error verificando ventas sin completar:', error);
        return false;
    }
}

/**
 * Recupera la venta guardada
 */
function recuperarVenta() {
    try {
        const savedData = localStorage.getItem(AUTOGUARDADO_KEY);
        
        if (!savedData) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se encontraron datos para recuperar',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }

        const data = JSON.parse(savedData);
        
        Swal.fire({
            title: '¿Recuperar venta?',
            html: `Se recuperarán <strong>${data.ventas.length}</strong> venta(s) guardada(s) el ${new Date(data.savedAt).toLocaleString('es-PE')}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, recuperar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Limpiar tabs existentes
                document.getElementById('tabHeaders').innerHTML = '';
                document.getElementById('tabContents').innerHTML = '';
                salesData.clear();
                
                // Restaurar contador
                saleCounter = data.saleCounter || 0;
                
                // Recrear cada venta
                data.ventas.forEach((ventaData, index) => {
                    setTimeout(() => {
                        addNewSaleTab();
                        const tabId = `sale-${saleCounter}`;
                        
                        // Esperar a que se cree el tab
                        setTimeout(() => {
                            restaurarDatosVenta(tabId, ventaData);
                        }, 300);
                    }, index * 400);
                });
                
                // Ocultar banner
                document.getElementById('recoveryBanner').classList.add('hidden');
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Recuperado!',
                    text: 'Los datos han sido restaurados correctamente',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    } catch (error) {
        console.error('❌ Error recuperando venta:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron recuperar los datos',
            confirmButtonColor: '#3b82f6'
        });
    }
}

/**
 * Restaura los datos de una venta específica
 */
function restaurarDatosVenta(tabId, ventaData) {
    try {
        // Restaurar datos del cliente
        const dniInput = document.getElementById(`dni_personal_${tabId}`);
        if (dniInput) dniInput.value = ventaData.customer_dni || '';
        
        const namesInput = document.getElementById(`nombres_apellidos_${tabId}`);
        if (namesInput) namesInput.value = ventaData.customer_names || '';
        
        const phoneInput = document.getElementById(`phone_${tabId}`);
        if (phoneInput) phoneInput.value = ventaData.phone || '';
        
        const motorcycleInput = document.getElementById(`motorcycle_model_${tabId}`);
        if (motorcycleInput) {
            motorcycleInput.value = ventaData.motorcycle_model || '';
            // Actualizar nombre del tab si la función existe
            if (typeof updateTabNameByMotorcycle === 'function') {
                updateTabNameByMotorcycle(tabId, ventaData.motorcycle_model);
            }
        }
        
        // Restaurar ubicación
        const deptoSelect = document.getElementById(`departamento_${tabId}`);
        if (deptoSelect && ventaData.departamento) {
            deptoSelect.value = ventaData.departamento;
            // Trigger change para cargar provincias
            deptoSelect.dispatchEvent(new Event('change'));
            
            setTimeout(() => {
                const provSelect = document.getElementById(`provincia_${tabId}`);
                if (provSelect && ventaData.provincia) {
                    provSelect.value = ventaData.provincia;
                    provSelect.dispatchEvent(new Event('change'));
                    
                    setTimeout(() => {
                        const distSelect = document.getElementById(`distrito_${tabId}`);
                        if (distSelect && ventaData.distrito) {
                            distSelect.value = ventaData.distrito;
                        }
                    }, 300);
                }
            }, 300);
        }
        
        // Restaurar mecánico
        const mechanicsIdInput = document.getElementById(`mechanics_id_${tabId}`);
        if (mechanicsIdInput) mechanicsIdInput.value = ventaData.mechanics_id || '';
        
        const mecanicoSelect = document.getElementById(`mecanico_select_${tabId}`);
        if (mecanicoSelect) mecanicoSelect.value = ventaData.mecanico_select || '';
        
        // Restaurar productos
        const data = salesData.get(tabId);
        if (data) {
            data.products = ventaData.products || [];
            data.services = ventaData.services || [];
            data.quotationItems = ventaData.quotationItems || [];
            data.documento = ventaData.documento || {};
            
            // Recalcular totales y actualizar tabla si la función existe
            if (typeof updateOrderTable === 'function' && (data.products.length > 0 || data.services.length > 0)) {
                updateOrderTable(tabId);
            }
            
            // Restaurar resumen de documento si existe
            if (data.documento && data.documento.tipoDocText) {
                const resumenTipoDoc = document.getElementById(`resumenTipoDoc_${tabId}`);
                const resumenTipoPago = document.getElementById(`resumenTipoPago_${tabId}`);
                const resumenMetodoPago = document.getElementById(`resumenMetodoPago_${tabId}`);
                const documentoResumen = document.getElementById(`documentoResumen_${tabId}`);
                
                if (resumenTipoDoc) resumenTipoDoc.textContent = data.documento.tipoDocText;
                if (resumenTipoPago) resumenTipoPago.textContent = data.documento.tipoPagoText;
                if (resumenMetodoPago) resumenMetodoPago.textContent = data.documento.metodoPagoText;
                if (documentoResumen) documentoResumen.classList.remove('hidden');
            }
        }
        
        console.log('✅ Datos restaurados para:', tabId);
    } catch (error) {
        console.error('❌ Error restaurando datos de venta:', error);
    }
}

/**
 * Descarta la venta guardada
 */
function descartarVenta() {
    Swal.fire({
        title: '¿Descartar venta?',
        text: 'Se eliminarán permanentemente los datos guardados',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, descartar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            localStorage.removeItem(AUTOGUARDADO_KEY);
            const banner = document.getElementById('recoveryBanner');
            if (banner) banner.classList.add('hidden');
            
            Swal.fire({
                icon: 'success',
                title: 'Descartado',
                text: 'Los datos han sido eliminados',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}

/**
 * Iniciar autoguardado automático
 */
function iniciarAutoguardado() {
    // Limpiar intervalo anterior si existe
    if (autoguardadoInterval) {
        clearInterval(autoguardadoInterval);
    }
    
    // Iniciar nuevo intervalo
    autoguardadoInterval = setInterval(() => {
        autoguardarVenta();
    }, AUTOGUARDADO_INTERVALO);
    
    console.log('🔄 Autoguardado iniciado (cada 10 segundos)');
}

/**
 * Limpiar autoguardado al guardar exitosamente
 */
function limpiarAutoguardado() {
    localStorage.removeItem(AUTOGUARDADO_KEY);
    console.log('🗑️ Autoguardado limpiado');
}

// Inicializar sistema de autoguardado al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si hay ventas sin completar
    setTimeout(() => {
        verificarVentasSinCompletar();
    }, 1000);
    
    // Iniciar autoguardado automático
    setTimeout(() => {
        iniciarAutoguardado();
    }, 2000);
    
    // Guardar antes de cerrar/recargar la página
    window.addEventListener('beforeunload', function(e) {
        autoguardarVenta();
    });
});

// Hook para limpiar autoguardado cuando se guarda exitosamente
// Esto se puede llamar desde la función saveSales original
window.limpiarAutoguardadoVenta = limpiarAutoguardado;
