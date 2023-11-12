<?php

namespace App\Services\Product;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\Product\ProductSubcategory;

class ProductSubcategoryService extends Controller
{
    public function getProductSubcategories()
    {
        $user = Auth::user();

        return ProductSubcategory::whereHas('languages', function ($query) use (
            $user
        ) {
            $query->where('languages.id', $user->language->id);
        })
            ->with([
                'languages' => function ($query) use ($user) {
                    $query->where('languages.id', $user->language->id);
                },
            ])
            ->get();
    }
}
