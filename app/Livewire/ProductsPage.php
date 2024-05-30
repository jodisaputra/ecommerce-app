<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Product - E-commerce Website')]
class ProductsPage extends Component
{
    use withPagination;
    #[Url]
    public $selected_categories = [];
    #[Url]
    public $selected_brands = [];
    #[Url]
    public $featured;
    #[Url]
    public $on_sale;
    #[Url]
    public $price_range = 300000;
    #[Url]
    public $sort = 'latest';
    //add product to cart method
    public function addToCart($product_id) {
        $total_count = CartManagement::addItemToCart($product_id);
        //send to navbar
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
    }

    public function render()
    {
        $products = Product::query()->where('is_active', 1);
        if(!empty($this->selected_categories)){
            $products->whereIn('category_id', $this->selected_categories);
        }
        if(!empty($this->selected_brands)){
            $products->whereIn('brand_id', $this->selected_brands);
        }
        if($this->featured) {
            $products->where('is_featured', 1);
        }
        if($this->on_sale) {
            $products->where('on_sale', 1);
        }
        if($this->price_range) {
            $products->whereBetween('price', [0, $this->price_range]);
        }
        if($this->sort == 'latest') {
            $products->latest();
        }
        if($this->sort == 'price') {
            $products->orderBy('price');
        }
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
