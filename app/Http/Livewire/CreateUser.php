<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;


class CreateUser extends Component
{
    use WithFileUploads;

    public $open = false;
    public $name, $email, $password, $identificador;

    // Necesita una validación para ser guardado
    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => 'required|min:8',
    ];

    // Validar el campo después de la actualización
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function save()
    {
        // antes de nada valido
        $this->validate();

        // Creo el User
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Asigno el rol "blogger" al nuevo usuario
        $bloggerRole = Role::findByName('blogger');
        $user->assignRole($bloggerRole);

        // reseteo los campos
        $this->reset(['open', 'name', 'email', 'password']);

        // Vuelve a renderizar y muestra la lista actualizada de usuarios
        $this->emitTo('show-users', 'render');
        $this->emit('alert', 'El usuario se creó correctamente');
    }

    // Cargará la vista
    public function render()
    {
        return view('livewire.create-user');
    }

    public function updatingOpen()
    {
        if ($this->open === false) {
            $this->reset(['name', 'email', 'password']);
            $this->emit(['resetCHEditor']);
        }
    }
}
