<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Staff;

class ManageStaff extends Component
{
    use WithPagination;

    public $search = '';
    public $newName, $newSpecialty;
    public $editingId = null;
    public $editName, $editSpecialty;
    public $confirmingDelete = null;

    protected $rules = [
        'newName' => 'required|string|max:255',
        'newSpecialty' => 'required|string|max:255',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function addStaff()
    {
        $this->validate();

        Staff::create([
            'name' => $this->newName,
            'specialty' => $this->newSpecialty,
        ]);

        session()->flash('message', 'Staff member added successfully!');
        $this->resetNewStaff();
    }

    public function editStaff($id)
    {
        $staff = Staff::findOrFail($id);
        $this->editingId = $id;
        $this->editName = $staff->name;
        $this->editSpecialty = $staff->specialty;
    }

    public function saveEdit($id)
    {
        $staff = Staff::find($id);

        if ($staff) {
            $staff->update([
                'name' => $this->editName,
                'specialty' => $this->editSpecialty,
            ]);

            session()->flash('message', 'Staff updated successfully!');
        }

        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editName = $this->editSpecialty = null;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function deleteStaff($id)
    {
        Staff::destroy($id);
        session()->flash('message', 'Staff deleted successfully!');
        $this->confirmingDelete = null;
    }

    private function resetNewStaff()
    {
        $this->newName = $this->newSpecialty = null;
    }

    public function render()
    {
        $staff = Staff::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.manage-staff', compact('staff'));
    }
}
