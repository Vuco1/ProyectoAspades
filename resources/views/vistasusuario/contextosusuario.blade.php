@extends('plantillas/maestra')
@section('titulo')
ContextosGenerales
@endsection
@section('contenido')
<main class="container-fluid">
    <div class="row contextodiv">
        <?php
        $cont = 1;
        foreach ($imgtab as $imgT) {
            if ($cont % 4 === 0) {
                $cont = 1;
                ?>
            </div>
            <div class="row contextodiv">
                <?php
            }
            ?>
            <form action="contextosUsuario" method="post">
                @csrf
                <input type="hidden" name="id" value="<?= $imgT->Id_imagen ?>">
                <button class="contextobtn"><img src="<?php echo $imgT->Ruta ?>" width="200" height="200"/></button>
                <input type="hidden" name="contexto" value="<?= $imgT->Nombre ?>">
            </form>
            <?php
            $cont++;
        }
        ?>
    </div>
    <a href="addContexto">add</a>
</main>
@endsection