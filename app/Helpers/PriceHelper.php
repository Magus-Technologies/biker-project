<?php

if (!function_exists('getPrecioClass')) {
    function getPrecioClass($precios, $mesActual) {
        $precioActual = $precios[$mesActual];
        if (!$precioActual) return '';
        
        // Obtener precios de meses anteriores para comparar
        $preciosAnteriores = [];
        for ($i = 1; $i < $mesActual; $i++) {
            if ($precios[$i]) {
                $preciosAnteriores[] = $precios[$i];
            }
        }
        
        if (empty($preciosAnteriores)) {
            return 'precio-normal';
        }
        
        $promedioAnterior = array_sum($preciosAnteriores) / count($preciosAnteriores);
        $diferencia = (($precioActual - $promedioAnterior) / $promedioAnterior) * 100;
        
        if ($diferencia > 10) {
            return 'precio-alto'; // Azul - precio alto
        } elseif ($diferencia < -10) {
            return 'precio-bajo'; // Rojo - precio bajo
        } elseif (abs($diferencia) <= 5) {
            return 'precio-estable'; // Verde - precio estable
        } else {
            return 'precio-normal'; // Amarillo - precio normal
        }
    }
}