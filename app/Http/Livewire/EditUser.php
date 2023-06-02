<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;


class EditUser extends Component
{
    use WithFileUploads;

    public $open = false;
    public $user;

    protected $rules = [
        'user.name' => 'required',
        'user.email' => 'required'
    ];

    public function mount(User $user){
        
        $this->user= $user;  
    }

     
    public function save(){
        $this -> validate();
        //Guarda los cambios realizados en el Post
        $this->user->save();
        //Resetea para cerrar modal
        $this->reset(['open']);
        //Vuelve a renderizar y muestra la lista actualizada del post
        //EmitTo te permite seleccionar que vas a renderizar exactamente 
        $this->emitTo('show-user','render');
        $this->emit('alert', 'El post se ha actualizado correctamente');
    
    }

    public function render()
    {
        return view('livewire.admin.edit-user');
    }
}
