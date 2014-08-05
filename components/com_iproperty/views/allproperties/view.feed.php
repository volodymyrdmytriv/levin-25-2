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

class IpropertyViewAllProperties extends JView
{
	function display()
	{
		$app  = JFactory::getApplication();

		// Initialize some variables        
        $settings       = ipropertyAdmin::config();		
		$model          = $this->getModel();
		$rows		    = $this->get('properties');
		$doc            = JFactory::getDocument();

        JRequest::setVar('limitstart', 0);
		JRequest::setVar('limit', $settings->rss);

        $pagetitle = ($doc->get('title')) ? $doc->get('title') : JText::_( 'COM_IPROPERTY_ALL_PROPERTIES' );
        $doc->setTitle(JText::_( 'COM_IPROPERTY_PROPERTY_RESULTS_FOR' ) . ': ' . html_entity_decode($pagetitle));
		$doc->link = JRoute::_(ipropertyHelperRoute::getAllPropertiesRoute());
        
        foreach ( $rows as $row )
		{			
			// strip html from feed item title
			$title = $row->street_address;
			$title = html_entity_decode( $title );
            $title = $title . ' - ' . $row->formattedprice;

			// load individual item creator class
			$item = new JFeedItem();
            $item->date         = $row->created;
			$item->title 		= $title;
			$item->link 		= $row->proplink;
			$item->description 	= ipropertyHTML::snippet($row->short_description) ;
            $item->author	    = "Intellectual Property - The Thinkery LLC";

			// loads item info into rss array
			$doc->addItem( $item );
		}
	}
}
