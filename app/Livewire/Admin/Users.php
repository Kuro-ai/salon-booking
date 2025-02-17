<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination; // Ensure pagination is handled by Livewire

    public $newName, $newEmail, $newRole = 'customer';
    public $editingId = null;
    public $editName, $editEmail, $editRole;
    public $confirmingDelete = null;
    public $search = '';

    protected $rules = [
        'newName' => 'required|string|min:3',
        'newEmail' => 'required|email|unique:users,email',
        'newRole' => 'required|in:admin,customer',
    ];

    public function mount()
    {
        // Initial data load
    }

    public function updatedSearch()
    {
        $this->resetPage(); // Reset pagination when search query changes
    }

    public function addUser()
    {
        $this->validate();

        User::create([
            'name' => $this->newName,
            'email' => $this->newEmail,
            'role' => $this->newRole,
            'password' => bcrypt('password'), // Default password
        ]);

        session()->flash('message', 'User added successfully!');
        $this->resetNewUser();
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->editingId = $id;
        $this->editName = $user->name;
        $this->editEmail = $user->email;
        $this->editRole = $user->role;
    }

    public function saveEdit($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->update([
                'name' => $this->editName,
                'email' => $this->editEmail,
                'role' => $this->editRole,
            ]);

            session()->flash('message', 'User updated successfully!');
        }

        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->editName = $this->editEmail = $this->editRole = null;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function deleteUser($id)
    {
        User::destroy($id);
        session()->flash('message', 'User deleted successfully!');
        $this->confirmingDelete = null;
    }

    private function resetNewUser()
    {
        $this->newName = $this->newEmail = null;
        $this->newRole = 'customer';
    }

    public function render()
    {
        $users = User::orderBy('id', 'desc')
            ->where('email', 'like', '%' . strtolower($this->search) . '%')
            ->paginate(10); 

        return view('livewire.admin.users', [
            'users' => $users, 
        ]);
    }
}
