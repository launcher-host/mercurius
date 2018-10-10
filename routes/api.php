<?php

Route::group([
    'as'         => 'mercurius.',
    'middleware' => 'api',
], function () {
    $namespaceprefix = '\\Launcher\\Mercurius\\Http\\Controllers\\';
});
