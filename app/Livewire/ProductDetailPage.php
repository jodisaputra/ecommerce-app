<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Detail - E-Commerce Website')]
class ProductDetailPage extends Component
{
    public $slug;
    public $quantity = 1;
    use livewireAlert;

    public function mount($slug): void
    {
        $this->slug = $slug;
    }

    public function increaseQty(): void
    {
        $this->quantity++;
    }

    public function decreaseQty(): void
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart($product_id) {
        $total_count = CartManagement::addItemToCartWithQty($product_id, $this->quantity);
        //send to navbar
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
        $this->alert('success', 'Product added to cart successfully!', [
            'position' =>  'bottom-end',
            'timer' =>  3000,
            'toast' =>  true,
        ]);
    }

    public function render()
    {
        $product = Product::where('slug', $this->slug)->firstOrFail();
        return view('livewire.product-detail-page', [
            'product' => $product
        ]);
    }
}
