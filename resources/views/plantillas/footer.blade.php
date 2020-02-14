<!-- FOOTER -->
<footer>
    <a class="py-2 px-3 text-secondary float-right" data-toggle="modal" data-target="#info"><i class="fas fa-info-circle h2 m-0"></i></a>
    <?php
    if (session()->has('rol')) {
        $rol = session()->get('rol');
        if ($rol == 0) {
            ?>
            <a class="py-2 px-3 text-secondary float-left" data-toggle="modal" data-target="#loginOculto"><i class="fas fa-lock h2 m-0"></i></a>
            <?php
        }
    }
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
                    <li>Víctor Úbeda Castilla</li>
                    <li>Carlos Morales Gallego</li>
                </ul>
                <hr>
                Iconos de <a href="https://fontawesome.com/license" class="text-orange">Fontawesome</a>
            </div>
        </div>
    </div>
</section>

<!-- VENTANA MODAL LOGIN -->
<section class="modal fade" id="loginOculto">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-orange text-white px-4">
                <div class="modal-title">Información</div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="form-group">
                    <label class="sr-only" for="clave">Contraseña</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fas fa-key"></i></div>
                        </div>
                        <input type="password" name="clave" id="clave" placeholder="Contraseña" class="form-control">
                    </div>
                </div>
                <input type="submit" name="login" id="login" value="Iniciar sesión" class="btn btn-orange w-100 simplemodal-close" onclick="comprobar()">
            </div>
        </div>
    </div>
</section>