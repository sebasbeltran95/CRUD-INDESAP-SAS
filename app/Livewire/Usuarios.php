<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class Usuarios extends Component
{   
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nombre, $email, $password, $rol;
    public $idx,  $nombrex, $emailx, $passwordx, $rolx;
    public $search  = "";

    protected $listeners = ['render', 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

     public function getUsuariosProperty()
    {
        if($this->search == ""){
            return User::orderBy('id','DESC')->paginate(5);
        } else {
            return User::
            orWhere('name', 'LIKE', '%'.$this->search.'%')
            ->orWhere('email', 'LIKE', '%'.$this->search.'%')
            ->paginate(3);
        }
    }

     public function crear()
    {
        try {  

            $this->validate([
                'nombre' => 'required|string|max:100',
                'email' => 'required|string|email',
                'password' => 'required|string|min:6',
                'rol' => 'required|string',
            ],[
                'nombre.required' => 'El campo Nombre es obligatorio',
                'nombre.string' => 'El campo Nombre recibe solo cadena de texto',
                'nombre.max' => 'El campo Nombre debe contener maximo 100 caracteres',
                'email.required' => 'El campo Email es obligatorio',
                'email.string' => 'El campo Email recibe solo cadena de texto',
                'email.email' => 'El campo Email le falta el @',
                'password.required' => 'El campo Password es obligatorio',
                'password.string' => 'El campo Password recibe solo cadena de texto',
                'rol.required' => 'El campo Rol es obligatorio',
                'rol.string' => 'El campo Rol recibe solo cadena de texto',
            ]);

            $user = new User();
            $user->name =  $this->nombre;
            $user->email =  $this->email;
            $user->password = Hash::make($this->password);
            $user->rol = $this->rol;
            $user->save();
             $this->reset();
            $msj = ['!Registrado!', 'Se registro el Usuario', 'success'];
            $this->dispatch('ok', msj: $msj);

          } catch (QueryException $e) {

            $msj = ['!ERROR!', 'se ha presentado un error: ', $e, 'danger'];
            $this->emit('ok', $msj);

        }
    }

    public function cargausuario($obj)
    {
        $this->idx =  $obj['id'];
        $this->nombrex =  $obj['name'];
        $this->emailx =  $obj['email'];
        $this->rolx = $obj['rol'];
    }

     public function actua()
    {
        try { 

            $data = User::find($this->idx);
            $data->name = $this->nombrex;
            $data->email = $this->emailx;
            $data->rol = $this->rolx;
    
            $data->save();
            $msj = ['!Actualizado!', 'Se actualizo el Usuario', 'success'];
            $this->dispatch('ok', msj: $msj);

          } catch (QueryException $e) {

            $msj = ['!ERROR!', 'se ha presentado un error: ', $e, 'danger'];
            $this->emit('ok', $msj);

        }
    }

    public function render()
    {
        return view('livewire.usuarios')->extends('layouts.plantilla_back')->section('contenido');
    }
}
