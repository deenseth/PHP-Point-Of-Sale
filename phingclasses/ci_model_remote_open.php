<?php
/**
 * This file is just a cannibalization of "system/codeigniter/CodeIgniter.php"
 * where everything that is non-essential to model loading has been removed (I hope)
 * Instead of loading a controller and letting it take control, we instantiate the
 * base Controller class and then include the base Model class.
 * This way, we should be ready for an external program instantiating a ci model class
 * after including this.
 */

//--------------------------------------------------------------------------------------

/*
 * ------------------------------------------------------
 *  Load constants
 * ------------------------------------------------------
 */
require_once('config_constants.php');

/*
 * ------------------------------------------------------
 *  Load the global functions
 * ------------------------------------------------------
 */
require(BASEPATH.'codeigniter/Common'.EXT);

/*
 * ------------------------------------------------------
 *  Define a custom error handler so we can log PHP errors
 * ------------------------------------------------------
 */
set_error_handler('_exception_handler');
set_magic_quotes_runtime(0); // Kill magic quotes

/*
 * ------------------------------------------------------
 *  Instantiate the base classes
 * ------------------------------------------------------
 */

$CFG     =& load_class('Config');
$LANG    =& load_class('Language');

/*
 * ------------------------------------------------------
 *  Load controller
 * ------------------------------------------------------
 *
 *  Note: Due to the poor object handling in PHP 4 we'll
 *  conditionally load different versions of the base
 *  class.  Retaining PHP 4 compatibility requires a bit of a hack.
 *
 *  Note: The Loader class needs to be included first
 *
 */
if (floor(phpversion()) < 5)
{
    load_class('Loader', FALSE);
    require(BASEPATH.'codeigniter/Base4'.EXT);
}
else
{
    require(BASEPATH.'codeigniter/Base5'.EXT);
}

// instantiate a "fake" controller
$CI = load_class('Controller');

/*
 * ------------------------------------------------------
 *  Prepare for model instantiation
 * ------------------------------------------------------
 */

// load Model parent class
require_once(BASEPATH.'libraries/Model'.EXT);

?> 