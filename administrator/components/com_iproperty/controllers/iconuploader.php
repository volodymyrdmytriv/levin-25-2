<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');

class IpropertyControllerIconuploader extends ipropertyController
{
	function __construct()
	{
		parent::__construct();

		// Register Extra task
		$this->registerTask( 'companiesimgup', 	'uploadicon' );
        $this->registerTask( 'agentsimgup', 	'uploadicon' );
        $this->registerTask( 'categoriesimgup', 	'uploadicon' );
	}

	public function uploadicon()
	{        
		JRequest::checkToken() or die( 'Invalid Token' );
        
		$app        = JFactory::getApplication();
        $settings   = ipropertyAdmin::config();
		$file 		= JRequest::getVar( 'userfile', '', 'files', 'array' );
		$task 		= JRequest::getVar( 'task' );       

		//set the target directory
        switch($task){
            case 'companiesimgup':
                $imgwidth = $settings->company_photo_width;
                $base_Dir = JPATH_SITE.DS.'media'.DS.'com_iproperty'.DS.'companies'.DS;
            break;

            case 'agentsimgup':
                $imgwidth = $settings->agent_photo_width;
                $base_Dir = JPATH_SITE.DS.'media'.DS.'com_iproperty'.DS.'agents'.DS;
            break;

            case 'categoriesimgup':
                $imgwidth = $settings->cat_photo_width;
                $base_Dir = JPATH_SITE.DS.'media'.DS.'com_iproperty'.DS.'categories'.DS;
            break;
        }

		//do we have an upload?
		if (empty($file['name'])) {
			echo "<script> alert('".JText::_( 'COM_IPROPERTY_IMAGE_EMPTY' )."'); window.history.go(-1); </script>\n";
			$app->close();
		}

		//check the image
		if (ipropertyIcon::check($file, $settings) === false) {
            echo "<script> alert('".htmlspecialchars(JText::_( 'COM_IPROPERTY_CANNOT_CHECK_ICON' ))."'); window.history.go(-1); </script>\n";
			$app->redirect($_SERVER['HTTP_REFERER']);
		}

		//sanitize the image filename
		$filename = ipropertyIcon::sanitize($base_Dir, $file['name']);
		$filepath = $base_Dir.$filename;

        if(!ipropertyIcon::resizeImg($file['tmp_name'], $filepath, $imgwidth, 9999)){
            echo "<script> alert('".htmlspecialchars(JText::_( 'COM_IPROPERTY_UPLOAD_FAILED' ))."'); window.history.go(-1); </script>\n";
			$app->close();
        }else{
			echo "<script>window.history.go(-1); window.parent.ipSwitchIcon('$filename');</script>\n";
			$app->close();
        }
	}

	public function delete()
	{
		$app  = JFactory::getApplication();
        $option     = JRequest::getCmd('option');
        
		$images	= JRequest::getVar( 'rm', array(), '', 'array' );
		$folder = JRequest::getVar( 'folder');

		$successful = 0;
        if (count($images)) {
			foreach ($images as $image)
			{
				if ($image !== JFilterInput::clean($image, 'path')) {
					JError::raiseWarning(100, JText::_( 'COM_IPROPERTY_UNABLE_TO_DELETE' ).' '.htmlspecialchars($image, ENT_COMPAT, 'UTF-8'));
					continue;
				}elseif($image == 'nopic.png'){
                    JError::raiseWarning(100, JText::_('COM_IPROPERTY_CANNOT_DELETE_DEFAULT_IMG').' '.htmlspecialchars($image, ENT_COMPAT, 'UTF-8'));
					continue;
                }

				$fullPath = JPath::clean(JPATH_SITE.DS.'media'.DS.'com_iproperty'.DS.$folder.DS.$image);
				if (is_file($fullPath)) {
					if(JFile::delete($fullPath)) $successful++;
				}
			}
		}

        switch($folder){
            case 'companies':
                $task = 'selectcompaniesimg';
            break;

            case 'agents':
                $task = 'selectagentsimg';
            break;

            case 'categories':
                $task = 'selectcategoriesimg';
            break;
		}
        
        if($successful > 0){
            $this->setMessage(JText::plural('COM_IPROPERTY_N_ITEMS_DELETED', $successful));            
        }
        $this->setRedirect('index.php?option=com_iproperty&view=iconuploader&task='.$task.'&tmpl=component');
	}
}
?>