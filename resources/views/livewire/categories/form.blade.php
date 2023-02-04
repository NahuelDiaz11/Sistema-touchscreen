<div class="intro-y col-span-12">
    <div class="intro-y box">
        <div class="flex flex-col sm-flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text base mr-auto">
                {{ $componentName }} |<span class="font-normal">{{ $action }}</span>
            </h2>
        </div>

        <div class="p-5">
            <div class="preview">
                {{-- apenas abre el formulario se abre el teclado virtual con alpine, con el nombre first que esta en la caja de texto --}}
                <div x-data="{}" x-init="setTimeout(() => { $refs.first.focus() }, 900)">
                    <label class="form-label">Nombre</label>
                    {{-- en el caso que no este completo con la propiedad border theme pinta de rojo el input --}}
                    <input type="text" wire:model="name" x-ref="first" id="categoryName"
                        class="form-control kioskboard {{ $errors->first('name') ? 'border-theme-6' : '' }}"
                        placeholder="ingresa la descripcion">

                    @error('name')

                        <x-alert>
                        {{$message}}
                        </x-alert>
                    @enderror
                </div>
                <div class="mt-3">
                    <label class="form-label">Imagen</label>
                    {{-- aceptamos imagenes png, jpeg y jpg --}}
                    <input type="file" wire:model="photo" accept="image/x-png,image/jpeg,image/jpg"
                        class="form-control">
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
    <script>
    KioskBoard.run('#categoryName', {})
    const inputCatName = document.getElementById('categoryName')
     //a la prop publica del componente category, a name le asignamos el valor que hay en la caja de texto name
    if(inputCatName){
        inputCatName.addEventListener('change', ()=>{
          @this.name = e.target.value
        })
    }
    </script>

</div>
