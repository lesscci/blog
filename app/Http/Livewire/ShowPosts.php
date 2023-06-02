<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ShowPosts extends Component
{

    use WithFileUploads; 
    use WithPagination;
    
    public  $post, $image, $identificador;
    public $search="";
    public $sort = 'id';
    public $direction= 'desc';
    public $open_edit= false;
    public $cant='10';
    public $readyToLoad=false;

    protected $queryString= ['cant' => ['except' => '10'],
     'sort' => ['except' => 'id'], 
     'direction' => ['except' => 'desc'], 
     'search' => ['except' => ""]];

    public function mount($type){
        $this->identificador = rand();
        $this-> post = new Post();
        $this->type = $type;
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required'
    ];
    protected $listeners = ['render', 'delete'];



    public function render(Request $request)
    {
        $posts = Post::where('title', 'like', '%' . $this->search . '%');

        if ($this->type!='general'){
            $query = $posts->where(function($q){
                $q->where('user_id', Auth::user()->id);
             });
        }
        
        $posts = $posts->orderBy($this->sort, $this->direction)->paginate($this->cant);
        
        return view('livewire.show-posts', compact('posts'));
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


    public function edit(Post $post){
$this->post = $post;
$this->open_edit = true;
    }

    public function loadPosts(){
        $this->readyToLoad=true;
    }

    public function update(){
        $this -> validate();
        
        if($this->image){
           Storage::delete([$this->post->image]);
        $this->post->image = $this->image->store('posts'); 
        }
        
        $this->post->save();

        $this->reset(['open_edit']);
        $this->emitTo('show-posts','render');
        $this->emit('alert', 'El post se ha actualizado correctamente');


    }

    public function delete(Post $post){
        $post->delete();


    }
}
