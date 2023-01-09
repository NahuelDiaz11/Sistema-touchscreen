{{-- ignore self sirve para que cuando se haga una peticion ajax no se cierre el modal --}}
{{-- data backdrop sirve para que no se cierre cuando pulsemos la tecla scape --}}
{{-- tabindex para que se posicione primero --}}

<div wire:ignore.self id="panelProduct" class="modal modal-slide-over" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <a href="javascript:;" data-dismiss="modal">
                <i class="fas fa-times w-8 h-8 text-gray-500"></i>
            </a>

            <div class="modal-header p-5">
                <h2 class="font-medium text-base mr-auto">Gestion de Productos</h2>

                <x-save class="mt-4 mr-5" />
            </div>
            <div class="modal-body mr-5">
                <div>
                    <div class="input-group">
                        <div class="input-group-text">Nombre</div>
                        <input type="text" wire:model="name" id="name"
                            class="form-control form-control-lg kioscboard" placeholder="ej: Cerveza">
                    </div>
                    @error('name')
                        <x-alert msg="{{ $message }}" />
                    @enderror
                </div>

                <div class="mt-4">
                    <div class="sm:grid grid-cols-2 gap-2">
                        <div class="input-group">
                            <div class="input-group-text">Costo</div>
                            <input type="number" id="cost" wire:model="cost"
                                class="form-control form-control-lg kioskboard" data-kioskboard-type="numpad"
                                placeholder="ej: 100.00">
                        </div>
                        <div class="input-group">
                            <div class="input-group-text">Codigo</div>
                            <input type="text" id="code" wire:model="code"
                                class="form-control form-control-lg kioskboard" placeholder="ej: 750100">
                        </div>
                        @error('cost')
                            <x-alert msg="{{ $message }}" />
                        @enderror
                        @error('code')
                            <x-alert msg="{{ $message }}" />
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <div class="input-group">
                        <div class="input-group-text">Precio1</div>
                        <input type="number" id="price" wire:model="price"
                            class="form-control form-control-lg kioskboard" data-kioskboard-type="numbpad"
                            placeholder="ej: 500">
                    </div>
                    @error('price')
                        <x-alert msg="{{ $message }}" />
                    @enderror
                </div>

                <div class="mt-4">
                    <div class="input-group">
                        <div class="input-group-text">Precio2</div>
                        <input type="number" id="price2" wire:model="price2"
                            class="form-control form-control-lg kioskboard" data-kioskboard-type="numbpad"
                            placeholder="ej: 500">
                    </div>
                    @error('price2')
                        <x-alert msg="{{ $message }}" />
                    @enderror


                    <div class="mt-4">
                        <div class="sm:grid grid-cols-2 gap-2">
                            <div class="input-group">
                                <div class="input-group-text">Stock</div>
                                <input type="number" id="stock" wire:model="stock"
                                    class="form-control form-control-lg kioskboard" data-kioskboard-type="numpad"
                                    placeholder="ej: 100">
                            </div>
                            <div class="input-group">
                                <div class="input-group-text">Stock Minimo</div>
                                <input type="text" id="minstock" wire:model="minstock"
                                    class="form-control form-control-lg kioskboard" placeholder="ej: 10">
                            </div>
                            @error('stock')
                                <x-alert msg="{{ $message }}" />
                            @enderror
                            @error('minstock')
                                <x-alert msg="{{ $message }}" />
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="input-group">
                            <div class="input-group-text">Categoria</div>
                            <select wire:model='category' class="form-select form-select-lg sm:mr-2">
                                <option value="elegir">Elegir</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category')
                            <x-alert msg="{{ $message }}" />
                        @enderror
                    </div>

                    <div class="mt-4">
                        <div class="grid grid-flow-col auto-cols-max md:auto-cols-min gap-2">
                            <div>
                                <label>Imagenes</label>
                                {{-- con defer se actualiza el valor de la propiedad cuando se haga click en guardar --}}
                                {{-- guarda imagenes png y jpg --}}
                                <input type="file" class="form-control" wire:model.defer='galery'
                                    accept="image/x-png,image/jpeg" multiple>
                                @error('gallery')
                                    <span style="color:red;">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- con wire loading mientras se este cargando se muestra el texto "cargando imagenes" mientras que se este afectando gallery --}}
                            <div wire:loading wire:target='gallery'>Cargando Imagenes...</div>

                        </div>
                        @if (!empty($gallery))
                            <div class="sm:grid-cols-12 md:grid-cols-2 grid grid-cols-3 gap-2 pt-2 overflow-y-auto">
                                @foreach ($gallery as $foto)
                                    <div>
                                        <img class="rounded-lg" src="{{ $photo->temporaryUrl() }}" alt="image">
                                    </div>
                                @endforeach

                            </div>
                        @endif
                    </div>

                </div>

            </div>

        </div>
