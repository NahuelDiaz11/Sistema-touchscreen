<div>

    <div class="intro-y col-span-12">
        <div class="intro-y box">
            <h2 class="text-lg font-medium text-center text-theme-1 py-4"> PRODUCTOS</h2>
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2 p-4">
                <button onclick="openPanel('add')" class="btn btn-primary shadow-md mr-2">Agregar</button>

                <div class="hidden md:blocl mx-auto text-gray-600">-</div>

                <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                    <div class="w-56 relative text-gray-700 dark:text-gray-300">
                        <input wire:moodel='search' id="search" type="text"
                            class="form-control w-56 box pr-10 placeholder-theme-13 kioskboard" placeholder="Buscar...">
                        <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0 fas fa-search"></i>
                    </div>
                </div>
            </div>



            <div class="p-5">
                <div class="preview">
                    <div class="overflow-x-auto">
                        <table class="table">
                            <thead>
                                <tr class="text-theme-1">
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" width="10%"></th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" width="30%">
                                        DESCRIPCION</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">CATEGORIA</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">COSTO</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">PRECIO</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">STOCK</th>
                                    <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- si esta vacio muestra que no hay categorias registradas --}}
                                @forelse($products as $product)
                                    {{-- si nos retorna un valor mayor a 0 nos retorna gris --}}
                                    <tr class="dark:bg-dark-1 {{ $loop->index % 2 > 0 ? 'bg-gray-200' : '' }}">
                                        <td>
                                            <img src="{{ $product->img }}" data-action="zoom" alt="img-product"
                                                width="100">
                                        </td>
                                        <td class="dark:border-dark-5">
                                            <h6 class="mb-1 font-medium">{{ $product->name }}</h6>
                                            {{-- Accedemos a la relacion y contamos cuantos registros tiene asociado con count y ponemos el nombre --}}
                                            <small class="font-normal">{{ $product->sales->count() }}
                                                Ventas
                                            </small>

                                        </td>
                                        <td class="text-center">{{ strtoupper($product->category) }}</td>
                                        <td class="text-center font-medium">{{ number_format($product->cost, 2) }}</td>
                                        <td class="text-center font-medium">{{ number_format($product->price, 2) }}</td>
                                        <td class="text-center font-medium">{{ $product->stock }}</td>

                                        <td class="dark:border-dark-5 text-center">
                                            <div class="d-flex justify-content-center">
                                                {{-- si es menor a 1 no tiene ventas relacionada  y puede eliminarse --}}
                                                @if ($product->sales->count() < 1)
                                                    <button class="btn btn-danger text-white border-0"
                                                        onclick="destroy('products', 'destroy', {{ $product->id }})">
                                                        <i class="fas fa-trash fa-2x"></i>
                                                    </button>
                                                @endif
                                                <button class="btn btn-warning text-white border-0 ml-1"
                                                    wire:click.prevent="Edit({{ $product->id }})">
                                                    <i class="fas fa-edit fa-2x"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-gray-200 dark:bg-dark-1">
                                        <td colspan="2">
                                            <h6 class="text-center">NO HAY PRODUCTOS CARGADOS</h6>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

            {{-- <div class="col-span-12 p-5">
                {{ $products->links() }}
            </div> --}}

        </div>
    </div>
    @include('livewire.products.panel')


    @include('livewire.sales.keyboard')

    <script>
        //sincronizamos propiedad con la caja de busqueda
        const inputSearch = document.getElementById('search')
        inputSearch.addEventListener('change', (e) => {

            @this.search = e.target.value

        })

        // la usamos para ver si es un evento para agregar registro o para actualizar
        function openPanel(action = '') {
            if (action == 'add') {
                @this.resetUI()
            }
            var modal = document.getElementById('panelProduct')
            modal.classList.add('overflow-y-auto', 'show')
            modal.style.cssText = "margin-top: 0px; margin-left: 0px; padding-left: 17px; z-index:100"
        }

        function closePanel(action = '') {
            var modal = document.getElementById('panelProduct')
            modal.classList.add('overflow-y-auto', 'show')
            modal.style.cssText = ""
        }

        // cuando escuchamos este evento se ejecuta el openPanel
        window.addEventListener('open-modal', event => {
            openPanel()
        })

        // si noty dentro de los parametros que nos manda en los action trae un texto que sea closeModal se cierra
        window.addEventListener('noty', event => {
            if (event.detail.action == 'close-modal') closePanel()
        })

        // el teclado esta disponible para todos los elementos de la ventana modal que tengan la clase kioscboard
        Kioscboard.run('.kioscboard', {})
    </script>

</div>
