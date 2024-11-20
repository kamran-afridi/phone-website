<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Order;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Userledger extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 15;
    public $search = '';
    public $userid = '';
    public $customerid = '';
    public $datefrom = null;
    public $dateto = null;

    public $sortField = 'id';
    public $sortAsc = false;

    public function mount()
    {
        $this->userid = session('UserId', '');
        $this->customerid = '';
    }

    public function updatedUserid($value)
    {
        $this->userid = $value;
    }

    public function updatedCustomerid($value)
    {
        $this->customerid = $value;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $ordersQuery = Order::with(['customer', 'details', 'user']);

        // Apply filters for admin or supplier roles
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'supplier') {
            // Filter by user ID if provided
            if ($this->userid) {
                $ordersQuery->where('user_id', $this->userid);
            }

            // Filter by customer ID if provided
            // if ($this->customerid) {
            //     $ordersQuery->where('customer_id', $this->customerid);
            // }

            // Apply date range filter if both dates are selected
            if ($this->datefrom && $this->dateto) {
                $ordersQuery->whereBetween(DB::raw('DATE(created_at)'), [$this->datefrom, $this->dateto]);
            }
        } else {
            // For regular users, filter only by their user ID
            $ordersQuery->where('user_id', auth()->id());
        }

        // Apply search, sorting, and pagination
        $orders = $ordersQuery
            ->search($this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        $users = User::get(['id', 'name']);
        $customers = Customer::get(['id', 'name']);

        return view('livewire.userledger', [
            'orders' => $orders,
            'users' => $users,
            'customers' => $customers,
        ]);
    }
}

