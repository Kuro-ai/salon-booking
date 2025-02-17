<?php 

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\User;

class Orders extends Component
{
    use WithPagination;

    public $search = ''; // Search input
    public $newUserId, $newTotalPrice, $newStatus = 'pending';
    public $editingId = null;
    public $editUserId, $editTotalPrice, $editStatus;
    public $confirmingDelete = null;

    protected $rules = [
        'newUserId' => 'required|exists:users,id',
        'newTotalPrice' => 'required|numeric|min:0',
        'newStatus' => 'required|string|in:pending,shipped,delivered,canceled',
    ];

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination on new search
    }

    public function addOrder()
    {
        $this->validate();

        Order::create([
            'user_id' => $this->newUserId,
            'total_price' => $this->newTotalPrice,
            'status' => $this->newStatus,
        ]);

        session()->flash('message', 'Order added successfully!');
        $this->resetNewOrder();
    }

    public function editOrder($id)
    {
        $order = Order::with('orderItems.product')->findOrFail($id);
        $this->editingId = $id;
        $this->editUserId = $order->user_id;
        $this->editTotalPrice = $order->total_price;
        $this->editStatus = $order->status;
    }

    public function saveEdit($id)
    {
        $order = Order::find($id);

        if ($order) {
            $order->update([
                'user_id' => $this->editUserId,
                'total_price' => $this->editTotalPrice,
                'status' => $this->editStatus,
            ]);

            session()->flash('message', 'Order updated successfully!');
        }

        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editUserId = $this->editTotalPrice = $this->editStatus = null;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function deleteOrder($id)
    {
        Order::destroy($id);
        session()->flash('message', 'Order deleted successfully!');
        $this->confirmingDelete = null;
    }

    private function resetNewOrder()
    {
        $this->newUserId = $this->newTotalPrice = null;
        $this->newStatus = 'pending';
    }

    public function render()
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->whereHas('user', function ($query) {
                $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.orders', [
            'orders' => $orders,
            'users' => User::all(),
        ]);
    }
}
