<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;



class CreatePost extends Component
{
    use WithFileUploads;

    public $open= false; 
    public $title, $content, $image, $identificador;

    //Solo se ejecuta una vez, la primera vez que carga el componente. 
    public function mount(){
        $this->identificador = rand();
    }

    //Necesita una validación para ser guardado 
    protected $rules = [
        'title' => 'required|max:10',
        'content' => 'required | min:10',
        'image' => 'required|image|max:2048',
    ];

    //Validar el campo después de la actualización
    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }


    public function save(){
       

        //antes de nada valido
        $this -> validate();

        $image= $this-> image->store('storage');


        $userId = Auth::id();
       

        //Creo el Post
       Post::create([
            'title' => $this->title,
            'content' => $this->content,
            'image'=> $image,
            'user_id' => $userId,
        ]);

        //reseteo los campos
        $this->reset(['open', 'title', 'content', 'image']);

        //Para poder resetear la img le he añadido un identificador que irá cambiando 
        $this->identificador = rand();

        //Vuelve a renderizar y muestra la lista actualizada del post
        $this->emitTo('show-posts','render');
        Session::flash('success', 'El post se creó correctamente');


    }

  
    //Cargara la vista
    public function render()
    {
        return view('livewire.create-post');
    }

    

    public function updatingOpen(){
        if($this->open ===false){
                $this->reset(['content', 'title', 'image']);
                $this->identificador = rand();
                $this->emit(['resetCHEditor']);
        }
    
    }

   
}
