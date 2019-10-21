<?php

namespace App\Imports;

use App\Model\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            'name'     => $row['name'],
            'code'  => $row['code'],
            'category_id'   => $row['category_id'],
            'details'   => $row['details'],
            'cost_price'    => $row['cost_price'],
            'sales_price'    => $row['sales_price'],
            'initial_stock' => $row['initial_stock'],
            'total_stock'   => $row['initial_stock'],
            'unit'  => $row['unit'],
            'user_id'   => $row['user_id'],
        ]);
    }
}
