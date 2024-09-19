<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OrderDetails;
use App\Models\Order;

class OrderproductDetail extends Component
{
    public $details_id;
    public $productquantity = [];
    public $productprice = [];
    public $OrderId = [];
    public $order;

    public function submitData($productId)
    {
        // dd($this->OrderId[$productId]);
        $newOrderDetailsTotal = $this->productquantity[$productId] * $this->productprice[$productId];
        // dd($this->productquantity[$productId]);
        OrderDetails::where('id', $productId)->update([
            'quantity' => $this->productquantity[$productId],
            'unitcost' => $this->productprice[$productId],
            'total' => $newOrderDetailsTotal,
        ]);

        $this->mount();
    }

    public function mount()
    {
        $this->order = Order::where('uuid', $this->order->uuid)->firstOrFail();
        $this->order->loadMissing(['customer', 'details']);

        foreach ($this->order->details as $detail) {
            $this->OrderId[$detail->id] = $this->order->id;
            $this->productquantity[$detail->id] = $detail->quantity;
            $this->productprice[$detail->id] = $detail->unitcost;
        }
    }

    public function render()
    {
        return view('livewire.orderproduct-detail', ['order' => $this->order]);
    }
}
