<div>
    @if(!$form)
<div class="intro-y col-span-12">
<h2 class="text-lg font-medium text-center text-theme-1 py-4"> CATEGORIAS</h2>
<x-search/>

<div class="p-5"></div>
<div class="preview"></div>
<div class="overflow-x-auto"></div>
<table class="table">
    <thead>
        <tr class="text-theme-1"></tr>
        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" width="10%"></th>
        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap" width="700%">DESCRIPCION</th>
        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">ACCIONES</th>
    </thead>
    <tbody>

    </tbody>
</table>

</div>
@else

@include('livewire.categories.form')

@endif

</div>
