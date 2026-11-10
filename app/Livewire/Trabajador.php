<?php

namespace App\Livewire;

use App\Models\Trabajador as ModelsTrabajador;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class Trabajador extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nombre, $codigo, $estado;
    public $idx, $nombrex, $codigox, $estadox;
    public $search = '';

    protected $listeners = ['render', 'delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getTrabajadoresProperty()
    {
        if($this->search == ""){
            return ModelsTrabajador::orderBy('id','DESC')->paginate(5);
        } else {
            return ModelsTrabajador::
            orWhere('nombre', 'LIKE', '%'.$this->search.'%')
            ->orWhere('codigo', 'LIKE', '%'.$this->search.'%')
            ->orWhere('estado', 'LIKE', '%'.$this->search.'%')
            ->paginate(3);
        } 
    }

        public function crear()
    {
        try { 

            $this->validate([
                'nombre'        => 'required|string|max:255',
                'codigo' => 'required|string|max:255',
                'estado'       => 'required|string|max:255',
            ],[
                'nombre.required'        => 'El campo Nombre es obligatorio',
                'nombre.string'          => 'El campo Nombre recibe solo cadena de texto',
                'nombre.max'             => 'El campo Nombre debe contener maximo 255 caracteres',
                'codigo.required' => 'El campo Codigo es obligatorio',
                'codigo.string'   => 'El campo Codigo recibe solo cadena de texto',
                'codigo.max'      => 'El campo Codigo debe contener maximo 255 caracteres',
                'estado.required'       => 'El campo Estado es obligatorio',
                'estado.string'        => 'El campo Estado recibe solo cadena de texto',
                'estado.max'            => 'El campo Estado debe contener maximo 255 caracteres',
            ]);

            $producto = new ModelsTrabajador();
            $producto->nombre        = $this->nombre;
            $producto->codigo = $this->codigo;
            $producto->estado       = $this->estado;
            $producto->save();

            Log::channel('logs_trabajador')->info('Trabajador creado', [
                'nombre' => $this->nombre,
                'user'   => Auth::id(),
            ]);

            $this->reset();
            $msj = ['!Registrado!', 'Se registro el trabajador', 'success'];
            $this->dispatch('ok', msj: $msj);

        } catch (QueryException $e) {

            Log::channel('logs_trabajador')->error('Error al crear trabajador', [
                'error' => $e->getMessage(),
                'user'  => Auth::id(),
            ]);

            $msj = ['!ERROR!', 'Se ha presentado un error al crear el trabajador', 'error'];
            $this->dispatch('ok', msj: $msj);

        }
    }

    public function cargacategory($obj)
    {
        $this->idx =  $obj['id'];
        $this->nombrex =  $obj['nombre'];
        $this->codigox =  $obj['codigo'];
        $this->estadox =  $obj['estado'];
    }

    public function actua()
    {
        try { 

            $this->validate([
                'nombrex'        => 'required|string|max:255',
                'codigox' => 'required|string|max:255',
                'estadox'       => 'required|in:1,0',
            ],[
                'nombrex.required'        => 'El campo Nombre es obligatorio',
                'codigox.required' => 'El campo Codigo es obligatorio',
                'estadox.required'       => 'El campo Estado es obligatorio',
                'nombrex.string'          => 'El campo Nombre recibe solo cadena de texto',
                'nombrex.max'             => 'El campo Nombre debe contener maximo 255 caracteres',
                'codigox.string'   => 'El campo Codigo recibe solo cadena de texto',
                'codigox.max'      => 'El campo Codigo debe contener maximo 255 caracteres',
                'estadox.in'            => 'El campo Estado debe ser Activo o Inactivo',
            ]);

            $data = ModelsTrabajador::find($this->idx);
            $data->nombre = $this->nombrex;
            $data->codigo = $this->codigox;
            $data->estado = $this->estadox;

            $data->save();

            Log::channel('logs_trabajador')->info('Trabajador actualizado', [
                'nombre' => $this->nombrex,
                'user'   => Auth::id(),
            ]);

            $msj = ['!Actualizado!', 'Se actualizo el trabajador', 'success'];
            $this->dispatch('ok', msj: $msj);

          } catch (QueryException $e) {

            Log::channel('logs_trabajador')->error('Error al actualizar trabajador', [
                'error' => $e->getMessage(),
                'user'  => Auth::id(),
            ]);

            $msj = ['!ERROR!', 'Se ha presentado un error al actualizar el trabajador', 'error'];
            $this->dispatch('ok', msj: $msj);

        }
    }

    public function render()
    {
        return view('livewire.trabajador')->extends('layouts.plantilla_back')->section('contenido');
    }
}
