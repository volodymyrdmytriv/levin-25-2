<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

class IpropertyControllerCompanyForm extends JControllerForm
{
	protected $view_item = 'companyform';
    protected $view_list = 'manage';

	public function add()
	{
		if (!parent::add()) {
			// Redirect to the return page.
			$this->setRedirect($this->getReturnPage());
		}
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
    
	public function cancel($key = 'id')
	{
		parent::cancel($key);

		// Redirect to the return page.
		$this->setRedirect($this->getReturnPage());
	}

	public function edit($key = null, $urlVar = 'id')
	{
        $result = parent::edit($key, $urlVar);

		return $result;
	}

	public function &getModel($name = 'companyform', $prefix = '', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		// Need to override the parent method completely.
		$tmpl		= JRequest::getCmd('tmpl');
		$layout		= JRequest::getCmd('layout', 'edit');
		$append		= '';

		// Setup redirect info.
		if ($tmpl) {
			$append .= '&tmpl='.$tmpl;
		}

		$append .= '&layout=edit';

		if ($recordId) {
			$append .= '&'.$urlVar.'='.$recordId;
		}

		$itemId	= JRequest::getInt('Itemid');
		$return	= $this->getReturnPage();

		if ($itemId) {
			$append .= '&Itemid='.$itemId;
		}

		if ($return) {
			$append .= '&return='.base64_encode($return);
		}

		return $append;
	}

	protected function getReturnPage()
	{
		$return = JRequest::getVar('return', null, 'default', 'base64');

		if (empty($return) || !JUri::isInternal(base64_decode($return))) {
			return JURI::base();
		}
		else {
			return base64_decode($return);
		}
	}

	public function save($key = null, $urlVar = 'id')
	{
		$task   = $this->getTask();
        $result = parent::save($key, $urlVar);

		// If ok, redirect to the return page.
		if ($result && $task != 'apply') {
			$this->setRedirect($this->getReturnPage());
		}

		return $result;
	}
    
    public function checkinCompany(){
        JRequest::checkToken('get') or jexit(JText::_('JINVALID_TOKEN'));
        $model		= $this->getModel();
        $recordId   = JRequest::getInt('id');
        
        if ($model->checkin($recordId) === false) {
            // Check-in failed, go back to the record and display a notice.
            $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
            $this->setMessage($this->getError(), 'error');
            $this->setRedirect($this->getReturnPage());

            return false;
        }
                
        $this->setRedirect($this->getReturnPage());
        return true;
    }
}
