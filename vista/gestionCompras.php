<?php

include_once("../configuracion.php");
include_once("../estructura/header.php");

?>




<body class=" bg-dark  ">

    <?php

    include_once("../estructura/menu/menu.php");
    include_once("../estructura/Navbar.php");
    ?>



  

    <main class="container-fluid container tablas text-center text-light">


    <h3>Gestión de Estado de Compras </h3>
  


    <ul class="nav nav-tabs" id="myTab"  data-bs-theme="dark" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#porconfirmar" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Por confirmar</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#aceptadas" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Aceptadas</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#enviadas" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Enviadas</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#canceladas" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Canceladas</button>
  </li>

  
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="porconfirmar" role="tabpanel" aria-labelledby="home-tab" tabindex="0"></div>
  <div class="tab-pane fade" id="aceptadas" role="tabpanel" aria-labelledby="profile-tab" tabindex="0"></div>
  <div class="tab-pane fade " id="enviadas" role="tabpanel" aria-labelledby="home-tab" tabindex="0"></div>
  <div class="tab-pane fade" id="canceladas" role="tabpanel" aria-labelledby="home-tab" tabindex="0"></div>
</div>
       
    </main>



    <div class="contenedor">
    </div>


    <?php include_once("../estructura/Footer.php"); ?>

</body>

<script src="./js/compras/gestionCompras.js"></script>


</html>