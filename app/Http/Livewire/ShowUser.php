<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;


class ShowUser extends Component
{

    use WithFileUploads; 
    use WithPagination;

    
    public  $user;
    public $search="";
    public $sort = 'id';
    public $direction= 'desc';
    public $open_edit_admin= false;
    public $cant='10';
    public $readyToLoad=false;

    protected $queryString= ['cant' => ['except' => '10'],
     'sort' => ['except' => 'id'], 
     'direction' => ['except' => 'desc'], 
     'search' => ['except' => ""]];

    public function mount(){
        $this-> user = new User();
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    protected $rules = [
        'user.title' => 'required',
        'user.content' => 'required'
    ];
    protected $listeners = ['render', 'delete'];

    public function render()
    {
        
        if ($this->readyToLoad) {
            $query = User::where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sort, $this->direction);
    
            $users = $query->paginate($this->cant);
        } else {
            $users = User::paginate($this->cant);
        }
    
    
        return view('livewire.admin.show-user', compact('users'));
    }
    

    public function order($sort)
{
    if ($this->sort == $sort) {
        if ($this->direction == 'desc') {
            $this->direction = 'asc'; 
        } else {
            $this->direction = 'desc'; 
        }
    } else {
        $this->sort = $sort;
        $this->direction = 'asc';
    }
}


    public function edit(User $user){
$this->user = $user;
$this->open_edit_admin = true;
    }

    public function loadUsers(){
        $this->readyToLoad=true;
    }

    public function update(){
        $this -> validate();
               
        $this->user->save();

        $this->reset(['open_edit_admin']);
        $this->emitTo('show-users','render');
        $this->emit('alert', 'El user se ha actualizado correctamente');
    }

    public function delete(User $user){
        $user->delete();
    }
}
