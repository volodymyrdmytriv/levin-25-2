<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.view');

class IpropertyViewIconuploader extends JView  
{
	public function display($tpl = null)
	{
		$app        = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
		$document   = JFactory::getDocument();
        JHTML::_('behavior.mootools', true);

		if($this->getLayout() == 'uploadicon') {
			$this->_uploadicon($tpl);
			return;
		}

		//get vars
		$task 		= JRequest::getVar( 'task' );
		$search 	= $app->getUserStateFromRequest( $option.'.iconuploader.search', 'search', '', 'string' );
		$search 	= trim(JString::strtolower( $search ) );

		//set variables
        switch($task){
            case 'selectcompaniesimg':
                $folder = 'companies';
                $task 	= 'companiesimg';
                $redi	= 'selectcompaniesimg';
            break;

            case 'selectagentsimg':
                $folder = 'agents';
                $task 	= 'agentsimg';
                $redi	= 'selectagentsimg';
            break;

            case 'selectcategoriesimg':
                $folder = 'categories';
                $task 	= 'categoriesimg';
                $redi	= 'selectcategoriesimg';
            break;
		}
		JRequest::setVar( 'folder', $folder );

		// Do not allow cache
		JResponse::allowCache(false);

		//add css
		$document->addStyleSheet('components/com_iproperty/assets/css/iproperty_backend.css');

		//get images
		$images     = $this->get('images');
		$pageNav    = $this->get( 'Pagination' );

		if (count($images) > 0 || $search) {
			$this->assignRef('images', 	$images);
			$this->assignRef('folder', 	$folder);
			$this->assignRef('task', 	$redi);
			$this->assignRef('search', 	$search);
			$this->assignRef('state', 	$this->get('state'));
			$this->assignRef('pageNav', $pageNav);
			parent::display($tpl);
		} else {
			//no images in the folder, redirect to uploadscreen and raise notice
			JError::raiseNotice('SOME_ERROR_CODE', JText::_( 'COM_IPROPERTY_NO_IMAGES_AVAILABLE' ));
			$this->setLayout('uploadicon');
			JRequest::setVar( 'task', $task );
			$this->_uploadicon($tpl);
			return;
		}
	}

	public function setImage($index = 0)
	{
		if (isset($this->images[$index])) {
			$this->_tmp_icon = $this->images[$index];
		} else {
			$this->_tmp_icon = new JObject;
		}
	}

	protected function _uploadicon($tpl = null)
	{
		//initialise variables
		$document	= JFactory::getDocument();
		$settings   = ipropertyAdmin::config();

		//get vars
		$task 		= JRequest::getVar( 'task' );

		//add css
		$document->addStyleSheet('components/com_iproperty/assets/css/iproperty_backend.css');

		//assign data to template
		$this->assignRef('task'      	, $task);
		$this->assignRef('settings'  	, $settings);

		parent::display($tpl);
	}
}
?>