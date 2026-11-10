<div>
    @section('title', 'Trabajadores')
    <div class="container-fluid mt-5">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <i class="fab fa-product-hunt"></i>
                Trabajadores
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-sm">
                                <thead>
                                    <th colspan="6">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="input-group input-group-sm w-50">
                                                <input type="text" class="form-control"
                                                    placeholder="Buscar..."
                                                    wire:model.live="search">
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-info text-white btn-sm d-flex align-items-center gap-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalCrearProduct">
                                                    <i class="fas fa-plus"></i> Crear
                                                </button>
                                            </div>
                                        </div>
                                    </th>
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Codigo</th>
                                        <th class="text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($this->trabajadores as $pro)
                                        <tr>
                                            <td class="text-center">{{ $pro->nombre }}</td>
                                            <td class="text-center">{{ $pro->codigo }}</td>
                                            <td class="text-center">
                                                @if($pro->estado == 1)
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-sm btn-secondary" wire:click="cargacategory({{ $pro }})" data-bs-toggle="modal"  data-bs-target="#Modaleditar">
                                                        <i class="fas fa-user-edit"></i>
                                                    </button>
                                                    {{--  <button type="button" class="btn btn-sm btn-dark"
                                                        wire:click="$dispatch('confirmDelete', { id: {{ $pro->id }} })">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>  --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $this->trabajadores->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal crear producto --}}
        <div class="modal fade" id="modalCrearProduct" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h4 class="modal-title">Crear Trabajador</h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label class="@error('nombre') text-danger @enderror">Nombre</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model="nombre">
                            <i class="text-danger">
                                @error('nombre') {{ $message }} @enderror
                            </i>
                        </div>
                        <div class="form-group mb-2">
                            <label class="@error('codigo') text-danger @enderror">Codigo</label>
                            <input type="text" class="form-control @error('codigo') is-invalid @enderror" wire:model="codigo">
                            <i class="text-danger">
                                @error('codigo') {{ $message }} @enderror
                            </i>
                        </div>
                        <div class="form-group mb-2">
                            <label class="@error('estado') text-danger @enderror">Estado</label>
                            <select class="form-select @error('estado') is-invalid @enderror" wire:model="estado">
                                <option value="">Seleccione...</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                            <i class="text-danger">
                                @error('estado') {{ $message }} @enderror
                            </i>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info text-white" wire:click='crear'>Registrar Trabajador</button>
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Fin modal crear producto --}}


        {{-- modal  editar producto  --}}
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="modal fade" id="Modaleditar" tabindex="-1" wire:ignore.self>
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-dark text-white">
                                    <h4 class="modal-title">Editar Trabajador</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group mb-2">
                                        <label class="@error('nombrex') text-danger @enderror">Nombre</label>
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model="nombrex">
                                        <i class="text-danger">
                                            @error('nombrex') {{ $message }} @enderror
                                        </i>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="@error('codigox') text-danger @enderror">Codigo</label>
                                        <input type="text" class="form-control @error('codigox') is-invalid @enderror" wire:model="codigox">
                                        <i class="text-danger">
                                            @error('codigox') {{ $message }} @enderror
                                        </i>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="@error('estadox') text-danger @enderror">Estado</label>
                                        <select class="form-select @error('estadox') is-invalid @enderror" wire:model="estadox">
                                            <option value="">Seleccione...</option>
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                        <i class="text-danger">
                                            @error('estadox') {{ $message }} @enderror
                                        </i>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-info text-white" wire:click="actua">Editar
                                        Trabajador</button>
                                    <button type="button" class="btn btn-dark"
                                        data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--  editar   --}}

        {{-- Modal importar producto --}}
        <div class="modal fade" id="modalImportarProduct" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-dark text-white">
                        <h4 class="modal-title">Importar Productos</h4>
                        <button type="button" class="btn-close btn-close-white" 
                                data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Seleccionar archivo Excel</label>
                            <input type="file" 
                                class="form-control @error('archivo') is-invalid @enderror"
                                wire:model="archivo"
                                accept=".xlsx,.xls,.csv">
                            <i class="text-danger">
                                @error('archivo') {{ $message }} @enderror
                            </i>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i>
                                El archivo debe tener las columnas: 
                                <strong>nombre, descripcion, disponible, precio</strong>
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary text-white" 
                                wire:click="importExcel">
                            <i class="fas fa-file-import"></i> Importar
                        </button>
                        <button type="button" class="btn btn-dark" 
                                data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Fin modal importar producto --}}

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
                    Livewire.dispatchTo('products', 'delete', { post: id });
                    Swal.fire({
                        title: "!Eliminado!",
                        text: "Se elimino el Producto",
                        icon: "success"
                    });
                }
            });
        });
    </script>
@endpush