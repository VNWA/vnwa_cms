<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ProductsImport implements ToCollection, WithHeadingRow
{
    /**
     * Nhận tất cả dữ liệu từ file Excel
     *
     * @param Collection $collection
     * @return void
     */
    public function collection(Collection $collection)
    {
        // Trả về dữ liệu đã đọc
        return $collection;
    }
}
