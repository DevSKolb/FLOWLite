<?php
/*                                                                        *
 * This script belongs to the FLOWLite framework.                         *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        */

/**
 * Bootstrap for the FLOWLite Framework
 *
 * @version $Id: FLOWLite.php 0837 2011-06-02 10:05:24 sko $
 * @author Silvan Kolb <kontakt@silvankolb.de>
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser Public License, version 3 or later
 */
 
version_compare(PHP_VERSION, '5.2.0', '>=') or die('Because FLOWLite uses OOP specifics, it requires at least PHP 5.2.0, you have ' . phpversion() . ' (Error #1255310789)' . PHP_EOL);

define('FL_PATH_CLASSES',   $_SERVER["DOCUMENT_ROOT"] .'/'. 'FLOWLite/Unity/Framework/FL/Classes');
define('FL_PATH_BOOTSTRAP', $_SERVER["DOCUMENT_ROOT"] .'/'. 'FLOWLite/Unity/Framework/FL/Classes/Core/');
define('FL_PATH_CONFIG',    $_SERVER["DOCUMENT_ROOT"] .'/'. 'FLOWLite/Unity/Framework/FL/Configuration/');
define('FL_PATH_XML',       $_SERVER["DOCUMENT_ROOT"] .'/'. 'FLOWLite/Unity/Framework/FL/Configuration/config.xml');
define('FL_PATH_ORM',		$_SERVER["DOCUMENT_ROOT"] .'/'. 'FLOWLite/Unity/Application/ORM');

/*
 * path to bootstrap
 */
require( FL_PATH_BOOTSTRAP . 'BootstrapX.php');

/*
 * running framework
 */
$FLOWLite = new BootstrapX();
$FLOWLite->initialize();
$FLOWLite->run();

?>