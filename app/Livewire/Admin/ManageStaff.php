<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Staff;

class ManageStaff extends Component
{
    use WithPagination;

    public $name, $specialty, $staffId;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'specialty' => 'required|string|max:255',
    ];

    public function createStaff()
    {
        $this->validate();
        Staff::create(['name' => $this->name, 'specialty' => $this->specialty]);
        $this->resetForm();
    }

    public function editStaff($id)
    {
        $staff = Staff::findOrFail($id);
        $this->staffId = $id;
        $this->name = $staff->name;
        $this->specialty = $staff->specialty;
        $this->isEditing = true;
    }

    public function updateStaff()
    {
        $this->validate();
        Staff::where('id', $this->staffId)->update(['name' => $this->name, 'specialty' => $this->specialty]);
        $this->resetForm();
    }

    public function deleteStaff($id)
    {
        Staff::destroy($id);
    }

    private function resetForm()
    {
        $this->name = $this->specialty = null;
        $this->isEditing = false;
    }

    public function render()
    {
        return view('livewire.admin.manage-staff', [
            'staff' => Staff::paginate(10),
        ]);
    }
}
