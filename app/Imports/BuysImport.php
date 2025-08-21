<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\PaymentMethod;
use App\Models\Tienda;
use App\Models\DocumentType;
use Illuminate\Support\Facades\Log;


class BuysImport implements ToArray, WithHeadingRow
{
    public function array(array $array): array
    {
        // Solo retornar el array original para que el controlador lo procese
        return $array;
    }
    
    // Busca el método processRow() (alrededor de línea 20) y reemplázalo completamente:
    private function processRow($row, $rowNumber)
    {
        // Saltar filas completamente vacías
        $hasData = false;
        foreach ($row as $value) {
            if ($value !== null && $value !== '') {
                $hasData = true;
                break;
            }
        }
        
        if (!$hasData) {
            return null; // Retornar null para filas vacías
        }
        
        // Campos requeridos actualizados (sin proveedor ni tienda)
        $requiredFields = [
            'fecha_compra_yyyy_mm_dd' => 'Fecha Compra',
            'tipo_documento' => 'Tipo Documento',
            'sku_producto' => 'SKU Producto', 
            'cantidad' => 'Cantidad',
            'precio_unitario' => 'Precio Unitario',
            'metodo_de_pago' => 'Método de Pago',
            'estado_de_entrega' => 'Estado de Entrega'
        ];
        
        // Convertir nombres de columnas a snake_case para coincidir con WithHeadingRow
        $normalizedRow = [];
        foreach ($row as $key => $value) {
            // Convertir espacios y caracteres especiales
            $normalizedKey = strtolower(str_replace([' ', '(', ')', '-', '*'], ['_', '', '', '_', ''], $key));
            $normalizedRow[$normalizedKey] = $value;
        }
        $row = $normalizedRow;
        
        // Validar campos requeridos
        foreach ($requiredFields as $key => $label) {
            if (!isset($row[$key]) || $row[$key] === null || $row[$key] === '') {
                throw new \Exception("El campo '{$label}' es requerido");
            }
        }        

        // Validar producto
        $product = $this->validateProduct($row['sku_producto']);
        
        // Validar método de pago
        $paymentMethod = $this->validatePaymentMethod($row['metodo_de_pago']);
        
        // Validar estado de entrega
        $deliveryStatus = $this->validateDeliveryStatus($row['estado_de_entrega']);
        
        // Validar tipo de documento
        $documentType = $this->validateDocumentType($row['tipo_documento']);
        
        // Validar fecha
        $fecha = $this->validateDate($row['fecha_compra_yyyy_mm_dd']);
        
        // Validar cantidad y precio
        $cantidad = $this->validateNumber($row['cantidad'], 'Cantidad');
        $precio = $this->validateNumber($row['precio_unitario'], 'Precio Unitario');
        
        return [
            'product' => $product,
            'payment_method' => $paymentMethod,
            'delivery_status' => $deliveryStatus,
            'document_type' => $documentType,
            'fecha' => $fecha,
            'cantidad' => $cantidad,
            'precio' => $precio,
            'observacion' => $row['observacion'] ?? '',
            'row_data' => $row
            // Eliminado: 'supplier', 'tienda' ya que no se necesitan
        ];
    }
    
    private function validateProduct($sku)
    {
        $product = Product::where('code_sku', $sku)->where('status', 1)->first();
        
        if (!$product) {
            throw new \Exception("No se encontró el producto con SKU: {$sku}");
        }
        
        return $product;
    }
    
    private function validatePaymentMethod($name)
    {
        $paymentMethod = PaymentMethod::where('name', $name)->where('status', 1)->first();
        
        if (!$paymentMethod) {
            throw new \Exception("No se encontró el método de pago: {$name}");
        }
        
        return $paymentMethod;
    }
    
    private function validateDeliveryStatus($status)
    {
        $statusMap = [
            'Productos Recibidos' => 'received',
            'Productos Pendientes' => 'pending'
        ];
        
        if (!isset($statusMap[$status])) {
            throw new \Exception("Estado de entrega inválido: {$status}");
        }
        
        return $statusMap[$status];
    }
      
    private function validateDocumentType($name)
    {
        $documentType = DocumentType::where('name', $name)->first();
        
        if (!$documentType) {
            throw new \Exception("Tipo de documento inválido: {$name}");
        }
        
        return $documentType;
    }
    
    private function validateDate($date)
    {
        try {
            return \Carbon\Carbon::createFromFormat('Y-m-d', $date);
        } catch (\Exception $e) {
            throw new \Exception("Fecha inválida: {$date}. Use formato YYYY-MM-DD");
        }
    }
    
    private function validateNumber($value, $field)
    {
        if (!is_numeric($value) || $value <= 0) {
            throw new \Exception("{$field} debe ser un número mayor a 0");
        }
        
        return floatval($value);
    }

    // Agregar este nuevo método al final de la clase (antes del último })
    public function processImportData(array $array): array
    {
        $processedData = [];
        $errors = [];
        
        foreach ($array as $index => $row) {
            $rowNumber = $index + 2; // +2 porque empezamos en fila 2 (después del header)
            

            try {
                $processedRow = $this->processRow($row, $rowNumber);
                if ($processedRow) {
                    $processedData[] = $processedRow;
                }
            } catch (\Exception $e) {
                $errors[] = "Fila {$rowNumber}: " . $e->getMessage();
            }
        }
        
        return [
            'data' => $processedData,
            'errors' => $errors
        ];
    }

}