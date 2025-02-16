<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Storage;

class Advertisements extends Component
{
    use WithFileUploads;

    public $ads = [];
    public $newImage, $newTitle, $newText, $newLink;
    public $editingId = null, $editTitle, $editText, $editLink;
    public $confirmingDelete = null;

    public function mount()
    {
        $this->ads = Advertisement::all()->toArray();
    }

    public function addAd()
    {
        $this->validate([
            'newImage' => 'required|image|max:2048',
            'newTitle' => 'nullable|string',
            'newText' => 'nullable|string',
            'newLink' => 'nullable|url',
        ]);

        $imagePath = $this->newImage->store('advertisements', 'public');

        $ad = Advertisement::create([
            'image' => $imagePath,
            'title' => $this->newTitle,
            'text' => $this->newText,
            'link' => $this->newLink,
        ]);

        $this->ads[] = $ad->toArray();
        $this->reset(['newImage', 'newTitle', 'newText', 'newLink']);
    }

    public function editAd($id, $title, $text, $link)
    {
        $this->editingId = $id;
        $this->editTitle = $title;
        $this->editText = $text;
        $this->editLink = $link;
    }

    public function saveEdit($id)
    {
        $ad = Advertisement::findOrFail($id);
        $ad->update([
            'title' => $this->editTitle,
            'text' => $this->editText,
            'link' => $this->editLink,
        ]);

        $this->ads = Advertisement::all()->toArray();
        $this->editingId = null;
    }

    public function cancelEdit()
    {
        $this->editingId = null;
    }

    public function confirmDelete($id)
    {
        $this->confirmingDelete = $id;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function deleteAd($id)
    {
        $ad = Advertisement::findOrFail($id);
        Storage::delete('public/' . $ad->image);
        $ad->delete();

        $this->ads = Advertisement::all()->toArray();
        $this->confirmingDelete = null;
    }

    public function render()
    {
        return view('livewire.admin.advertisements');
    }
}