<nav class="navbar navbar-expand-lg navbar-dark bg-navbar p-3 ">

    <a class="navbar-brand" href="./" style="display:flex; flex-direction:row;">

        <?php $img = <<<IMG
                <div class="marca">
                    <h1>BikeStore</h1>
                    <span>by grupo 8</span>   
                </div>
            IMG;
        echo $img;
        ?>
       
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