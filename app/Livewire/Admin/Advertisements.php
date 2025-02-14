<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Advertisement;

class Advertisements extends Component
{
    use WithFileUploads;

    public $title, $text, $image, $link;
    public $ads;

    public function mount()
    {
        $this->ads = Advertisement::all();
    }

    public function addAd()
    {
        $this->validate([
            'image' => 'required|image|max:2048',
            'title' => 'nullable|string',
            'text' => 'nullable|string',
            'link' => 'nullable|url',
        ]);

        $imagePath = $this->image->store('advertisements', 'public');

        Advertisement::create([
            'image' => $imagePath,
            'title' => $this->title,
            'text' => $this->text,
            'link' => $this->link,
        ]);

        $this->reset(['title', 'text', 'image', 'link']);
        $this->ads = Advertisement::all();
    }

    public function deleteAd($id)
    {
        Advertisement::findOrFail($id)->delete();
        $this->ads = Advertisement::all();
    }

    public function render()
    {
        return view('livewire.admin.advertisements', [
            'ads' => $this->ads
        ]);
    }
}

