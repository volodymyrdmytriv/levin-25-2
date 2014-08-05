<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
jimport( 'joomla.plugin.plugin');

class plgIpropertyIpAdminTools extends JPlugin
{
	function plgIpropertyIpAdminTools(&$subject, $config)  
    {
		parent::__construct($subject, $config);
        $this->loadLanguage();
	}

	function onAfterRenderAdminTabs($user, $settings)
	{
        $app = JFactory::getApplication();
        $dispatcher = JDispatcher::getInstance();
		if($app->getName() != 'administrator') return true;
        if(!$user->authorise('core.admin')) return true;

        echo JHtml::_('tabs.panel', JText::_($this->params->get('tabtitle', 'PLG_IP_TOOLS_TOOLS')), 'iptools_tab');
        ?>
            <div class="ip_spacer"></div>
            <h1 class="ip_cpanel_header"><?php echo $this->params->get('tabtitle', JText::_('PLG_IP_TOOLS_TOOLS')); ?></h1>
            <div class="tnews_content">
            <table class="adminlist" cellspacing="1">
                <thead>
                    <tr>
                        <th width="100%"><?php echo JText::_( 'PLG_IP_TOOLS_TOOLS' ); ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                </tfoot>
                <tbody>
                    <tr class="row0">
                        <td>
                            <div id="cpanel">
                                <?php $dispatcher->trigger( 'onAfterRenderTools', array( $user, $settings ) ); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            </div>
        <?php
	}
}
