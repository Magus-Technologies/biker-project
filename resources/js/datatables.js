// resources/js/datatables.js
import $ from 'jquery';
import 'datatables.net-dt';

// Hacer jQuery disponible globalmente
window.$ = window.jQuery = $;

// Configuración global para deshabilitar búsqueda automática
$.fn.dataTable.ext.classes.sFilterInput = 'dt-input-no-auto-search';

// Función para modificar el buscador existente y agregar botón
function addCustomSearch(tableId) {
    const wrapper = $(`#${tableId}_wrapper`);
    
    // Verificar si ya se modificó
    if (wrapper.find('.dt-search-button').length > 0) {
        return;
    }
    
    // Buscar el contenedor del filtro original
    const originalFilter = wrapper.find('.dataTables_filter');
    const originalLabel = originalFilter.find('label');
    
    // Intentar múltiples selectores para encontrar el input
    let originalInput = originalFilter.find('input[type="search"]');
    if (originalInput.length === 0) {
        originalInput = originalFilter.find('input');
    }
    if (originalInput.length === 0) {
        originalInput = wrapper.find('input[type="search"]');
    }
    if (originalInput.length === 0) {
        originalInput = wrapper.find('.dt-input');
    }
    
    if (originalInput.length === 0) {
        return;
    }
    
    // Obtener la instancia de DataTable
    const table = $(`#${tableId}`).DataTable();
    
    // CRÍTICO: Remover TODOS los event listeners del input
    const newInput = originalInput.clone(false); // Clonar sin eventos
    originalInput.replaceWith(newInput);
    
    // Crear el botón de búsqueda
    const searchButton = $('<button type="button" class="dt-search-button">Buscar</button>');
    
    // Obtener la altura del input para igualarla
    const inputHeight = newInput.outerHeight();
    
    // Aplicar estilos directamente con cssText para mayor prioridad
    searchButton[0].style.cssText = `
        padding: 0.5rem 1rem !important;
        background-color: #3b82f6 !important;
        color: white !important;
        border: none !important;
        border-radius: 0.375rem !important;
        cursor: pointer !important;
        font-weight: 500 !important;
        font-size: 0.875rem !important;
        white-space: nowrap !important;
        line-height: 1 !important;
        height: ${inputHeight}px !important;
        margin-left: 0.5rem !important;
        transition: background-color 0.2s !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        vertical-align: middle !important;
        box-sizing: border-box !important;
    `;
    
    // Hover effect
    searchButton.on('mouseenter', function() {
        this.style.backgroundColor = '#2563eb';
    }).on('mouseleave', function() {
        this.style.backgroundColor = '#3b82f6';
    });
    
    // Agregar el botón después del nuevo input
    newInput.after(searchButton);
    
    // Modificar el estilo del label para que sea flex
    originalLabel.css({
        'display': 'flex',
        'align-items': 'center',
        'gap': '0.5rem'
    });
    
    // Variable para almacenar el valor actual
    let currentSearchValue = '';
    
    // Función para ejecutar la búsqueda
    function performSearch() {
        const searchValue = newInput.val();
        if (searchValue !== currentSearchValue) {
            currentSearchValue = searchValue;
            table.search(searchValue).draw();
        }
    }
    
    // Evento click del botón
    searchButton.on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        performSearch();
    });
    
    // Evento Enter en el input
    newInput.on('keydown', function(e) {
        if (e.which === 13 || e.keyCode === 13) {
            e.preventDefault();
            e.stopPropagation();
            performSearch();
            return false;
        }
    });
    
    // Limpiar búsqueda cuando el input está vacío
    newInput.on('input', function(e) {
        if ($(this).val() === '') {
            currentSearchValue = '';
            table.search('').draw();
        }
    });
}

// Aplicar automáticamente a todas las tablas DataTables después de inicializarse
$(document).on('init.dt', function(e, settings) {
    const tableId = settings.nTable.id;
    const $table = $(settings.nTable);
    
    // No aplicar si la tabla tiene la clase 'no-search-button'
    if (tableId && !$table.hasClass('no-search-button')) {
        // Timeout reducido para que aparezca más rápido
        setTimeout(() => {
            addCustomSearch(tableId);
        }, 300);
    }
});

// También aplicar cuando el documento esté listo (por si las tablas ya están inicializadas)
$(document).ready(function() {
    setTimeout(() => {
        $('table.dataTable').each(function() {
            const tableId = $(this).attr('id');
            const $table = $(this);
            
            // No aplicar si la tabla tiene la clase 'no-search-button'
            if (tableId && $.fn.DataTable.isDataTable(`#${tableId}`) && !$table.hasClass('no-search-button')) {
                addCustomSearch(tableId);
            }
        });
    }, 500);
});

// También hacer la función disponible globalmente por si se necesita llamar manualmente
window.addCustomSearch = addCustomSearch;

export default $;
