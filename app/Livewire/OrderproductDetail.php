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

    protected $listeners = ['addedTocart' => 'refreshorderlist'];

    public function refreshorderlist()
    {
        $this->render();
    }
    public function submitData($productId)
    {
        // dd($this->OrderId[$productId]);
        $newOrderDetailsTotal = $this->productquantity[$productId] * $this->productprice[$productId];
        // dd($this->productquantity[$productId]);
		$Order = Order::where('id', $this->OrderId[$productId])->firstOrFail();
        $OrderDetails = OrderDetails::where('id', $productId)->update([
            'quantity' => $this->productquantity[$productId],
            'unitcost' => $this->productprice[$productId],
            'total' => $newOrderDetailsTotal,
        ]);
        if ($OrderDetails) {
			$AllOrderDetails = OrderDetails::where('order_id', $this->OrderId[$productId])->get();
			$newTotalCost = $AllOrderDetails->sum('total');
			$Duebill = $newTotalCost - $Order->pay;
			$Order->update(['total' => $newTotalCost, 'sub_total' => $newTotalCost, 'due' => $Duebill]);
		}
// dd( secon$this->OrderId[$productId]);
        $this->abc();
    }

    public function abc()
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
        $this->abc();
        return view('livewire.orderproduct-detail', ['order' => $this->order]);
    }
}
