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
    public $editingId = null, $editTitle, $editText, $editLink, $editImage;
    public $confirmingDelete = null;
    public $editImagePreview;
    public $search = '';

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

        session()->flash('message', 'Advertisement added successfully!');
    }

    public function editAd($id)
    {
        $ad = Advertisement::findOrFail($id);
        $this->editingId = $id;
        $this->editTitle = $ad->title;
        $this->editText = $ad->text;
        $this->editLink = $ad->link;
        $this->editImage = null;
    }

    public function updatedEditImage()
    {
        if ($this->editImage) {
            $this->editImagePreview = $this->editImage->temporaryUrl();
        }
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

        session()->flash('message', 'Advertisement deleted successfully!');
    }

    public function saveEdit($id)
    {
        $ad = Advertisement::findOrFail($id);

        if ($this->editImage) {
            Storage::delete('public/' . $ad->image);
            $imagePath = $this->editImage->store('advertisements', 'public');
            $ad->image = $imagePath;
        }

        $ad->update([
            'title' => $this->editTitle,
            'text' => $this->editText,
            'link' => $this->editLink,
        ]);

        $this->ads = Advertisement::all()->toArray();
        $this->editingId = null;

        session()->flash('message', 'Advertisement updated successfully!');
    }

    public function render()
    {
        $this->ads = Advertisement::whereRaw('LOWER(title) LIKE ?', ['%' . strtolower($this->search) . '%'])->get()->toArray();

        return view('livewire.admin.advertisements');
    }

}
