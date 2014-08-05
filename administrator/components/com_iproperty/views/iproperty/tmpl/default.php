<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<table cellspacing="0" cellpadding="0" border="0" width="100%">
    <tr>
        <td valign="top" width="20%" class="ip_cpanel_toolbar">
            <?php ipropertyAdmin::buildAdminToolbar(); ?>
        </td>
        <td valign="top" width="80%" class="ip_cpanel_display">
            <?php
            echo JHtml::_('tabs.start', 'cpanel', array('useCookie' => false));
                echo JHtml::_('tabs.panel', JText::_('COM_IPROPERTY_THINKERY_NEWS'), 'news_panel');
                    echo $this->loadTemplate('news');
                echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_STATISTICS' ), 'stats_panel');
                    echo $this->loadTemplate('stats');
                echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_CHANGE_LOG' ), 'changelog_panel');
                    echo $this->loadTemplate('changelog');
                echo JHtml::_('tabs.panel', JText::_( 'COM_IPROPERTY_FAQ' ), 'faq_panel');
                    echo $this->loadTemplate('faq');
                $this->dispatcher->trigger( 'onAfterRenderAdminTabs', array( $this->user, $this->settings ) );
            echo JHtml::_('tabs.end');
            ?>
            <div class="clr"></div>
            <p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>
        </td>
    </tr>
</table>