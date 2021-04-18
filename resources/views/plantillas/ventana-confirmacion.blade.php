{{-- Ventana de confirmación --}}
<div class="modal fade" id="vtnConfirmacion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{__('textos.titulos.confirmacion')}}</h5>
                <button type="button" class="close" data-dismiss="modal"> <span aria-hidden="true">&times;</span> </button>
            </div>
            <div class="modal-body">{{__('textos.parrafos.confirmacion')}}</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('textos.botones.cancelar')}}</button>
                <button type="button" class="btn btn-primary" onclick="document.querySelector('.form-registros').submit()">{{__('textos.botones.confirmar')}}</button>
            </div>
        </div>
    </div>
</div>