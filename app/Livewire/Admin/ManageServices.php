<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Service;
use Illuminate\Support\Facades\Session;

class ManageServices extends Component
{
    use WithPagination;

    public $search = '';
    public $newService = '';
    public $newPrice = '';
    public $newDescription = '';

    public $editingId = null;
    public $editName = '';
    public $editPrice = '';
    public $editDescription = '';

    public $confirmingDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function addService()
    {
        if (!empty(trim($this->newService)) && is_numeric($this->newPrice)) {
            Service::create([
                'name' => $this->newService,
                'price' => $this->newPrice,
                'description' => $this->newDescription,
            ]);

            session()->flash('message', 'Service added successfully!');
            $this->resetNewService();
        }
    }

    public function editService($id)
    {
        $service = Service::find($id);
        if ($service) {
            $this->editingId = $id;
            $this->editName = $service->name;
            $this->editPrice = $service->price;
            $this->editDescription = $service->description;
        }
    }

    public function saveEdit($id)
    {
        $service = Service::find($id);
        if ($service) {
            $service->update([
                'name' => $this->editName,
                'price' => $this->editPrice,
                'description' => $this->editDescription,
            ]);

            session()->flash('message', 'Service updated successfully!');
        }
        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editName = '';
        $this->editPrice = '';
        $this->editDescription = '';
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function deleteService($id)
    {
        Service::destroy($id);
        session()->flash('message', 'Service deleted successfully!');
        $this->confirmingDelete = null;
    }

    private function resetNewService()
    {
        $this->newService = '';
        $this->newPrice = '';
        $this->newDescription = '';
    }

    public function render()
    {
        $services = Service::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%'])
            ->orderBy('id', 'desc')
            ->paginate(5);

        return view('livewire.admin.manage-services', [
            'services' => $services
        ]);
    }
}
