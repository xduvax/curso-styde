<?php

/*
    Este helper lo hice para que me devuelva un ID random, pero que sea un ID que exista entre las profesiones ya creadas.
    En las pruebas automatizadas, aunque en cada metodo se hace un rollback y se borran los registros creados,
    en el siguiente metodo comienza a contar a partir del ultimo ID creado.
*/

use App\Models\Profession;

function returnProfessionId()
{
    $profesiones = Profession::all();
    foreach($profesiones as $profesion){
        $array[] = $profesion->id;
    }

    $clave = rand(0,4);

    return $array[$clave];
}
