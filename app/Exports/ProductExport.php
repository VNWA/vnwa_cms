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
        $product = Product::with('categories:id')->latest()->first(); // Lấy sản phẩm đầu tiên

        if ($product) {
            // Tạo collection từ object sản phẩm để tương thích với Excel export
            return collect([
                [
                    'brand_id'    => $product->brand_id,
                    'categories'  => $product->categories->pluck('id')->implode(','), // Nối các category_id bằng dấu phẩy
                    'name'        => $product->name,
                    'images'      => collect($product->images)->implode(',  '), // Nối các URL image bằng dấu phẩy
                    'sku'         => $product->sku,
                    'stock'       => $product->stock,
                    'origin'      => $product->origin,
                    'description' => $product->description,
                    'tech_info'   => $product->tech_info,
                    'catalogs'    => collect($product->catalogs)->implode(',  '),
                ]
            ]);
        }

        // Trả về collection rỗng nếu không có sản phẩm
        return collect([]);
    }

    /**
     * Định nghĩa tiêu đề cho các cột trong file Excel.
     * @return array
     */
    public function headings(): array
    {
        return [
            'Brand ID',
            'Categories ID',
            'Name',
            'Images',
            'SKU',
            'Stock',
            'Origin',
            'Description',
            'Tech Info',
            'Catalogs',
            // Thêm cột Categories ID
        ];
    }
}
