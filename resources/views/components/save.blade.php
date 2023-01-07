<!-- loading attr sirve para no permitir que el usuario no haga muchas veces click en guardar cuando se haga una peticion ajax -->
<!-- con attributes le podemos pasar otras clases desde un form para que las herede -->
<!-- con wire loading si el metodo que se ejecuta es store se oculta el boton de guardar -->
<button
wire:click="Store"
wire:loading.attr="disable"
{{$attributes->merge(['class' => 'btn btn-primary']) }}
>
<span wire:loading.remove wire:target="Store">
    Guardar
</span>
<span wire:loading wire:target="Store">
    Procesando
</span>

</button>