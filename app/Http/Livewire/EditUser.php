<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;


class EditPost extends Component
{
    use WithFileUploads;

    public $open = false;
    public $post, $image, $identificador;

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required'
    ];

    public function mount(Post $post){
        $this->post= $post;
        $this->identificador = rand();

    }

    public function save(){

        $this -> validate();
        //Guarda los cambios realizados en el Post
        $this->post->save();
        //Resetea para cerrar modal
        $this->reset(['open']);
        //Vuelve a renderizar y muestra la lista actualizada del post
        //EmitTo te permite seleccionar que vas a renderizar exactamente 
        $this->emitTo('show-posts','render');
        $this->emit('alert', 'El post se ha actualizado correctamente');
    }

    public function render()
    {
        return view('livewire.edit-post');
    }
}
