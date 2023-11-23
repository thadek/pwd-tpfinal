<?php

$session = new Session();

$session->autorizarPeticion();

echo <<<HEADER
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
   <link rel="stylesheet" href="{$RUTAVISTA}/css/styles.css">
   <link rel="stylesheet" href="{$RUTAVISTA}/css/inicio.css">
   <link rel="stylesheet" href="{$RUTAVISTA}/css/bootstrap.min.css">

   <link type="text/css" rel="stylesheet" href="{$RUTAVISTA}/css/jsgrid.min.css" />
   <link type="text/css" rel="stylesheet" href="{$RUTAVISTA}/css/jsgrid-theme.min.css" />
   <link type="text/css" rel="stylesheet" href="{$RUTAVISTA}/css/loader.css" />

   <script type="text/javascript" src="{$RUTAVISTA}/js/bootstrap.bundle.min.js"></script>
   <script type="text/javascript" src="{$RUTAVISTA}/js/jquery.js"></script>
   <script type="text/javascript" src="{$RUTAVISTA}/js/sweetalert2.js"></script>

   

   <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
  
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>

 
    
    <script type="text/javascript" src="{$RUTAVISTA}/js/jsgrid/jsgrid.min.js"></script>    
    <script type="text/javascript" src="{$RUTAVISTA}/js/jquery.validate.js"></script>    
    <script src="https://unpkg.com/validator@latest/validator.min.js"></script>

    <title>$page_title</title>

    
</head>



HEADER;
