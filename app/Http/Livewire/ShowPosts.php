<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

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

    public function mount(){
        $this->identificador = rand();
        $this-> post = new Post();
    }

    public function updatingSearch(){
        $this->resetPage();
    }

    protected $rules = [
        'post.title' => 'required',
        'post.content' => 'required'
    ];
    protected $listeners = ['render', 'delete'];

    public function render()
    {

        if($this->readyToLoad){
            
                $posts = Post::where(function ($query) {
                    $user = auth()->user();
        
                    if ($user->hasRole('admin')) {
                        // Si el usuario tiene el rol "admin", se muestran todos los posts
                        return $query;
                    } else {
                        // Si el usuario tiene el rol "blogger", se muestran solo los propios posts
                        return $query->where('user_id', $user->id);
                    }
                    })
                

       ->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->cant);
                   
        }else{
            $posts = [];
        }

        return view('livewire.show-posts', compact('posts'));
    }

    public function order($sort){
        if($this->sort==$sort){
            if($this->direction =='desc'){
                $this->direction =='asc';
            }else{
                $this->direction =='desc';
            }
        }else  {
            $this->sort=$sort;
            $this->direction =='asc';
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
