<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport('joomla.application.component.controllerform');

class IpropertyControllerCompany extends JControllerForm
{
	protected $text_prefix = 'COM_IPROPERTY';
	
	public function save($key = null, $urlVar = null)
	{
		// saving uploaded pdf's
		$company_id		= JRequest::getInt('id');
		
		$files		= JRequest::get('FILES'); // this should be an array
		
		$model      = $this->getModel('company');
		
		foreach($files as $file_title=>$file){
			
			$model->uploadCompanyFile($file, $company_id, $file_title);
			
		}
		
		parent::save($key, $urlVar);
	}
	
    protected function allowAdd($data = array())
	{
        $allow  = parent::allowAdd($data);
        
        // Check if the user should be in this editing area
        $auth   = new ipropertyHelperAuth();
        $allow  = $auth->canAddCompany();
        
        return $allow;
	}

    protected function allowEdit($data = array(), $key = 'id')
	{
        $allow  = parent::allowEdit($data, $key);
        
        // Check if the user should be in this editing area
        $recordId	= (int) isset($data[$key]) ? $data[$key] : 0;
        $auth   = new ipropertyHelperAuth();
        $allow  = $auth->canEditCompany($recordId);

        return $allow;
	}
}
?>
