<div>
    @section('title', 'Jornadas')

    @php
        $jornadaActiva = $this->jornadaActiva;

        $inicioCronometro = $jornadaActiva
            ? \Carbon\Carbon::parse(
                $jornadaActiva->fecha . ' ' . $jornadaActiva->hora_entrada
            )->toIso8601String()
            : null;
    @endphp

    <div class="container-fluid mt-5">

        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <i class="fas fa-clock"></i> Control de jornada
            </div>

            <div class="card-body">
                @if ($mensaje)
                    <div class="alert alert-{{ $tipoMensaje }}">
                        {{ $mensaje }}
                    </div>
                @endif

                @if ($jornadaActiva)
                    <div class="text-center">
                        <h4>Jornada en curso</h4>
                        <p class="mb-1">
                            Trabajador:
                            <strong>{{ $jornadaActiva->trabajador->nombre }}</strong>
                        </p>
                        <p>
                            Código:
                            <strong>{{ $jornadaActiva->trabajador->codigo }}</strong>
                        </p>
                        <p>
                            Hora de entrada:
                            <strong>{{ $jornadaActiva->hora_entrada }}</strong>
                        </p>

                        <div
                            class="display-4 fw-bold my-3"
                            data-inicio="{{ $inicioCronometro }}"
                            x-data="{
                                inicio: Date.parse($el.dataset.inicio),
                                ahora: Date.now(),
                                init() {
                                    setInterval(() => this.ahora = Date.now(), 1000)
                                },
                                get tiempo() {
                                    const segundos = Math.max(
                                        0,
                                        Math.floor((this.ahora - this.inicio) / 1000)
                                    );

                                    return [
                                        Math.floor(segundos / 3600),
                                        Math.floor((segundos % 3600) / 60),
                                        segundos % 60
                                    ].map(valor => String(valor).padStart(2, '0')).join(':');
                                }
                            }"
                            x-text="tiempo">
                            00:00:00
                        </div>

                        <div class="text-muted mb-3">Tiempo transcurrido</div>

                        <button
                            type="button"
                            class="btn btn-danger"
                            wire:click="terminar"
                            wire:confirm="¿Deseas terminar esta jornada?"
                            wire:loading.attr="disabled">
                            <i class="fas fa-stop"></i> Terminar jornada
                        </button>
                    </div>
                @else
                    <form wire:submit="iniciar">
                        <div class="row align-items-end">
                            <div class="col-md-8 mb-3">
                                <label for="codigo" class="form-label">
                                    Código del trabajador
                                </label>

                                <input
                                    id="codigo"
                                    type="text"
                                    class="form-control @error('codigo') is-invalid @enderror"
                                    wire:model="codigo"
                                    maxlength="20"
                                    autocomplete="off">

                                @error('codigo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <button
                                    type="submit"
                                    class="btn btn-success w-100"
                                    wire:loading.attr="disabled">
                                    <i class="fas fa-play"></i> Iniciar jornada
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-dark text-white">
                Jornadas registradas
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-5 mb-2">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Buscar por trabajador o código..."
                            wire:model.live="search">
                    </div>

                    <div class="col-md-4 mb-2">
                        <input
                            type="date"
                            class="form-control"
                            wire:model.live="fecha">
                    </div>

                    <div class="col-md-3 mb-2">
                        <select class="form-select" wire:model.live="estado">
                            <option value="">Todos los estados</option>
                            <option value="abierto">Abierto</option>
                            <option value="finalizado">Finalizado</option>
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Trabajador</th>
                                <th>Fecha</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                                <th>Tiempo total</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->jornadas as $jornada)
                                <tr>
                                    <td>
                                        {{ $jornada->trabajador->nombre ?? 'Sin trabajador' }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $jornada->trabajador->codigo ?? '' }}
                                        </small>
                                    </td>
                                    <td>{{ $jornada->fecha }}</td>
                                    <td>{{ $jornada->hora_entrada ?? '—' }}</td>
                                    <td>{{ $jornada->hora_salida ?? '—' }}</td>
                                    <td>
                                        {{ $jornada->tiempo_total_segundos !== null
                                            ? gmdate('H:i:s', $jornada->tiempo_total_segundos)
                                            : '—' }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $jornada->estado === 'abierto' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ ucfirst($jornada->estado ?? '') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        No hay jornadas registradas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $this->jornadas->links() }}
            </div>
        </div>
    </div>
</div>