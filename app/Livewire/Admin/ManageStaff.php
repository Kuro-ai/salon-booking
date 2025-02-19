<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Staff;

class ManageStaff extends Component
{
    use WithPagination;

    public $search = '';
    public $newName, $newSpecialty, $newEmail, $newPhoneNumber, $newAddress;
    public $editingId = null;
    public $editName, $editSpecialty, $editEmail, $editPhoneNumber, $editAddress;
    public $confirmingDelete = null;

    protected $rules = [
        'newName' => 'required|string|max:255',
        'newSpecialty' => 'nullable|string|max:255',
        'newEmail' => 'required|email|max:255',
        'newPhoneNumber' => 'required|string|max:20',
        'newAddress' => 'required|string|max:255',
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
            'email' => $this->newEmail,
            'phone_number' => $this->newPhoneNumber,
            'address' => $this->newAddress,
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
        $this->editEmail = $staff->email;
        $this->editPhoneNumber = $staff->phone_number;
        $this->editAddress = $staff->address;
    }

    public function saveEdit($id)
    {
        $staff = Staff::find($id);

        if ($staff) {
            $staff->update([
                'name' => $this->editName,
                'specialty' => $this->editSpecialty,
                'email' => $this->editEmail,
                'phone_number' => $this->editPhoneNumber,
                'address' => $this->editAddress,
            ]);

            session()->flash('message', 'Staff updated successfully!');
        }

        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editName = $this->editSpecialty = $this->editEmail = $this->editPhoneNumber = $this->editAddress = null;
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
        if (Staff::where('id', $id)->exists()) {
            Staff::destroy($id);
            session()->flash('message', 'Staff deleted successfully!');
        } else {
            session()->flash('message', 'Staff member not found!');
        }

        $this->confirmingDelete = null;
        $this->resetPage(); // Ensures pagination resets after deletion
    }


    private function resetNewStaff()
    {
        $this->newName = $this->newSpecialty = $this->newEmail = $this->newPhoneNumber = $this->newAddress = null;
    }

    public function render()
    {
        $staff = Staff::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.admin.manage-staff', compact('staff'));
    }
}
