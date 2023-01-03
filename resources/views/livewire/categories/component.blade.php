<div>
    @if (!$form)
        <div class="intro-y col-span-12">
            <div class="intro-y box">
                <h2 class="text-lg font-medium text-center text-theme-1 py-4"> CATEGORIAS</h2>
                <x-search />

                <div class="p-5">
                    <div class="preview">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                <tr class="text-theme-1">
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" width="10%"></th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" width="70%">DESCRIPCION</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">ACCIONES</th>
                                </tr>
                                </thead>
                                <tbody>
                                    {{-- si esta vacio muestra que no hay categorias registradas --}}
                                    @forelse($categories as $category)
                                        {{-- si nos retorna un valor mayor a 0 nos retorna gris --}}
                                        <tr class="dark:bg-dark-1 {{ $loop->index % 2 > 0 ? 'bg-gray-200' : '' }}">
                                            <td>
                                                <img src="{{ $category->img }}" data-action="zoom" alt="img-category"
                                                    width="100">
                                            </td>
                                            <td class="dark:border-dark-5">
                                                <h6 class="mb-1 font-medium">{{ $category->name }}</h6>
                                                {{-- Accedemos a la relacion y contamos cuantos registros tiene asociado con count y ponemos el nombre --}}
                                                <small class="font-normal">{{ $category->products->count() }}
                                                    Productos
                                                </small>

                                            </td>
                                            <td class="dark:border-dark-5 text-center">
                                                <div class="d-flex justify-content-center">
                                                    {{-- si es menor a 1 no tiene productos relacionada  y puede eliminarse--}}
                                                    @if ($category->products->count() < 1)
                                                        <button class="btn btn-danger text-white border-0"

                                                            onclick="destroy('categories', 'destroy', {{ $category->id }})">
                                                            <i class="fas fa-trash fa-2x"></i>
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-warning text-white border-0 ml-1"
                                                        wire:click.prevent="Edit({{ $category->id }})">
                                                        <i class="fas fa-edit fa-2x"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="bg-gray-200 dark:bg-dark-1">
                                            <td colspan="2">
                                                <h6 class="text-center">NO HAY CATEGORIAS CARGADAS</h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

                <div class="col-span-12 p-5">
                    {{ $categories->links() }}
                </div>

            </div>
        </div>
    @else
        @include('livewire.categories.form')

    @endif
 @include('livewire.sales.keyboard')

<script>
    //sincronizamos propiedad con la caja de busqueda
    const inputSearch = document.getElementById('search')
    inputSearch.addEventListener('change',(e)=>{

        @this.search=e.target.value

    })
</script>

</div>
