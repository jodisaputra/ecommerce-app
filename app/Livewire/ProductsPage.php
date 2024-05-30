<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Product - E-commerce Website')]
class ProductsPage extends Component
{
    use withPagination;

    public function render()
    {
        $products = Product::query()->where('is_active', 1);
        $brands = Brand::where('is_active', 1)->get();
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.products-page',
            [
                'products' => $products->paginate(6),
                'brands' => $brands,
                'categories' => $categories
            ]);
    }
}
