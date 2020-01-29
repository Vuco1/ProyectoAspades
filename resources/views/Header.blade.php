<?php ?>

<div class="row tam">
    <div class="col">
        <div class="media">            
            <img src="{{asset("imagenes/Victor.jpg")}}" width="60px" height="60px" alt="logo" class="icon"/>
        </div>
    </div>
    <!--El contenido ahora mismo es si no existe esa session  -->
    <?php if (\Session::has('usuario')) { ?>
        <div class="col">
            <div class="row tam justify-content-end align-items-center">
                <form action="inicio" method="post">
                    <button type="submit" class="btn btn-primary btn-sm " name="Inicio"><img src="{{asset("imagenes/home.jpg")}}" alt="Inicio"></button>
                </form>
            </div>
        </div>

        <div class="col">
            <div class="row tam justify-content-end align-items-center">
                <form action="ajustes" method="post">
                    <button type="submit" class="btn btn-primary btn-sm " name="Ajustes"><img src="{{asset("imagenes/ajustes.jpg")}}" alt="Ajustes"></button>
                </form>
            </div>
        </div>

        <div class="col">
            <div class="row tam justify-content-end align-items-center">
                <form action="perfil" method="post">
                    <button type="submit" class="btn btn-primary btn-sm "  name="Perfil"><img src="{{asset("imagenes/perfil.jpg")}}" alt=""></button>
                </form>
            </div>
        </div>

        <div class="col">
            <div class="row tam justify-content-end align-items-center">
                <form action="cerrarsesion" method="post">
                    <button type="submit" class="btn btn-primary btn-sm " name="cerrarSesion"><img src="{{asset("imagenes/off.jpg")}}" alt=""></button>
                </form>
            </div>
        </div>
    <?php } else {
        ?>
        <div class="col">
            <div class="row tam justify-content-end align-items-center">
                <form class="form-inline">
                    <input class="btn btn-primary btn-sm mr-2" data-toggle="modal" data-target="#login" type="button" value="Login">
                    <input class="btn btn-primary btn-sm" data-toggle="modal" data-target="#registrar" type="button" value="Registro">
                </form>
            </div>
        </div>
        <?php
    }
    ?>
</div>
