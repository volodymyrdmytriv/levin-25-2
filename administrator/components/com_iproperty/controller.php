<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.application.component.controller' );

class IpropertyController extends JController
{
	public function display($cachable = false, $urlparams = false)
	{
        $document	= JFactory::getDocument();
        $document->addStyleSheet('components/com_iproperty/assets/css/iproperty_backend.css');
        //possibly add an external css at some point - not now
        //$document->addStyleSheet('http://twitter.github.com/bootstrap/1.4.0/bootstrap.min.css');

        // Load the submenu.
		IpropertyHelper::addSubmenu(JRequest::getCmd('view', 'iproperty'));

        $view	= JRequest::getCmd('view', 'iproperty');
		$layout = JRequest::getCmd('layout', 'default');
		$id		= JRequest::getInt('id');

		// Check for edit form.
        $views = array( 'category'=>'categories',
                        'property'=>'properties',
                        'agent'=>'agents',
                        'company'=>'companies',
                        'amenity'=>'amenities',
                        'openhouse'=>'openhouses',
                        'plan'=>'plans',
                        'subscription'=>'subscriptions',
                        'payment'=>'payments',
                        'user'=>'users',
                        'resreservation'=>'resreservations',
                        'resrate'=>'resrates',
                        'resstate'=>'resstates',
                        'respayment'=>'respayments' );

        foreach( $views as $key => $value ){
            if ($view == $key && $layout == 'edit' && !$this->checkEditId('com_iproperty.edit.'.$key, $id)) {

                // Somehow the person just went to the form - we don't allow that.
                $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
                $this->setMessage($this->getError(), 'error');
                $this->setRedirect(JRoute::_('index.php?option=com_iproperty&view='.$value, false));

                return false;
            }
        }

		parent::display($cachable);
        return $this;
	}
}
