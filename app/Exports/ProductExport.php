<?php
namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    /**
     * Xuất ra một sản phẩm mẫu từ database kèm theo các category ID.
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        // Tạo collection từ object sản phẩm để tương thích với Excel export
        return collect([
            [
                'brand_id' => 62,
                'categories' => "12,13,14",
                'name' => "Product 1",
                'images' => "https:://example.com/image1.webp, https:://example.com/image.webp", // Nối các URL image bằng dấu phẩy
                'sku' => "#PRODUCT1",
                'stock' => "10000",
                'origin' => "USA",
                'description' => "<p>Hãy sử dụng phần convert trong product import này để tạo descripton</p>",
                'tech_info' => "<p>Hãy sử dụng phần convert trong product import này để tạo tech_info</p>",
                'catalogs' => "",
            ]
        ]);

    }

    /**
     * Định nghĩa tiêu đề cho các cột trong file Excel.
     * @return array
     */
    public function headings(): array
    {
        return [
            'Brand ID *',
            'Categories ID',
            'Name *',
            'Images *',
            'SKU *',
            'Stock *',
            'Origin *',
            'Description *',
            'Tech Info *',
            'Catalogs',
            // Thêm cột Categories ID
        ];
    }
}
