<!-- FOOTER -->
<footer>
    <?php
    if (session()->has('rol')) {
        $rol = session()->get('rol');
        if ($rol == 1) {
            ?>
            <a class="py-2 px-3 text-secondary float-right" data-toggle="modal" data-target="#info"><i class="fas fa-info-circle h2 m-0"></i></a>
            <?php
        }
        if ($rol == 0) {
            ?>
            <a class="py-2 px-3 text-secondary float-left" data-toggle="modal" data-target="#loginoculto"><i id="candado" class="fas fa-lock h2 m-0"></i></a>
            <?php
        }
    } else {
        ?>
        <a href="{{ url('lang', ['en']) }}" class="py-2 px-3 text-secondary float-left"><img src="../public/images/icons/United-Kingdom.svg" style="width:40px;"></a>
        <a href="{{ url('lang', ['es']) }}" class="py-2 px-3 text-secondary float-left"><img src="../public/images/icons/bandera-spain.jpg" style="width:40px;"></a>
        <a class = "py-2 px-3 text-secondary float-right" data-toggle = "modal" data-target = "#info"><i class = "fas fa-info-circle h2 m-0"></i></a>
    <?php }
    ?>  

</footer>
<!-- VENTANA MODAL INFO -->
<section class="modal fade" id="info">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-orange text-white px-4">
                <div class="modal-title">@lang('messages.ModalInformacion')</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                @lang('messages.ModalCreadores')
                <ul>
                    <li>Laura Mª Fernández Cambronero</li>
                    <li>Isabel de Marcos López</li>
                    <li>Carlos Morales Gallego</li>
                    <li>Víctor Úbeda Castilla</li>
                </ul>
                <hr>
                @lang('messages.ModalIconos')
            </div>
        </div>
    </div>
</section>

<!-- VENTANA MODAL LOGIN ADMINISTRADOR DE TABLEROS -->
<section class="modal fade" id="loginoculto">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-orange text-white px-4">
                <div class="modal-title">@lang('messages.ModalAdminTableros')</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div id="divpass" class="form-group">
                    <label class="sr-only" for="passw">@lang('messages.ModalAdminTablerosContraseña')</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-key"></i></div>
                        </div>
                        <input type="password" name="passw" id="passw" placeholder="@lang('messages.ModalAdminTablerosContraseña')" class="form-control">
                    </div>
                </div>
                <input type="submit" name="loginadmin" id="loginadmin" value="@lang('messages.ModalAdminTablerosBoton')" class="btn btn-color w-100 simplemodal-close">
            </div>
        </div>
    </div>
</section>
