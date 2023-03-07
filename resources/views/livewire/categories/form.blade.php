<div class="intro-y col-span-12">
    <div class="intro-y box">
        <div class="flex flex-col sm-flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text base mr-auto">
                {{ $componentName }} |<span class="font-normal">{{ $action }}</span>
            </h2>
        </div>

        <div class="p-5">
            <div class="preview">

                    <label  class="form-label">Nombre</label>
                    <input wire:model="name" x-ref="first" id="categoryName" type="text"
                    class="form-control {{($errors->first('name') ? "border-theme-6" : "")}}"
                    placeholder="ingresa la descripción" />
                    @error('name')
                    <x-alert msg="{{ $message }}" />
                    @enderror

                <div class="mt-3">
                    <label class="form-label">Imagen</label>
                    {{-- aceptamos imagenes png, jpeg y jpg --}}
                    <label  class="form-label">Imágen</label>
                    <input wire:model="photo" accept="image/x-png,image/jpeg,image/jpg" class="form-control" type="file">
                </div>

                {{-- cuando el user selecciona una img la podemos previsualizar --}}
                <div class="div-mt-3" id="avatar">
                    @if ($photo)
                        <img class="rounder-lg mb-5 recent-product-img" src="{{ $photo->temporaryUrl() }}"
                            alt="" width="150">
                    @endif

                </div>

                <div class="mt-5">
                    <x-back />

                    <x-save />
                </div>

            </div>
        </div>
    </div>


</div>
