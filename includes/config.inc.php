<?php
@ini_set( 'upload_max_size' , '11M' ); 
@ini_set( 'post_max_size', '11M'); 
@ini_set( 'max_execution_time', '300' );
////////////////////////////////////////////////////////////////////////////////
// Configure the default time zone
////////////////////////////////////////////////////////////////////////////////
date_default_timezone_set('MST');

////////////////////////////////////////////////////////////////////////////////
// Configure the default currency
////////////////////////////////////////////////////////////////////////////////
setlocale(LC_MONETARY, 'en_US');

$url="http://localhost/kit/";
$content = "content";
$contentRead = "content/";

$lideres = array(41185, 239, 14993, 15113);
//$urlDatos="http://cenedic3.ucol.mx/content/saestuc/";

////////////////////////////////////////////////////////////////////////////////
// Definir constantes para la conección a la base de datos
////////////////////////////////////////////////////////////////////////////////
defined('DATABASE_HOST') ? NULL : define('DATABASE_HOST', 'localhost');
defined('DATABASE_NAME') ? NULL : define('DATABASE_NAME', 'kit_nature');
defined('DATABASE_USER') ? NULL : define('DATABASE_USER', 'cned_kit');
defined('DATABASE_PASSWORD') ? NULL : define('DATABASE_PASSWORD', 'bbnZj6pPu5C9R4vj');

////////////////////////////////////////////////////////////////////////////////
// Define absolute application paths
////////////////////////////////////////////////////////////////////////////////

// Use PHP's directory separator for windows/unix compatibility
defined('DS') ? NULL : define('DS', DIRECTORY_SEPARATOR);

// Define absolute path to server root
defined('SITE_ROOT') ? NULL : define('SITE_ROOT', dirname(dirname(__FILE__)).DS);

// Define absolute path to includes
defined('INCLUDE_PATH') ? NULL : define('INCLUDE_PATH', SITE_ROOT.'includes'.DS);
defined('FUNCTION_PATH') ? NULL : define('FUNCTION_PATH', INCLUDE_PATH.'functions'.DS);
defined('LIB_PATH') ? NULL : define('LIB_PATH', INCLUDE_PATH.'libraries'.DS);
defined('MODEL_PATH') ? NULL : define('MODEL_PATH', INCLUDE_PATH.'models'.DS);
defined('VIEW_PATH') ? NULL : define('VIEW_PATH', INCLUDE_PATH.'views'.DS);

////////////////////////////////////////////////////////////////////////////////
// Include library, helpers, functions
////////////////////////////////////////////////////////////////////////////////
require_once(FUNCTION_PATH.'functions.inc.php');
require_once(LIB_PATH.'database.class.php');
require_once(MODEL_PATH.'usuarios.model.php');
require_once(MODEL_PATH.'description_roles.model.php');
require_once(MODEL_PATH.'ordenesots.model.php');
require_once(MODEL_PATH.'activos_equipos.model.php');
require_once(MODEL_PATH.'mpIdeales.model.php');

require_once(MODEL_PATH.'calendario_nature.model.php');
require_once(MODEL_PATH.'herramientas_herramientas.model.php');
require_once(MODEL_PATH.'herramientas_categorias.model.php');
require_once(MODEL_PATH.'herramientas_almacenes.model.php');
require_once(MODEL_PATH.'herramientas_prestamos.model.php');
require_once(MODEL_PATH.'mediciones_camara_fria.model.php');

require_once(MODEL_PATH.'mp_mc_historicos.model.php');

// para almacen
require_once(MODEL_PATH.'almacen_inventario.model.php');

// para dashboard
require_once(MODEL_PATH.'archivosDashboard.model.php');