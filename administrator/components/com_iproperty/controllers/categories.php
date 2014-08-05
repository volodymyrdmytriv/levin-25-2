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

class IpropertyControllerCategories extends JControllerAdmin
{
    protected $text_prefix = 'COM_IPROPERTY';
    
	function __construct()
	{		
		parent::__construct();
        $this->registerTask( 'delete', 'remove' );
	}
    
    public function getModel($name = 'Category', $prefix = 'IpropertyModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
    
    public function remove()
	{
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );
        $cid	= JRequest::getVar('cid', array(), '', 'array');
        
        if (empty($cid)) {
			JError::raiseWarning(500, JText::_($this->text_prefix.'_NO_ITEM_SELECTED'));
            $this->setRedirect('index.php?option=com_iproperty&view=categories');
		}
        
		$cids   = implode( ',', $cid );
		$this->setRedirect('index.php?option=com_iproperty&view=categories&hidemainmenu=1&cids='.$cids.'&layout=remove');
	}
	
	public function performRemove()
	{
		// Check for request forgeries
        JRequest::checkToken() or die( 'Invalid Token' );       
        
        $post   = JRequest::get( 'post' );
        $cids	= JRequest::getVar('cids');
        $cids   = explode(',',$cids);
        $subs   = JRequest::getInt('subcats');
        
        if (empty($cids)) {
			JError::raiseWarning(500, JText::_($this->text_prefix.'_NO_ITEM_SELECTED'));
            $this->setRedirect('index.php?option=com_iproperty&view=categories');
		}

		$model  = $this->getModel();
        // Remove the items.
        if ($count = $model->performRemove($cids, $subs)) {
            $this->setMessage(JText::plural($this->text_prefix.'_N_ITEMS_DELETED', $count));
        } else {
            $this->setMessage($model->getError());
        }

		$this->setRedirect('index.php?option=com_iproperty&view=categories');
	}
}
?>
