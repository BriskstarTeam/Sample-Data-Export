<?php

if (version_compare(PHP_VERSION, '5.4.0', '<')) {
    throw new Exception('Hybridauth 3 requires PHP version 5.4 or higher.');
}


spl_autoload_register(function($class)
{
    if (file_exists(dirname( SDE_PLUGIN_FILE ) . '/includes/admin/'. $class . '.php')) 
    {
        require_once dirname( SDE_PLUGIN_FILE ) . '/includes/admin/'.$class . '.php';
    }
});
