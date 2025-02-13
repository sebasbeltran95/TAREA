<div>
    @section('title', 'Posts')
    <div class="container-fluid">
        <div class="row text-center mb-3">
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <h1 class="display-4">Modulos</h1>
                <button class="btn btn-primary rounded-circle " data-bs-toggle="modal"
                    data-bs-target="#modalCrearSlug">+</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-sm">
                        <thead>
                            <th colspan="10">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control"
                                    placeholder="Buscar..."
                                    wire:model.live="search">
                                </div>
                            </th>
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Profesor</th>
                                <th class="text-center">Fecha de Publicacion</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->modulos as $cat)
                                <tr>
                                    <td class="text-center">{{ $cat->nombre_modulo }}</td>
                                    <td class="text-center">{{ $cat->profesor }}</td>
                                    <td class="text-center">{{ $cat->created_at }}</td>ss
                                    <td class="d-flex justify-content-center">
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-sm btn-warning"
                                                wire:click="datacliente({{ $cat }})" data-bs-toggle="modal"
                                                data-bs-target="#Modaleditar">
                                                <i class="fas fa-user-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $cat->id }})">
                                                <i class="fas fa-trash-alt"></i>
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
                    {{ $this->modulos->links() }}
                </div>
            </div>
        </div>

        {{-- Modal crear post --}}
        <div class="modal fade" id="modalCrearSlug" tabindex="-1" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crear Modulos</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="@error('nombre_modulo') text-danger @enderror">nombre Modulo</label>
                            <input type="text" class="form-control @error('nombre_modulo') text-danger @enderror" wire:model="nombre_modulo">
                            <i class="text-danger">
                                @error('nombre_modulo') {{ $message }} @enderror
                            </i>
                        </div>
                        <div class="form-group mb-2">
                            <label class="@error('profesor') text-danger @enderror">Profesor</label>
                            <select class="form-select  @error('profesor') text-danger @enderror" wire:model="profesor">
                                <option value="">Seleccione una opción...</option>
                                <option value="Pepito">Pepito</option>
                                <option value="Pablo">Pablo</option>
                            </select>
                            <i class="text-danger">
                                @error('profesor') {{ $message }} @enderror
                            </i>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" wire:click='crear'>Registrar Modulos</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- Fin modal crear post --}}

        {{--  editar   --}}
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="modal fade" id="Modaleditar" tabindex="-1" wire:ignore.self>
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Editar Modulo</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="@error('nombre_modulox') text-danger @enderror">nombre Modulo</label>
                                        <input type="text" class="form-control @error('nombre_modulox') text-danger @enderror" wire:model="nombre_modulox">
                                        <i class="text-danger">
                                            @error('nombre_modulox') {{ $message }} @enderror
                                        </i>
                                    </div>
                                    <div class="form-group mb-2">
                                        <label class="@error('profesorx') text-danger @enderror">Profesor</label>
                                        <select class="form-select  @error('profesorx') text-danger @enderror" wire:model="profesorx">
                                            <option value="">Seleccione una opción...</option>
                                            <option value="Pepito">Pepito</option>
                                            <option value="Pablo">Pablo</option>
                                        </select>
                                        <i class="text-danger">
                                            @error('profesorx') {{ $message }} @enderror
                                        </i>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" wire:click="actua">Editar
                                        Modulo</button>
                                    <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--  editar   --}}

    </div>
</div>
@push('js')
    <script>

        Livewire.on('ok', msj => {
            Swal.fire(
                msj[0][0],  
                msj[0][1],  
                msj[0][2]   
            )
        });

        Livewire.on('showDeleteConfirmation', ({ postId }) => {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas eliminar este registro?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Elimina el post al confirmar
                    Livewire.dispatch('delete', { postId: postId }); // Llama al método delete en el backend
                    Swal.fire(
                        '¡Eliminado!',
                        'El registro ha sido eliminado.',
                        'success'
                    );
                }
            });
        });
    </script>
@endpush