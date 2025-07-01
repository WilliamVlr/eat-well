<?php

namespace App\Imports;

use App\Models\Package;
use Maatwebsite\Excel\Concerns\ToModel;

class PackagesImport implements ToModel
{
    public function model(array $row)
    {
        return new Package([
            'name' => $row[0],
            'categoryId' => $this->mapCategory($row[1]),
            'breakfastPrice' => $row[2],
            'lunchPrice' => $row[3],
            'dinnerPrice' => $row[4],
            'averageCalories' => $row[5],
            // tambahkan sesuai struktur kolom Excel
        ]);
    }

    private function mapCategory($categoryName)
    {
        return match(strtolower($categoryName)) {
            'vegetarian' => 1,
            'gluten-free' => 2,
            'halal' => 3,
            'low carb' => 4,
            'low calorie' => 5,
            'organic' => 6,
            default => null
        };
    }
}
