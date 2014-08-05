<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controlleradmin');

class IpropertyControllerOpenhouses extends JControllerAdmin
{
	protected $text_prefix = 'COM_IPROPERTY';

	function __construct($config = array())
	{
		parent::__construct($config);
	}

    public function getModel($name = 'Openhouse', $prefix = 'IpropertyModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}
?>
