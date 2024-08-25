<?php

namespace App\Livewire\Tables;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class OrderTable extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $perPage = 15;
    public $changeEvents;
    public $search = '';

    public $sortField = 'id';

    public $sortAsc = false;
    public $userid;

    public function mount()
    {
        $this->userid = session('UserId', ''); 
    }

    public function updatedUserid($value)
    {
        Session::put('UserId', $value);
        $this->userid = $value;
    }
    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }
    public function updatingSearch()
    {
        $this->resetPage(); // Reset to the first page when search query changes
    }

    public function render()
    {

        if (auth()->user()->role === 'admin' || auth()->user()->role === 'supplier') {
            if ($this->userid) {
                $orders = Order::with(['customer', 'details', 'user'])
                    ->where("user_id", $this->userid)
                    ->search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);
            } else {

                $orders = Order::with(['customer', 'details', 'user'])
                    ->search($this->search)
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate($this->perPage);
            }
        } else {
            // dd("A");
            $orders = Order::where("user_id", auth()->id())
                ->with(['customer', 'details', 'user'])
                ->search($this->search)
                ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                ->paginate($this->perPage);
        }

        $users = User::get(['id', 'name']);
        return view('livewire.tables.order-table', [
            'orders' => $orders,
            'users' => $users,
        ]);
    }
}
