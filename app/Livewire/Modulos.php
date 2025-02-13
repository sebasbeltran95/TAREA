<?php

namespace App\Livewire;

use App\Models\modulos as ModelsModulos;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;

class Modulos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $nombre_modulo, $profesor;
    public $idx, $nombre_modulox, $profesorx;
    public $search  = "";

    protected $listeners = ['delete'];

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function getModulosProperty()
    {
        if ($this->search == "") {
            return ModelsModulos::orderBy('id','DESC')->paginate(5);
        } else {
            return ModelsModulos::orWhere('nombre_modulo', 'LIKE', '%'.$this->search.'%')
                ->orWhere('profesor', 'LIKE', '%'.$this->search.'%')
                ->paginate(3);
        }
    }


    public function crear()
    {
        try {
            $this->validate([
                'nombre_modulo' => 'required|string|max:60',
                'profesor' => 'required|string|max:60',

            ],[
                'nombre_modulo.required' => 'El campo Nombre Modulo es obligatorio',
                'nombre_modulo.string' => 'El campo Nombre Modulo recibe solo cadena de texto',
                'nombre_modulo.max' => 'El campo Nombre Modulo debe contener maximo 60 caracteres',
                'profesor.required' => 'El campo Profesor es obligatorio',
                'profesor.string' => 'El campo Profesor recibe solo cadena de texto',
                'profesor.max' => 'El campo Profesor debe contener maximo 60 caracteres',
            ]);
    
            $user = new ModelsModulos();
            $user->nombre_modulo =  $this->nombre_modulo;
            $user->profesor =  $this->profesor;
            $user->save();

            $this->reset();
            $msj = ['!Registrado!', 'Se registro el Modulo', 'success'];
            $this->dispatch('ok', $msj);

        } catch (QueryException $e) {

            $msj = ['!ERROR!', 'se ha presentado un error: ', $e, 'danger'];
            $this->dispatch('ok'. $msj);

        }
    }

    public function datacliente($obj)
    {
        $this->idx = $obj['id'];
        $this->nombre_modulox =  $obj['nombre_modulo'];
        $this->profesorx = $obj['profesor'];
    }


    public function actua()
    {
        try {

            $this->validate([
                'nombre_modulox' => 'required|string|max:60',
                'profesorx' => 'required|string|max:60',

            ],[
                'nombre_modulox.required' => 'El campo Nombre Modulo es obligatorio',
                'nombre_modulox.string' => 'El campo Nombre Modulo recibe solo cadena de texto',
                'nombre_modulox.max' => 'El campo Nombre Modulo debe contener maximo 60 caracteres',
                'profesorx.required' => 'El campo Profesor es obligatorio',
                'profesorx.string' => 'El campo Profesor recibe solo cadena de texto',
                'profesorx.max' => 'El campo Profesor debe contener maximo 60 caracteres',
            ]);
    
            $data = ModelsModulos::find($this->idx);
            $data->nombre_modulo = $this->nombre_modulox;
            $data->profesor = $this->profesorx;
            $data->save();
            $msj = ['!Actualizado!', 'Se actualizo el Modulo', 'success'];
            $this->dispatch('ok', $msj);

        } catch (QueryException $e) {

            $msj = ['!ERROR!', 'se ha presentado un error: ', $e, 'danger'];
            $this->dispatch('ok', $msj);

        }
    }

    public function confirmDelete($postId)
    {
        // Esto simplemente emite un evento para mostrar la confirmación en el frontend
        $this->dispatch('showDeleteConfirmation', ['postId' => $postId]);
    }

    public function delete($postId)
    {
        dd();
        try {
            // Verifica si el post existe antes de intentar eliminarlo
            $post = ModelsModulos::find($postId);
    
            if (!$post) {
                // Si no existe el post, muestra un error
                $this->dispatchBrowserEvent('ok', ['¡ERROR!', 'No se encontró el registro.', 'danger']);
                return;
            }
    
            // Elimina el post
            $post->delete();
    
            // Muestra un mensaje de éxito
            $this->dispatchBrowserEvent('ok', ['¡Eliminado!', 'El registro ha sido eliminado.', 'success']);
        } catch (\Exception $e) {
            // Muestra un mensaje de error si ocurre una excepción
            $this->dispatchBrowserEvent('ok', ['¡ERROR!', 'Hubo un error: ' . $e->getMessage(), 'danger']);
        }
    }

    public function render()
    {
        return view('livewire.modulos')->extends('layouts.plantilla')->section('content');
    }
}
