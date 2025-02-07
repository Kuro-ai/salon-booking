<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class Users extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::all();
    }

    public function updateRole($userId, $newRole)
    {
        $user = User::findOrFail($userId);
        $user->role = $newRole;
        $user->save();
        $this->users = User::all(); // Refresh users
    }

    public function deleteUser($userId)
    {
        User::findOrFail($userId)->delete();
        $this->users = User::all();
    }

    public function render()
    {
        return view('livewire.admin.users');
    }
}

