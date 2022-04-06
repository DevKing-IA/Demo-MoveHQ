<?php

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

// Try to find local vendor folder, if that doesn't work then fallback to global monorepo vendor
$localVendor = __DIR__.'/../vendor/autoload.php';
$monoRepoVendor = __DIR__.'/../../../vendor/autoload.php';

if (file_exists($localVendor)) {
    require $localVendor;
} else if (file_exists($monoRepoVendor)) {
    require $monoRepoVendor;
} else {
    echo "Could not find vendor folder - tried:\n- $localVendor \n- $monoRepoVendor";
    die;
}