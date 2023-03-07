<div class="intro-y col-span-12">
    <div class="intro-y box">
        <div class="flex flex-col sm-flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
            <h2 class="font-medium text base mr-auto">
                {{ $componentName }} |<span class="font-normal">{{ $action }}</span>
            </h2>
        </div>

        <div class="p-5">
            <div class="preview">

                <div class="mt-3">
                    <div class="sm:grid grid-cols-3 gap-5">
                        <div>
                            <label class="form-label">Nombre</label>
                            <input wire:model="name" id="name" type="text" class="form-control form-control-lg border-start-0 {{($errors->first('name') ? "border-danger" : "")}}" placeholder="ej: Nahuel Diaz" maxlength="255" />
                            @error('name')
                            <x-alert msg="{{ $message }}" />
                            @enderror
                        </div>
                        <div>

                            <label class="form-label">Teléfono</label>
                            <input wire:model="phone" id="phone" type="text" class="form-control form-control-lg border-start-0 {{($errors->first('phone') ? "border-danger" : "")}}" placeholder="eje: 3511159550" maxlength="10" />
                            @error('phone')
                            <x-alert msg="{{ $message }}" />
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Calle</label>
                            <input wire:model="street" id="street" type="text" class="form-control form-control-lg border-start-0  {{($errors->first('street') ? "border-danger" : "")}}" placeholder="eje: Avenida Reforma" maxlength="255" />
                            @error('street')
                            <x-alert msg="{{ $message }}" />
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="sm:grid grid-cols-3 gap-5">
                        <div>
                            <label class="form-label">Número de calle</label>
                            <input wire:model="number" id="number" type="text" class="form-control form-control-lg border-start-0  {{($errors->first('number') ? "border-danger" : "")}}" placeholder="ej: 450" maxlength="20" />
                            @error('number')
                            <x-alert msg="{{ $message }}" />
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Provincia</label>
                            <input wire:model="province" id="province" type="text" class="form-control form-control-lg border-start-0  {{($errors->first('province') ? "border-danger" : "")}}" placeholder="ej: Cordoba" maxlength="60" />
                            @error('province')
                            <x-alert msg="{{ $message }}" />
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Ciudad</label>
                            <input wire:model="city" id="city" type="text" class="form-control form-control-lg border-start-0 {{($errors->first('city') ? "border-danger" : "")}}" placeholder="ej: Villa Maria" maxlength="35" />
                            @error('city')
                            <x-alert msg="{{ $message }}" />
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="sm:grid grid-cols-3 gap-5">
                        <div>
                            <label class="form-label">País</label>
                            <input wire:model="country" id="country" type="text" class="form-control form-control-lg border-start-0 {{($errors->first('country') ? "border-danger" : "")}}" placeholder="Argentina" maxlength="50" disabled/>
                            @error('country')
                            <x-alert msg="{{ $message }}" />
                            @enderror
                        </div>
                        <div>
                            <label class="form-label">Código Postal</label>
                            <input wire:model="zipcode" id="zipcode"  type="text" class="form-control form-control-lg border-start-0  {{($errors->first('zipcode') ? "border-danger" : "")}}" placeholder="ej: 5900" maxlength="5" />
                            @error('zipcode')
                            <x-alert msg="{{ $message }}" />
                            @enderror
                        </div>

                    </div>
                </div>


                <div class="mt-5">
                    <x-back />

                    <x-save />
                </div>
            </div>
        </div>
    </div>



</div>
