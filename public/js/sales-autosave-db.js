/**
 * ========================================
 * 🔄 SISTEMA DE AUTOGUARDADO EN BASE DE DATOS
 * Sistema para guardar automáticamente ventas pendientes en DB por usuario
 * ========================================
 */

let autoguardadoInterval = null;
const AUTOGUARDADO_INTERVALO = 10000; // 10 segundos
const TIPO_VENTA = window.location.pathname.includes('bulk-create') ? 'bulk_create' : 'create';

/**
 * Guarda automáticamente los datos de la venta en la base de datos
 */
async function autoguardarVentaDB() {
    try {
        // Verificar que salesData existe
        if (typeof salesData === 'undefined') {
            console.warn('⚠️ salesData no está definido aún');
            return;
        }

        // Recopilar todos los datos de las ventas activas
        const ventasActivas = [];
        
        salesData.forEach((data, tabId) => {
            // 🔍 VALIDAR QUE HAYA DATOS REALES ANTES DE GUARDAR
            const customerDni = document.getElementById(`dni_personal_${tabId}`)?.value || document.getElementById('dni_personal')?.value || '';
            const customerNames = document.getElementById(`nombres_apellidos_${tabId}`)?.value || document.getElementById('nombres_apellidos')?.value || '';
            const phone = document.getElementById(`phone_${tabId}`)?.value || document.getElementById('phone')?.value || '';
            const hasProducts = (data.products && data.products.length > 0) || (data.quotationItems && data.quotationItems.length > 0);
            const hasServices = data.services && data.services.length > 0;
            
            // ✅ SOLO GUARDAR SI HAY AL MENOS UN DATO REAL
            const hasRealData = customerDni || customerNames || phone || hasProducts || hasServices;
            
            if (!hasRealData) {
                console.log('⚠️ Tab sin datos reales, omitiendo:', tabId);
                return; // Saltar este tab
            }
            
            const ventaData = {
                tabId: tabId,
                saleNumber: data.saleNumber,
                // Datos del cliente
                customer_dni: customerDni,
                customer_names: customerNames,
                phone: phone,
                motorcycle_model: document.getElementById(`motorcycle_model_${tabId}`)?.value || document.getElementById('motorcycle_model')?.value || '',
                // Ubicación
                departamento: document.getElementById(`departamento_${tabId}`)?.value || document.getElementById('departamento')?.value || '',
                provincia: document.getElementById(`provincia_${tabId}`)?.value || document.getElementById('provincia')?.value || '',
                distrito: document.getElementById(`distrito_${tabId}`)?.value || document.getElementById('distrito')?.value || '',
                // Mecánico
                mechanics_id: document.getElementById(`mechanics_id_${tabId}`)?.value || document.getElementById('mechanics_id')?.value || '',
                mecanico_select: document.getElementById(`mecanico_select_${tabId}`)?.value || document.getElementById('mecanico_select')?.value || '',
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

        // ✅ SOLO GUARDAR SI HAY VENTAS CON DATOS REALES
        if (ventasActivas.length === 0) {
            console.log('⚠️ No hay ventas con datos reales para guardar');
            return;
        }

        const dataToSave = {
            ventas: ventasActivas,
            saleCounter: typeof saleCounter !== 'undefined' ? saleCounter : 0
        };

        // Enviar a la base de datos
        const response = await fetch('/ventas-pendientes/guardar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                tipo: TIPO_VENTA,
                datos: dataToSave
            })
        });

        if (!response.ok) {
            throw new Error('Error al guardar en base de datos');
        }

        const result = await response.json();
        console.log('✅ Autoguardado en DB exitoso:', ventasActivas.length, 'venta(s) con datos reales', '- Fecha:', result.fecha_guardado);
        
    } catch (error) {
        console.error('❌ Error en autoguardado DB:', error);
    }
}

/**
 * Verifica si hay ventas pendientes en la base de datos
 */
async function verificarVentasPendientesDB() {
    try {
        const response = await fetch(`/ventas-pendientes/verificar?tipo=${TIPO_VENTA}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        });

        if (!response.ok) {
            return false;
        }

        const result = await response.json();
        
        if (result.success && result.existe) {
            // Mostrar banner de recuperación
            const banner = document.getElementById('recoveryBanner');
            const dateSpan = document.getElementById('recoveryDate');
            
            if (banner && dateSpan) {
                dateSpan.textContent = result.fecha_guardado;
                banner.classList.remove('hidden');
            }
            
            return true;
        }
        
        return false;
    } catch (error) {
        console.error('❌ Error verificando ventas pendientes DB:', error);
        return false;
    }
}

/**
 * Recupera la venta guardada desde la base de datos
 */
async function recuperarVentaDB() {
    try {
        const response = await fetch(`/ventas-pendientes/obtener?tipo=${TIPO_VENTA}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            }
        });

        if (!response.ok) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se encontraron datos para recuperar',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }

        const result = await response.json();
        
        if (!result.success || !result.venta_pendiente) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se encontraron datos para recuperar',
                confirmButtonColor: '#3b82f6'
            });
            return;
        }

        const data = result.venta_pendiente.datos;
        
        Swal.fire({
            title: '¿Recuperar venta?',
            html: `Se recuperarán <strong>${data.ventas.length}</strong> venta(s) guardada(s) el ${result.venta_pendiente.fecha_guardado}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, recuperar',
            cancelButtonText: 'Cancelar'
        }).then((resultConfirm) => {
            if (resultConfirm.isConfirmed) {
                // Limpiar tabs existentes
                document.getElementById('tabHeaders').innerHTML = '';
                document.getElementById('tabContents').innerHTML = '';
                if (typeof salesData !== 'undefined') {
                    salesData.clear();
                }
                
                // Restaurar contador
                if (typeof saleCounter !== 'undefined') {
                    saleCounter = data.saleCounter || 0;
                }
                
                // Recrear cada venta
                data.ventas.forEach((ventaData, index) => {
                    setTimeout(() => {
                        if (typeof addNewSaleTab === 'function') {
                            addNewSaleTab();
                            const tabId = TIPO_VENTA === 'bulk_create' ? `sale-${saleCounter}` : 'main';
                            
                            // Esperar a que se cree el tab
                            setTimeout(() => {
                                restaurarDatosVentaDB(tabId, ventaData);
                            }, 300);
                        }
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
        console.error('❌ Error recuperando venta DB:', error);
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
function restaurarDatosVentaDB(tabId, ventaData) {
    try {
        // Determinar si es bulk_create o create
        const suffix = TIPO_VENTA === 'bulk_create' ? `_${tabId}` : '';
        
        // Restaurar datos del cliente
        const dniInput = document.getElementById(`dni_personal${suffix}`);
        if (dniInput) dniInput.value = ventaData.customer_dni || '';
        
        const namesInput = document.getElementById(`nombres_apellidos${suffix}`);
        if (namesInput) namesInput.value = ventaData.customer_names || '';
        
        const phoneInput = document.getElementById(`phone${suffix}`);
        if (phoneInput) phoneInput.value = ventaData.phone || '';
        
        const motorcycleInput = document.getElementById(`motorcycle_model${suffix}`);
        if (motorcycleInput) {
            motorcycleInput.value = ventaData.motorcycle_model || '';
            // Actualizar nombre del tab si la función existe
            if (typeof updateTabNameByMotorcycle === 'function' && TIPO_VENTA === 'bulk_create') {
                updateTabNameByMotorcycle(tabId, ventaData.motorcycle_model);
            }
        }
        
        // Restaurar ubicación
        const deptoSelect = document.getElementById(`departamento${suffix}`);
        if (deptoSelect && ventaData.departamento) {
            deptoSelect.value = ventaData.departamento;
            deptoSelect.dispatchEvent(new Event('change'));
            
            setTimeout(() => {
                const provSelect = document.getElementById(`provincia${suffix}`);
                if (provSelect && ventaData.provincia) {
                    provSelect.value = ventaData.provincia;
                    provSelect.dispatchEvent(new Event('change'));
                    
                    setTimeout(() => {
                        const distSelect = document.getElementById(`distrito${suffix}`);
                        if (distSelect && ventaData.distrito) {
                            distSelect.value = ventaData.distrito;
                        }
                    }, 300);
                }
            }, 300);
        }
        
        // Restaurar mecánico
        const mechanicsIdInput = document.getElementById(`mechanics_id${suffix}`);
        if (mechanicsIdInput) mechanicsIdInput.value = ventaData.mechanics_id || '';
        
        const mecanicoSelect = document.getElementById(`mecanico_select${suffix}`);
        if (mecanicoSelect) mecanicoSelect.value = ventaData.mecanico_select || '';
        
        // Restaurar productos
        if (typeof salesData !== 'undefined') {
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
                    const resumenTipoDoc = document.getElementById(`resumenTipoDoc${suffix}`);
                    const resumenTipoPago = document.getElementById(`resumenTipoPago${suffix}`);
                    const resumenMetodoPago = document.getElementById(`resumenMetodoPago${suffix}`);
                    const documentoResumen = document.getElementById(`documentoResumen${suffix}`);
                    
                    if (resumenTipoDoc) resumenTipoDoc.textContent = data.documento.tipoDocText;
                    if (resumenTipoPago) resumenTipoPago.textContent = data.documento.tipoPagoText;
                    if (resumenMetodoPago) resumenMetodoPago.textContent = data.documento.metodoPagoText;
                    if (documentoResumen) documentoResumen.classList.remove('hidden');
                }
            }
        }
        
        console.log('✅ Datos restaurados desde DB para:', tabId);
    } catch (error) {
        console.error('❌ Error restaurando datos de venta DB:', error);
    }
}

/**
 * Descarta la venta guardada en la base de datos
 */
async function descartarVentaDB() {
    const result = await Swal.fire({
        title: '¿Descartar venta?',
        text: 'Se eliminarán permanentemente los datos guardados',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, descartar',
        cancelButtonText: 'Cancelar'
    });
    
    if (!result.isConfirmed) return;
    
    try {
        const response = await fetch('/ventas-pendientes/limpiar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                tipo: TIPO_VENTA
            })
        });

        if (!response.ok) {
            throw new Error('Error al descartar venta');
        }

        const banner = document.getElementById('recoveryBanner');
        if (banner) banner.classList.add('hidden');
        
        Swal.fire({
            icon: 'success',
            title: 'Descartado',
            text: 'Los datos han sido eliminados',
            timer: 1500,
            showConfirmButton: false
        });
    } catch (error) {
        console.error('❌ Error descartando venta DB:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo descartar la venta',
            confirmButtonColor: '#3b82f6'
        });
    }
}

/**
 * Iniciar autoguardado automático
 */
function iniciarAutoguardadoDB() {
    // Limpiar intervalo anterior si existe
    if (autoguardadoInterval) {
        clearInterval(autoguardadoInterval);
    }
    
    // Iniciar nuevo intervalo
    autoguardadoInterval = setInterval(() => {
        autoguardarVentaDB();
    }, AUTOGUARDADO_INTERVALO);
    
    console.log('🔄 Autoguardado en DB iniciado (cada 10 segundos) - Tipo:', TIPO_VENTA);
}

/**
 * Limpiar autoguardado al guardar exitosamente
 */
async function limpiarAutoguardadoDB() {
    try {
        const response = await fetch('/ventas-pendientes/limpiar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                tipo: TIPO_VENTA
            })
        });

        if (response.ok) {
            console.log('🗑️ Autoguardado DB limpiado - Tipo:', TIPO_VENTA);
        }
    } catch (error) {
        console.error('❌ Error limpiando autoguardado DB:', error);
    }
}

// Inicializar sistema de autoguardado al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si hay ventas pendientes
    setTimeout(() => {
        verificarVentasPendientesDB();
    }, 1000);
    
    // Iniciar autoguardado automático
    setTimeout(() => {
        iniciarAutoguardadoDB();
    }, 2000);
    
    // Guardar antes de cerrar/recargar la página
    window.addEventListener('beforeunload', function(e) {
        autoguardarVentaDB();
    });
});

// Exponer funciones globalmente para uso en las vistas
window.recuperarVenta = recuperarVentaDB;
window.descartarVenta = descartarVentaDB;
window.limpiarAutoguardadoVenta = limpiarAutoguardadoDB;
