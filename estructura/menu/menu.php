<?php

$abmMenu = new AbmMenu();
$session = new Session();
$rol = $session->getIdRol();
$menu  = $abmMenu->obtenerMenuPorRol($rol);





/**
 * Funcion que recibe un array de objetos Menu y un objeto Menu y 
 * devuelve un string con el submenu renderizado. Renderiza también los submenus de 3er nivel
 * Esta funcion es llamada desde renderizarMenu.
 * @param array $menus
 * @param Menu $padre
 */
function renderizarSubmenu($menus, $padre)
{

    $submenu = array_filter($menus, function ($item) use ($padre) {
        return $item->getPadre() != null && $item->getPadre()->getIdMenu() == $padre->getIdMenu();
    });

    $submenu_3er_nivel = array_filter($menus, function ($item) use ($submenu) {
        return $item->getPadre() != null && $item->getPadre()->getPadre() != null;
    });

    $salida = "";




    if (!empty($submenu)) {
        $salida .= '<ul class="dropdown-menu"  data-bs-theme="dark" aria-labelledby="navbarDropdown">';
        foreach ($submenu as $item) {
            if (!empty($submenu_3er_nivel)) {
             
                $salida .= '<li><a class="dropdown-item" href="'.$item->getLink().'">' . $item->getMeNombre() . ' &raquo; </a>';        
                foreach ($submenu_3er_nivel as $itemsm3) {
                    if($itemsm3->getPadre()->getIdMenu() == $item->getIdMenu()){
                        $salida .= '<ul class="dropdown-menu dropdown-submenu"  data-bs-theme="dark" aria-labelledby="navbarDropdown">';
                        $salida .= '<li><a class="dropdown-item" href="'.$itemsm3->getLink().'">' . $itemsm3->getMeNombre() . '</a></li>';
                    }
                }
                $salida .= '</ul>';
                $salida .= '</li>';
            } else {
                $salida .= '<li><a class="dropdown-item" href="'.$item->getLink().'">' . $item->getMeNombre() . '</a></li>';
            }


            $salida .= '</li>';
        }
        $salida .= '</ul>';
    }
    return $salida;
}

/**
 * Funcion que recibe un array de objetos Menu y devuelve un string con el menu renderizado
 * @param array $menus
 * @return string
 */
function renderizarMenu($menus)
{
    $salida = "";
    $salida .= '<ul class="navbar-nav"  data-bs-theme="dark">';



    foreach ($menus as $item) {
        if ($item->getPadre() === null) {
            $hasSubmenu = !empty(array_filter($menus, function ($i) use ($item) {
                return $i->getPadre() != null && $i->getPadre()->getIdMenu() == $item->getIdMenu();
            }));




            $salida .= '<li class="nav-item' . ($hasSubmenu ? ' dropdown' : '') . '">';
            $salida .= '<a class="nav-link' . ($hasSubmenu ? ' dropdown-toggle' : '') . '" href="' . $item->getLink() . '" role="button" ' . ($hasSubmenu ? 'data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"' : '') . '>' . $item->getMeNombre() . '</a>';

            if ($hasSubmenu) {
                $salida .= renderizarSubmenu($menus, $item);
            }


            $salida .= '</li>';
        }
    }
    $salida .= '</ul>';
    return $salida;
}


$menu_dinamico = renderizarMenu($menu);



$botonIniciarSesion =
    <<<INICIAR_SESION
 <a class="btn btn-dark"  href={$LOGIN}>
 <i class="fa-solid fa-right-to-bracket"></i> Iniciar sesión</a>
INICIAR_SESION;


$subMenuUsuario =  $botonIniciarSesion;
if ($session->validar()) {
    $subMenuUsuario = <<<SUBMENUSR
    <div class="nav-item dropdown menu-usr">
    <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fa-regular fa-user"></i> 
          </button>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
    <h6 class="dropdown-header">Hola, {$session->getUsuario()->getUsNombre()}</h6>
      <li><a class="dropdown-item" href="../vista/usuario.php"><i class="fa-regular fa-circle-user"></i> Mi cuenta</a></li>
      <li><a class="dropdown-item" href="../vista/logout.php"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a></li>
    </ul>
  </div>
    
SUBMENUSR;
}

$carritoMenu =
    <<<CARRITO
<a class="btn btn-dark " href="../vista/carrito.php">
<i class="fa-solid fa-cart-shopping"></i> </a>

CARRITO;

$navegacionDerecha =
    <<<NAVEGACION_DERECHA
<div class="collapse navbar-collapse justify-content-end" id="navegacion">
<ul class="navbar-nav mr-auto mt-2 mt-lg-0 gap-2">
<li class="nav-item">
{$subMenuUsuario}
</li>
<li class="nav-item">
{$carritoMenu}
</li>
</ul>
</div>
NAVEGACION_DERECHA;
