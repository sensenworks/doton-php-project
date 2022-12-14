<?php


namespace Doton;

use Doton\Core\Server\ResourceChecker;



if( !defined( 'DOTON_CORE_DIR' ) ){ exit( 'Doton Core not found' ); }


/**
 * 
 * --------------------------------------
 * |                                    |
 * |    Check base version of PHP       |
 * |                                    |
 * --------------------------------------
 * 
 */

if( version_compare(PHP_VERSION, '5.0.0', '<') ){ die('Doton requires PHP version 8.0'); }


/**
 * 
 * --------------------------------------
 * |                                    |
 * |    Doton Core                      |
 * |                                    |
 * --------------------------------------
 * 
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . 'core.php';



/**
 * 
 * --------------------------------------
 * |                                    |
 * |    Doton Modules Blend             |
 * |                                    |
 * --------------------------------------
 * 
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . 'modules.php';

Module::load( loadModules() );







/**
 * 
 * --------------------------------------
 * |                                    |
 * |    Doton Auto-Loader               |
 * |                                    |
 * --------------------------------------
 * 
 */

spl_autoload_register( "Doton\Package::autoload" );








/**
 * 
 * --------------------------------------
 * |                                    |
 * |    Doton Error Manager             |
 * |                                    |
 * --------------------------------------
 * 
 */

$DOTON_CORE_ERROR_SHUTDOWN = register_shutdown_function("Doton\Core\Error\ShutDown");

$DOTON_CORE_ERROR_HANDLER = set_error_handler("Doton\Core\Error\Handler", E_ALL);





/**
 * 
 * --------------------------------------
 * |                                    |
 * |    Defines Configurations          |
 * |                                    |
 * --------------------------------------
 * 
 */

$config = config();

$dotonrequire = ( isset( $config->doton ) && is_object( $config->doton ) )

    ? $config->doton : (object) [];


$phprequire = ( isset( $config->{'php-require'} ) && is_object( $config->{'php-require'} ) )

    ? $config->{'php-require'} : (object) [];



/**
 * 
 * --------------------------------------------------------------
 * |                                                            |
 * |    Check the version of PHP required for the project       |
 * |                                                            |
 * --------------------------------------------------------------
 * 
 */



define( 'DOTON_PROJECT_VERSION', ( $phprequire->version ?: null ) );

ResourceChecker::version( 

    'Project requires PHP version',

    DOTON_PROJECT_VERSION,

    null,
    
    true 

);



/**
 * 
 * --------------------------------------------------------------
 * |                                                            |
 * |    Check the modules of PHP required for the project       |
 * |                                                            |
 * --------------------------------------------------------------
 * 
 */

ResourceChecker::modules(
    
    'Project requires PHP Modules', 
    
    isset( $phprequire->modules ) ? (array) $phprequire->modules : [], 
    
    true 

);



/**
 * 
 * --------------------------------------------------------------
 * |                                                            |
 * |    Check the modules of PHP required for the project       |
 * |                                                            |
 * --------------------------------------------------------------
 * 
 */

ResourceChecker::settings(

    'Project requires PHP Settings',
    
     isset( $phprequire->settings ) ? (array) $phprequire->settings : [], 
    
    true 
    
);




/**
 * 
 * --------------------------------------
 * |                                    |
 * |    Doton Auto-Runner               |
 * |                                    |
 * --------------------------------------
 * 
 */

Core\HTTP\URL();
