<div>
    @if (!$form)
        <div class="intro-y col-span-12">
            <div class="intro-y box">
                <h2 class="text-lg font-medium text-center text-theme-1 py-4">CLIENTES</h2>
                <x-search />

                <div class="p-5">
                    <div class="preview">
                        <div class="overflow-x-auto">
                            <table class="table">
                                <thead>
                                    <tr class="text-theme-1">
                                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">NOMBRE</th>
                                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">CALLE</th>
                                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">PROVINCIA</th>
                                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">CIUDAD</th>
                                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">C.P</th>
                                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">PAIS</th>
                                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap text-center">ACCIONES
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- si esta vacio muestra que no hay categorias registradas --}}
                                    @forelse($customers as $customer)
                                        {{-- si nos retorna un valor mayor a 0 nos retorna gris --}}
                                        <tr class="dark:bg-dark-1 {{ $loop->index % 2 > 0 ? 'bg-gray-200' : '' }}">


                                            <td class="dark:border-dark-5">
                                                <h6 class="mb-1 font-medium">{{ $customer->name }}</h6>
                                                {{-- Accedemos a la relacion y contamos cuantos registros tiene asociado con count y ponemos el nombre --}}
                                            </td>
                                            <td class="dark:border-dark-5">
                                                <h6 class="mb-1 font-medium">{{ $customer->street }}</h6>
                                            </td>
                                            <td class="dark:border-dark-5">
                                                <h6 class="mb-1 font-medium">{{ $customer->city }}</h6>
                                            </td>
                                            <td class="dark:border-dark-5">
                                                <h6 class="mb-1 font-medium">{{ $customer->province }}</h6>
                                            </td>
                                            <td class="dark:border-dark-5">
                                                <h6 class="mb-1 font-medium">{{ $customer->zipcode }}</h6>
                                            </td>
                                            <td class="dark:border-dark-5">
                                                <h6 class="mb-1 font-medium">{{ $customer->country }}</h6>
                                            </td>
                                            <td class="dark:border-dark-5 text-center">
                                                <div class="d-flex justify-content-center">
                                                    {{-- si es menor a 1 no tiene ordenes relacionadas  y puede eliminarse --}}
                                                    @if ($customer->orders->count() < 1)
                                                        <button class="btn btn-danger text-white bg-light border-0"
                                                            type="button"
                                                            onclick="destroy('customers', 'Destroy', {{ $customer->id }})">
                                                            <i class="fas fa-trash fa-2x"></i>
                                                        </button>
                                                    @endif

                                                    <button
                                                        class="ms-3 btn btn-warning text-white bg-light border-0 ml-3"
                                                        type="button" wire:click.prevent="Edit({{ $customer->id }})">
                                                        <i class="fas fa-edit fa-2x"></i>
                                                    </button>
                                                </div>
                                            </td>


                                        </tr>
                                    @empty
                                        <tr class="bg-gray-200 dark:bg-dark-1">
                                            <td colspan="2">
                                                <h6 class="text-center">NO HAY CLIENTES</h6>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

                <div class="col-span-12 p-5">
                    {{ $customers->links() }}

                </div>

            </div>
        </div>
    @else
        @include('livewire.customers.form')

    @endif




</div>
