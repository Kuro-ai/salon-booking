<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Service;

class ManageServices extends Component
{
    use WithPagination;

    public $name, $price, $description, $serviceId;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
    ];

    public function createService()
    {
        $this->validate();
        Service::create([
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
        ]);
        $this->resetForm();
    }

    public function editService($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $id;
        $this->name = $service->name;
        $this->price = $service->price;
        $this->description = $service->description;
        $this->isEditing = true;
    }

    public function updateService()
    {
        $this->validate();
        Service::where('id', $this->serviceId)->update([
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
        ]);
        $this->resetForm();
    }

    public function deleteService($id)
    {
        Service::destroy($id);
    }

    private function resetForm()
    {
        $this->name = $this->price = $this->description = null;
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.admin.manage-services', [
            'services' => Service::paginate(10),
        ]);
    }
}

