<?php
require_once('../configuracion.php');
require_once('../estructura/header.php');
?>

<body class="bg-dark">
<?php
    include_once("../estructura/menu/menu.php");
    $rutalogo = "./img/";
    include_once("../estructura/Navbar.php");
?>

        <div class="formulario cont">
            <h2 class="p-3">Registrarse</h2>
            <form action="accion/accionNuevoUsuario.php" id="form_registro"  class="d-flex flex-column gap-3" style="width:60%" method="post" id="formLogin">
            <input type="text" id="nombreUsuario" name="usnombre" placeholder="Ingrese su nombre de usuario">
            <span class="error-message"></span>
            <input type="text" id="mail" name="usmail" placeholder="Ingrese su mail">
            <span class="error-message"></span>
            <input type="password" id="pass" name="uspass" placeholder="Contrase&ntilde;a">
            <span class="error-message"></span>
            <input class="btn btn-light p-3" type="submit" value="Registrar Usuario">
            </form>
        </div>
        <div class="contenedor">
</div>

    <?php include_once("../estructura/Footer.php"); ?>

</body>

<script src="./js/usuario/registrar_usr.js"></script>

</html>