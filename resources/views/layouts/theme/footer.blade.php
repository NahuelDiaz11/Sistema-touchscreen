 <!-- BEGIN: JS Assets-->

 <script src="{{ asset('dist/js/app.js')}}"></script>
 <script src="{{ asset('js/snackbar.min.js')}}"></script>
 <script src="{{ asset('js/sweetalert2.min.js')}}"></script>
 <script src="{{ asset('js/alpine.js')}}"></script>
 <!-- END: JS Assets-->
<script>
    window.addEventListener('noty', event=>{
        Snackbar.show({
            text: event.detail.msg,  //mensaje enviado desde el backend
            actionText: 'CERRAR',
            actionTextColor: '#fff',
            backgroundColor: event.detail.type == 'success' ? '#2187EC' : '#e7515a',
            pos: 'top-right'

        })
    })



    //ventanas de notificacion si se quiere elliminar usuarios del sistema
    //componentName sabemos a que componente le vamos a mandar la notificacion
    //methodName el nombre del evento que vamos a emitir
    //rowId fila de la tabla
    function destroy(componentName, methodName='destroy', rowId){
        //plugin de sweetalert
        swal({
            title:'¿Confirmas eliminar el registro?',
            //tipo de mensaje
            type: 'warning',
            //mostramos o no cuales botones
            showCancelButton: true, //se muestra el boton de cerrar para cancelar la operacion
            confirmButtonText: 'Eliminar',
            confirmButtonColor: '#e7515a',
            cancelButtonText: 'Cerrar',
            padding: '2em'
        }).then(function(result){
            if (result.value){
                window.livewire.emitTo(componentName, methodName, rowId) //emitimos un evento al componente que especificamos
                swal.close()
            }
        })

    }


</script>
