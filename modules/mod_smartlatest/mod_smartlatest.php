<?php
/*------------------------------------------------------------------------
# mod_smartlatest.php - Smart Latest News (module)
# ------------------------------------------------------------------------
# version		1.0.0
# author    	Master Comunicacion
# copyright 	Copyright (c) 2011 Top Position All rights reserved.
# @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website		http://master-comunicacion.es/joomla-extensions/
-------------------------------------------------------------------------

# this module is based on Aixeena Zaragoza latest News (GNU licensed)

*/
// no direct access
defined('_JEXEC') or die;
$document = JFactory::getDocument();

require_once (dirname(__FILE__).'/helper.php');
$list = modSmartlatestHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require(JModuleHelper::getLayoutPath('mod_smartlatest', $params->get('layout', 'default')));

?>