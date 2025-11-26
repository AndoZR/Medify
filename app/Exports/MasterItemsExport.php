<?php

namespace App\Exports;
use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterItemsExport implements FromCollection, WithHeadings, WithMapping
{
    private $rowNumber = 0;

    public function collection()
    {
        return MasterItem::with('kategoriItems')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kategori',
            'Nama',
            'Harga Beli',
            'Laba (%)',
            'Harga Jual',
            'Supplier',
        ];
    }

    public function map($item): array
    {
        $this->rowNumber++;

        $kategori = $item->kategoriItems->pluck('nama')->implode(', ');

        return [
            $this->rowNumber,
            $kategori,
            $item->nama,
            $item->harga_beli,
            $item->laba,
            $item->harga_beli + ($item->harga_beli * $item->laba / 100),
            $item->supplier,
        ];
    }
}