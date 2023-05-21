<?php

require_once 'vendor/autoload.php';
function autoloadFormEntities ( $fileName )
{
    require_once './entities/' . $fileName . '.php';
}

spl_autoload_register("autoloadFormEntities");