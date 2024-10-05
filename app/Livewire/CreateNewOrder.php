<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Log;

class CreateNewOrder extends Component
{
    public $cartId = [],
        $cartItemquantity = [],
        $cartItemprice = [];
    public $hasReloaded = false;
    // public $products, $customers, $carts;
    protected $listeners = ['addedTocart' => 'refreshneworderlist'];

    public function EditQtyPrice($cartid)
    {
        // Check if requested quantity is greater than available stock
        $productId = Cart::get($cartid); // Fetch the product ID from the cart item
        $availableStock = Product::where('id', intval($cartid))->value('quantity');

        if ($this->cartItemquantity[$cartid] > $availableStock) {
            session()->flash('carterror', 'The requested quantity is not available in stock.');
            return;
        }

        try {
            // Update both the quantity and the price
            Cart::update($cartid, $this->cartItemquantity[$cartid], [
                'price' => $this->cartItemprice[$cartid],
            ]);

            session()->flash('cartsuccess', 'The requested quantity has been updated.');
        } catch (\Exception $e) {
            session()->flash('carterror', 'An error occurred while updating the cart.');
        }

        $this->render(); // Refresh the component
    }
    public function RemoveItem($cartid)
    {
        Cart::remove($cartid);
        session()->flash('cartsuccess', 'The item has been removed from the cart.');
    }

    public function refreshneworderlist()
    {
        $this->mount();

        // $this->render();
    }
    public function mount()
    {
        // dd('working');
    }

    public function render()
    {
        $products = Product::with(['category_id'])->get();
        $customers = Customer::all()->sortBy('name');

        // Retrieve cart content
        $carts = Cart::content();

        // Get the length/count of cart items
        $cartCount = $carts->count();

        Log::info('Total items in the cart: ', [$cartCount]);

        // Loop through the cart items to store relevant details
        foreach ($carts as $item) {
            $this->cartId[$item->rowId] = $item->rowId;
            $this->cartItemquantity[$item->rowId] = $item->qty;
            $this->cartItemprice[$item->rowId] = $item->price;
        }

        // Reload page only once if the cart count is 1
        if ($cartCount === 1 && $this->hasReloaded == 'false') {
            $this->hasReloaded = true; // Set flag to avoid multiple reloads
            dd($this->hasReloaded);
            // return redirect()->to('orders/create');
            // $this->redirect('orders/create');
            // return view('orders/create');
            // return redirect(request()->header('Referer'));
            // return redirect()->to(url()->current());
        }

        return view('livewire.create-new-order', [
            'products' => $products,
            'allcustomers' => $customers,
            'newcartitem' => $carts,
        ]);
    }
}
