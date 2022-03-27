<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auto Reload
    |--------------------------------------------------------------------------
    |
    | Tell Twig to recompile the template whenever
    | the source code changes.
    |
    */
    'auto_reload' => true,

    /*
    |--------------------------------------------------------------------------
    | Compiled Twig Cache Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Twig templates will be
    | cached for your application.
    |
    */
    'cache' => storage_path('framework/views/twig'),

    /*
    |--------------------------------------------------------------------------
    | Debug
    |--------------------------------------------------------------------------
    |
    | Enable the debug mode on the Twig environment. Generated templates
    | have a "__toString()" method that you can use to display the
    | generated nodes.
    |
    */
    'debug' => config('app.debug', true),

    /*
    |--------------------------------------------------------------------------
    | Strict Variables
    |--------------------------------------------------------------------------
    |
    | When set to "true", Twig throws an exception instead of silently
    | ignore invalid variables.
    |
    */
    'strict_variables' => true,

];