<?php

namespace App\Exports;

use App\Pedido;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacturacionExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $anio;
    protected $mes;
    protected $cuenta;

    public function __construct(int $anio, int $mes, int $cuenta = 0)
    {
        $this->anio   = $anio;
        $this->mes    = $mes;
        $this->cuenta = $cuenta;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Pedido::whereYear('created_at', $this->anio)->whereMonth('created_at', $this->mes);
		
		if ($this->cuenta == 0) {
			$query->whereHas('movimiento', function ($query) {
				$query->whereNull('cuenta_facturacion');
			});
		} else {
			$query->whereHas('movimiento', function ($query) {
				$query->where('cuenta_facturacion', $this->cuenta);
			});
		}

        return $query->orderBy('created_at', 'DESC')->get();
    }

    /**
    * @param Pedido $pedido
    */
    public function map($pedido): array
    {
        return [
            $pedido->id,
            $pedido->created_at->format('d-m-Y'),
            $pedido->client->nombre,
            $pedido->client->cuit,
            $pedido->client->provincia,
            $pedido->movimiento->monto - $pedido->movimiento->costo_envio,
            $pedido->movimiento->costo_envio,
            $pedido->movimiento->monto
        ];
    }

    public function headings(): array
    {
        return [
            'Pedido',
            'Fecha',
            'Cliente',
            'DNI/CUIT',
            'Provincia',
            'Monto Pedido',
            'Monto Envío',
            'Monto Total',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]]
        ];
    }
}