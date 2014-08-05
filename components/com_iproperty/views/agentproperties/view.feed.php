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

class IpropertyViewAgentProperties extends JView
{
	function display()
	{
		$app  = JFactory::getApplication();

		// Initialize some variables
        $settings = ipropertyAdmin::config();
		JRequest::setVar('limitstart', 0);
		JRequest::setVar('limit', $settings->rss);

		$model   = $this->getModel();
		$rows 	 = $this->get( 'data' );
        $agent   = $this->get( 'agent' );
		$doc     = JFactory::getDocument();
        $id      = JRequest::getVar('id', 0, '', 'int');

		$doc->setTitle(JText::_( 'COM_IPROPERTY_PROPERTIES_HANDLED_BY' ).' '.ipropertyHTML::getAgentName($agent->id));
        $doc->link = JRoute::_(ipropertyHelperRoute::getAgentPropertyRoute($agent->id.':'.$agent->alias));
        
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
			$item->category   	= $row->typename;

			// loads item info into rss array
			$doc->addItem( $item );
		}
	}
}
