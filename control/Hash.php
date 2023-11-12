<?php

class Hash {


public static function encriptar_md5($password){
    return md5($password);
}

public static function verificar_md5($password,$md5){
    return md5($password) === $md5;
}

public static function encriptar_hash($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

public static function verificar_hash($password, $hash) {
    return password_verify($password, $hash);
}
}