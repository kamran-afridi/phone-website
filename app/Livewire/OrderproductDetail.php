<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OrderDetails;
use App\Models\Order;
use App\Models\ReturnProduct;

class OrderproductDetail extends Component
{
    public $details_id;
    public $productquantity = [];
    public $productprice = [];
    public $OrderId = [];
    public $order;
    public $totalreturns = 0;
    public $thissubtotal = 0;
    Public $thisdiscount = 0;
    public $paytoorder_id;
    public $payto;
    public $discount = 0;
    public $orderID;
    protected $listeners = ['addedTocart' => 'refreshorderlist'];

    public function mount(Order $order)
    {
        $this->orderID = $order->id;
        $this->discount = $order->discount ?? 0;
    }
    public function submitDiscount($uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();
        if($order->org_total == 0){
            $order->org_total = $order->total;
        }
        $order->total = $order->org_total - ($order->org_total * $this->discount / 100);
        $order->discount = $this->discount;
        $order->due = $order->total - $order->pay;
        $order->save();

        session()->flash('success', 'Discount updated!');
    }
    public function refreshorderlist()
    {
        $this->render();
    }
    public function submitData($productId)
    {
        $newOrderDetailsTotal = $this->productquantity[$productId] * $this->productprice[$productId];

        $Order = Order::where('id', $this->OrderId[$productId])->firstOrFail();
        $OrderDetails = OrderDetails::where('id', $productId)->update([
            'quantity' => $this->productquantity[$productId],
            'unitcost' => $this->productprice[$productId],
            'total' => $newOrderDetailsTotal,
        ]);
        if ($OrderDetails) {
            $AllOrderDetails = OrderDetails::where('order_id', $this->OrderId[$productId])->get();
            $newTotalCost = $AllOrderDetails->sum('total');
            // dd($newTotalCost);

            if($Order->org_total != null){
                    $lastPrice = $newTotalCost;
                    $lastSub_total = $lastPrice - ($lastPrice * $Order->discount / 100);
                    $lastTotal = $lastPrice - ($lastPrice * $Order->discount / 100);
                    $lastDue = $lastTotal - $Order->pay;

                    $Order->update([
                        'org_total' => $lastPrice,
                        'total' => $lastTotal,
                        'sub_total' =>  $lastSub_total,
                        'due' => $lastDue,
                    ]);
            }
            else{
                $Duebill = $newTotalCost - $Order->pay;
                $Order->update([
                    'total' => $newTotalCost,
                    'sub_total' => $newTotalCost,
                    'due' => $Duebill
                ]);
            }
        }

        $this->updatingOrder();
    }

    public function updatingOrder()
    {
        $this->order = Order::where('uuid', $this->order->uuid)->firstOrFail();
        $this->order->loadMissing(['customer', 'details']);

        foreach ($this->order->details as $detail) {
            $this->OrderId[$detail->id] = $this->order->id;
            $this->productquantity[$detail->id] = $detail->quantity;
            $this->productprice[$detail->id] = $detail->unitcost;
        }
        $payto = $this->order->payto;

        $returnProtucts = ReturnProduct::where('order_id', $this->order->id)->get();
        $this->totalreturns = $returnProtucts->sum('subtotal');
        $this->thissubtotal = $this->order->total + $this->totalreturns;
    }
    public function savepayto($uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();

        try {
            // Update the payment field in the order
            $order->payto = $this->payto;
            $order->save();

            // Flash success message
            session()->flash('success', 'Paid to '.$this->payto.' has been added to the order');
        } catch (\Exception $e) {
            // Flash error message in case of failure
            session()->flash('error', 'Faild to add paid to, try later! error: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $this->updatingOrder();
        return view('livewire.orderproduct-detail', ['order' => $this->order, 'totalreturns' => $this->totalreturns, 'thissubtotal' => $this->thissubtotal]);
    }
}
