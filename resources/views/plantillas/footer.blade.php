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
        <a href="{{ url('lang', ['es']) }}" class="py-2 px-3 text-secondary float-left"><img src="../public/images/icons/logo_aspades.svg" style="width:40px;"></a>
        <a class = "py-2 px-3 text-secondary float-right" data-toggle = "modal" data-target = "#info"><i class = "fas fa-info-circle h2 m-0"></i></a>
    <?php }
    ?>  

</footer>
<!-- VENTANA MODAL INFO -->
<section class="modal fade" id="info">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-orange text-white px-4">
                <div class="modal-title">Información</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                Creado por:
                <ul>
                    <li>Laura Mª Fernández Cambronero</li>
                    <li>Isabel de Marcos López</li>
                    <li>Carlos Morales Gallego</li>
                    <li>Víctor Úbeda Castilla</li>
                </ul>
                <hr>
                Iconos de <a href="https://fontawesome.com/license" class="text-orange">Fontawesome</a>
            </div>
        </div>
    </div>
</section>

<!-- VENTANA MODAL LOGIN ADMINISTRADOR DE TABLEROS -->
<section class="modal fade" id="loginoculto">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-orange text-white px-4">
                <div class="modal-title">Login Administración de tableros</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div id="divpass" class="form-group">
                    <label class="sr-only" for="passw">Contraseña</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-key"></i></div>
                        </div>
                        <input type="password" name="passw" id="passw" placeholder="Contraseña" class="form-control">
                    </div>
                </div>
                <input type="submit" name="loginadmin" id="loginadmin" value="Mostrar menú" class="btn btn-orange w-100 simplemodal-close">
            </div>
        </div>
    </div>
</section>
