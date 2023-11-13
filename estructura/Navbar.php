<nav class="navbar navbar-expand-lg navbar-dark bg-navbar p-3 ">

    <a class="navbar-brand" href="./" style="display:flex; flex-direction:row;">

        <?php $img = <<<IMG
            <img src="$rutalogo/logo.png" width="80" height="80" alt="logo grupo 8">
            IMG;
        echo $img;
        ?>
        <h5 class="text-center p-4 ">BikeStore</h5>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navegacion" aria-controls="navegacion" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon "></span>
    </button>

    <div class="collapse navbar-collapse" id="navegacion">
    <?php
        echo $menu_dinamico;
    ?>
    </div>

    <?php 
        echo $navegacionDerecha;
    ?>

</nav>
<div class="linea "> </div> 