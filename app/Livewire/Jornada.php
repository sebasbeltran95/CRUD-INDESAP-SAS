<?php

namespace App\Livewire;

use App\Models\Jornada as ModelsJornada;
use App\Models\Trabajador;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Jornada extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $fecha = '';
    public $estado = '';
    public $codigo = '';
    public $mensaje = '';
    public $tipoMensaje = 'info';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFecha(): void
    {
        $this->resetPage();
    }

    public function updatingEstado(): void
    {
        $this->resetPage();
    }

    public function getJornadaActivaProperty(): ?ModelsJornada
    {
        if (trim($this->codigo) === '') {
            return null;
        }

        $trabajador = Trabajador::where('codigo', trim($this->codigo))->first();

        if (!$trabajador) {
            return null;
        }

        return ModelsJornada::with('trabajador')
            ->where('trabajador_id', $trabajador->id)
            ->where('estado', 'abierto')
            ->latest('id')
            ->first();
    }

    public function getJornadasProperty()
    {
        return ModelsJornada::with('trabajador')
            ->when($this->search, function ($query) {
                $query->whereHas('trabajador', function ($trabajadorQuery) {
                    $trabajadorQuery
                        ->where('nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('codigo', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->fecha, fn ($query) =>
                $query->whereDate('fecha', $this->fecha)
            )
            ->when($this->estado, fn ($query) =>
                $query->where('estado', $this->estado)
            )
            ->orderByDesc('fecha')
            ->orderByDesc('hora_entrada')
            ->paginate(10);
    }

    public function iniciar(): void
    {
        $this->validate([
            'codigo' => ['required', 'string', 'max:20'],
        ], [
            'codigo.required' => 'Ingresa el código del trabajador.',
            'codigo.max' => 'El código no debe superar los 20 caracteres.',
        ]);

        $this->mensaje = '';
        $codigo = trim($this->codigo);
        $trabajador = Trabajador::where('codigo', $codigo)->first();

        if (!$trabajador) {
            $this->mostrarMensaje('No encontramos un trabajador con ese código.', 'danger');
            return;
        }

        $jornadaAbierta = ModelsJornada::where('trabajador_id', $trabajador->id)
            ->where('estado', 'abierto')
            ->exists();

        if ($jornadaAbierta) {
            $this->mostrarMensaje('Este trabajador ya tiene una jornada iniciada.', 'warning');
            return;
        }

        try {
            $ahora = now();

            $jornada = new ModelsJornada();
            $jornada->trabajador_id = $trabajador->id;
            $jornada->fecha = $ahora->toDateString();
            $jornada->hora_entrada = $ahora->format('H:i:s');
            $jornada->estado = 'abierto';
            $jornada->save();

            $this->codigo = $codigo;
            $this->mostrarMensaje('Jornada iniciada correctamente.', 'success');
            $this->resetPage();
        } catch (QueryException $e) {
            Log::error('No se pudo iniciar la jornada.', [
                'error' => $e->getMessage(),
                'codigo' => $codigo,
            ]);

            $this->mostrarMensaje('Ocurrió un error al iniciar la jornada.', 'danger');
        }
    }

    public function terminar(): void
    {
        $trabajador = Trabajador::where('codigo', trim($this->codigo))->first();

        if (!$trabajador) {
            $this->mostrarMensaje('No encontramos un trabajador con ese código.', 'danger');
            return;
        }

        $jornada = ModelsJornada::where('trabajador_id', $trabajador->id)
            ->where('estado', 'abierto')
            ->latest('id')
            ->first();

        if (!$jornada) {
            $this->mostrarMensaje('No hay una jornada abierta para terminar.', 'warning');
            return;
        }

        try {
            $salida = now();
            $entrada = \Carbon\Carbon::parse(
                $jornada->fecha . ' ' . $jornada->hora_entrada
            );

            $jornada->hora_salida = $salida->format('H:i:s');
            $jornada->tiempo_total_segundos = max(
                0,
                (int) $entrada->diffInSeconds($salida)
            );
            $jornada->estado = 'finalizado';
            $jornada->save();

            $this->mostrarMensaje('Jornada terminada correctamente.', 'success');
            $this->codigo = '';
            $this->resetPage();
        } catch (QueryException $e) {
            Log::error('No se pudo terminar la jornada.', [
                'error' => $e->getMessage(),
                'trabajador_id' => $trabajador->id,
            ]);

            $this->mostrarMensaje('Ocurrió un error al terminar la jornada.', 'danger');
        }
    }

    private function mostrarMensaje(string $mensaje, string $tipo): void
    {
        $this->mensaje = $mensaje;
        $this->tipoMensaje = $tipo;
    }

    public function render()
    {
        return view('livewire.jornada')
            ->extends('layouts.plantilla_back')
            ->section('contenido');
    }
}