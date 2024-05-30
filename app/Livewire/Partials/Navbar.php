<?php

namespace App\Livewire\Partials;

use App\Helpers\CartManagement;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public $total_count = 0;
    use livewireAlert;

    public function mount() {
        $this->total_count = count(CartManagement::getCartItemsFromCookie());
    }
    //this updateCartCount for dispatch update-cart-count
    #[On('update-cart-count')]
    public function updateCartCount($total_count) {
        $this->total_count = $total_count;
        $this->alert('success', 'Product added to cart successfully!', [
            'position' =>  'bottom-end',
            'timer' =>  3000,
            'toast' =>  true,
        ]);
    }
    public function render()
    {
        return view('livewire.partials.navbar');
    }
}
