<div>
    @section('title', 'Usuarios')
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <i class="fas fa-users"></i>
                Usuarios
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm">
                                <thead>
                                    <th colspan="10">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="input-group input-group-sm w-50">
                                                <input type="text" class="form-control"
                                                    placeholder="Buscar..."
                                                    wire:model.live="search">
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-info text-white btn-sm d-flex align-items-center gap-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalCrearUsuarios">
                                                    <i class="fas fa-plus"></i> Crear
                                                </button>
                                            </div>
                                        </div>
                                    </th>
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Correo</th>
                                        <th class="text-center">Rol</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($this->usuarios as $usu)
                                        <tr>
                                            <td class="text-center">{{ $usu->name }}</td>
                                            <td class="text-center">{{ $usu->email }}</td>
                                            <td class="text-center">{{ $usu->rol === 'Admon' ? 'Administrador' : 'Operario' }}</td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-sm btn-info text-white"
                                                        wire:click="cargacredenciales({{ $usu->id }})"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#Modalcontraseña">
                                                        <i class="fas fa-lock"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                        wire:click="cargausuario({{ $usu }})"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#Modaleditar">
                                                        <i class="fas fa-user-edit"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">No hay registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $this->usuarios->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
 
        {{-- Modal crear usuario --}}
        <div class="modal fade" id="modalCrearUsuarios" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h4 class="modal-title">Crear Usuario</h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label class="@error('nombre') text-danger @enderror">Nombre</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model="nombre">
                            <i class="text-danger">
                                @error('nombre_completo') {{ $message }} @enderror
                            </i>
                        </div>
                        <div class="form-group mb-2">
                            <label class="@error('email') text-danger @enderror">Correo</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email">
                            <i class="text-danger">
                                @error('email') {{ $message }} @enderror
                            </i>
                        </div>
                        <div class="form-group mb-2">
                            <label class="@error('password') text-danger @enderror">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password">
                            <i class="text-danger">
                                @error('password') {{ $message }} @enderror
                            </i>
                        </div>
                        <div class="form-group mb-2">
                            <label class="@error('rol') text-danger @enderror">Rol</label>
                            <select class="form-select @error('rol') is-invalid @enderror" wire:model="rol">
                                <option value="">Seleccione...</option>
                                <option value="Admon">Administrador</option>
                                <option value="Operario">Operario</option>
                            </select>
                            <i class="text-danger">
                                @error('rol') {{ $message }} @enderror
                            </i>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info text-white" wire:click="crear">Registrar Usuario</button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Fin modal crear usuario --}}
 
 
        {{-- Modal editar usuario --}}
        <div class="modal fade" id="Modaleditar" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h4 class="modal-title">Editar Usuario</h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label class="@error('nombrex') text-danger @enderror">Nombre</label>
                            <input type="text" class="form-control @error('nombrex') is-invalid @enderror" wire:model="nombrex">
                            <i class="text-danger">
                                @error('nombrex') {{ $message }} @enderror
                            </i>
                        </div>
                        <div class="form-group mb-2">
                            <label class="@error('emailx') text-danger @enderror">Correo</label>
                            <input type="email" class="form-control @error('emailx') is-invalid @enderror" wire:model="emailx">
                            <i class="text-danger">
                                @error('emailx') {{ $message }} @enderror
                            </i>
                        </div>
                        <div class="form-group mb-2">
                            <label class="@error('rolx') text-danger @enderror">Rol</label>
                            <select class="form-select @error('rolx') is-invalid @enderror" wire:model="rolx">
                                <option value="">Seleccione...</option>
                                <option value="Admon">Administrador</option>
                                <option value="Operario">Operario</option>
                            </select>
                            <i class="text-danger">
                                @error('rolx') {{ $message }} @enderror
                            </i>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info text-white" wire:click="actua">Editar Usuario</button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Fin modal editar usuario --}}
 
 
        {{-- Modal contraseña --}}
        <div class="modal fade" id="Modalcontraseña" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h4 class="modal-title">Editar Contraseña</h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label class="@error('passwordy') text-danger @enderror">Contraseña</label>
                            <input type="password" class="form-control @error('passwordy') is-invalid @enderror" wire:model="passwordy">
                            <i class="text-danger">
                                @error('passwordy') {{ $message }} @enderror
                            </i>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info text-white" wire:click="actuacredenciales">Editar Contraseña</button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Fin modal contraseña --}}
 
    </div>
</div>
@push('js')
    <script>
        Livewire.on('ok', ({ msj }) => {
            Swal.fire(msj[0], msj[1], msj[2]);
        });
 
        Livewire.on('confirmDelete', ({ id }) => {
            Swal.fire({
                title: "¿Estas Seguro?",
                text: "¿Desea Eliminar este registro?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "SI"
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatchTo('usuarios', 'delete', { post: id });
                    Swal.fire({
                        title: "!Eliminado!",
                        text: "Se elimino el Usuario",
                        icon: "success"
                    });
                }
            });
        });
    </script>
@endpush
 