<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;



class CreatePost extends Component
{

    use WithFileUploads;

    public $open= false; 

    public $title, $content, $image, $identificador;

    public function mount(){
        $this->identificador = rand();
    }

    protected $rules = [
        'title' => 'required|max:10',
        'content' => 'required | min:10',
        'image' => 'required|image|max:2048',
    ];

  public function updated($propertyName){
        $this->validateOnly($propertyName);
    }


    public function save(){

        $this -> validate();
        $image= $this-> image->store('storage');

       Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image'=> $image
        ]);

        $this->reset(['open', 'title', 'content', 'image']);

        $this->identificador = rand();
        $this->emitTo('show-posts','render');
        $this->emit('alert', 'El post se creó correctamente');
    }

  



    public function render()
    {
        return view('livewire.create-post');
    }
}
