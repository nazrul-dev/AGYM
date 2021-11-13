<?php

namespace App\Http\Livewire\Master;

use App\Http\Livewire\Template;
use App\Models\Category as ModelsCategory;


class Category extends Template
{
    public $update = false;
    public $name  = '',$ids;

    public function mount(){
        if (!in_array(auth()->user()->role,['master', 'operator'])) {
            return abort(403, 'Tidak Memiliki Akses');
        }
    }
    public function render()
    {
        $categories = ModelsCategory::latest()->get();
        return view('livewire.master.category', compact('categories'));
    }

    public function edit(ModelsCategory $category){
        $this->clear();
        $this->name = $category->name;
        $this->ids = $category->id;
        $this->update = true;
    }

    public function clear(){
        $this->reset('name', 'update', 'ids');
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
        ]);
        ModelsCategory::updateOrCreate(
            ['id' => $this->ids],
            [
                'name' => $this->name
            ]
        );
        $this->clear();
    }

    public function delete(ModelsCategory $category){
        $category->product()->delete();
        $category->delete();
    }
}
