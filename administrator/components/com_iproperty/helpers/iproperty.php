<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

class IpropertyHelper
{
	public static function addSubmenu($vName)
	{
		$canDo              = IpropertyHelper::getActions();
        $portalinstall      = JPATH_COMPONENT.DS.'iportal.xml';
        $preserveinstall    = JPATH_COMPONENT.DS.'ipreserve.xml';

        JSubMenuHelper::addEntry(
            JText::_( 'COM_IPROPERTY_CONTROL_PANEL' ),
            'index.php?option=com_iproperty',
            $vName == 'iproperty'
        );

        JSubMenuHelper::addEntry(
            JText::_( 'COM_IPROPERTY_CATEGORIES' ),
            'index.php?option=com_iproperty&view=categories',
            $vName == 'categories'
        );

        JSubMenuHelper::addEntry(
            JText::_( 'COM_IPROPERTY_PROPERTIES' ),
            'index.php?option=com_iproperty&view=properties',
            $vName == 'properties'
        );

        JSubMenuHelper::addEntry(
            JText::_( 'COM_IPROPERTY_AGENTS' ),
            'index.php?option=com_iproperty&view=agents',
            $vName == 'agents'
        );

        JSubMenuHelper::addEntry(
            JText::_( 'COM_IPROPERTY_COMPANIES' ),
            'index.php?option=com_iproperty&view=companies',
            $vName == 'companies'
        );

        JSubMenuHelper::addEntry(
            JText::_( 'COM_IPROPERTY_AMENITIES' ),
            'index.php?option=com_iproperty&view=amenities',
            $vName == 'amenities'
        );

        JSubMenuHelper::addEntry(
            JText::_( 'COM_IPROPERTY_OPENHOUSES' ),
            'index.php?option=com_iproperty&view=openhouses',
            $vName == 'openhouses'
        );

        if($canDo->get('core.admin')){
            if(file_exists($portalinstall)){
                JSubMenuHelper::addEntry(
                    JText::_( 'COM_IPROPERTY_PORTAL' ),
                    'index.php?option=com_iproperty&view=plans',
                    ($vName == 'plans' || $vName == 'subscriptions' || $vName == 'payments' || $vName == 'users')
                );
            }

            if(file_exists($preserveinstall)){
                JSubMenuHelper::addEntry(
                    JText::_( 'COM_IPROPERTY_RESERVATIONS' ),
                    'index.php?option=com_iproperty&view=resreservations',
                    ($vName == 'resreservations' || $vName == 'resrates' || $vName == 'resstates' || $vName == 'respayments')
                );
            }
        }

        JSubMenuHelper::addEntry(
            JText::_( 'COM_IPROPERTY_SETTINGS' ),
            'index.php?option=com_iproperty&view=settings',
            $vName == 'settings'
        );

        if($canDo->get('core.admin')){
            if(file_exists($portalinstall)){
                if($vName == 'plans' || $vName == 'subscriptions' || $vName == 'payments' || $vName == 'users'){
                    $portclass  = ($vName == 'portal') ? 'active' : '';
                    $planclass  = ($vName == 'plans') ? 'active' : '';
                    $subclass   = ($vName == 'subscriptions') ? 'active' : '';
                    $ppayclass  = ($vName == 'payments') ? 'active' : '';
                    $userclass  = ($vName == 'users') ? 'active' : '';
                    echo '
                    <div id="ip_submenu">
                        <div id="submenu-box">
                            <div class="t">
                                <div class="t">
                                    <div class="t"></div>
                                </div>
                            </div>
                            <div class="m">
                                <ul id="submenu">
                                    <li><a href="index.php?option=com_iproperty&view=plans" class="'.$planclass.'">'.JText::_( 'COM_IPROPERTY_PLANS' ).'</a></li>
                                    <li><a href="index.php?option=com_iproperty&view=subscriptions" class="'.$subclass.'">'.JText::_( 'COM_IPROPERTY_SUBSCRIPTIONS' ).'</a></li>
                                    <li><a href="index.php?option=com_iproperty&view=payments" class="'.$ppayclass.'">'.JText::_( 'COM_IPROPERTY_PAYMENTS' ).'</a></li>
                                    <li><a href="index.php?option=com_iproperty&view=users" class="'.$userclass.'">'.JText::_( 'COM_IPROPERTY_USERS' ).'</a></li>
                                </ul>
                                <div class="clr"></div>
                            </div>
                            <div class="b">
                                <div class="b">
                                    <div class="b"></div>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }

            if(file_exists($preserveinstall)){
                if($vName == 'resreservations' || $vName == 'resrates' || $vName == 'resstates' || $vName == 'respayments'){
                    $resclass   = ($vName == 'resreservations') ? 'active' : '';
                    $rateclass  = ($vName == 'resrates') ? 'active' : '';
                    $payclass   = ($vName == 'respayments') ? 'active' : '';
                    $stateclass = ($vName == 'resstates') ? 'active' : '';
                    echo '
                    <div id="ip_submenu">
                        <div id="submenu-box">
                            <div class="t">
                                <div class="t">
                                    <div class="t"></div>
                                </div>
                            </div>
                            <div class="m">
                                <ul id="submenu">
                                    <li><a href="index.php?option=com_iproperty&view=resreservations" class="'.$resclass.'">'.JText::_( 'COM_IPROPERTY_RESERVATIONS' ).'</a></li>
                                    <li><a href="index.php?option=com_iproperty&view=resrates" class="'.$rateclass.'">'.JText::_( 'COM_IPROPERTY_RES_RATES' ).'</a></li>
                                    <li><a href="index.php?option=com_iproperty&view=respayments" class="'.$payclass.'">'.JText::_( 'COM_IPROPERTY_RES_PAYMENTS' ).'</a></li>
                                    <li><a href="index.php?option=com_iproperty&view=resstates" class="'.$stateclass.'">'.JText::_( 'COM_IPROPERTY_RES_STATES' ).'</a></li>
                                </ul>
                                <div class="clr"></div>
                            </div>
                            <div class="b">
                                <div class="b">
                                    <div class="b"></div>
                                </div>
                            </div>
                        </div>
                    </div>';
                }
            }
        }
	}

    public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$actions = array('core.admin', 'core.manage');

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, 'com_iproperty'));
		}

		return $result;
	}
}