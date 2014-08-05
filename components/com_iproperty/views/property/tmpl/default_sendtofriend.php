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

<div align="center" class="ip_sfform_wrapper">
    <form name="sendTofriend" method="post" action="<?php echo JRoute::_( 'index.php', true ); ?>" id="ipStfForm" onsubmit="return formValidate(document.id('ipStfForm'))">
        <table width="80%" cellpadding="2" cellspacing="0" class="ip_form_table">
            <tr>
                <td width="30%" align="right"><?php echo JText::_( 'COM_IPROPERTY_YOUR_NAME' ); ?>:</td>
                <td width="70%" align="left"><input class="inputbox contactbox required" name="sender_name" value="<?php echo $this->session->get('ip_sender_name'); ?>" /> *</td>
            </tr>
            <tr>
                <td align="right"><?php echo JText::_( 'COM_IPROPERTY_YOUR_EMAIL' ); ?>:</td>
                <td align="left"><input class="inputbox contactbox required" name="sender_email" value="<?php echo $this->session->get('ip_sender_email'); ?>" /> *</td>
            </tr>
            <tr>
                <td align="right" valign="top"><?php echo JText::_( 'COM_IPROPERTY_FRIENDS_EMAILS' ); ?>:</td>
                <td align="left" valign="top">
                    <input class="inputbox contactbox required" name="recipient_email" value="<?php echo $this->session->get('ip_sender_recipient_email'); ?>" /> *<br />
                    <span class="ip_smallspan"><?php echo JText::_( 'COM_IPROPERTY_ENTER_MULTIPLE_EMAILS' ); ?></span>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><?php echo JText::_( 'COM_IPROPERTY_COMMENTS' ); ?>:</td>
                <td align="left">
                    <textarea class="inputbox contactbox" name="comments" rows="5" cols="40" onkeydown="limitText(this.form.comments,this.form.countdown,300);" onkeyup="limitText(this.form.comments,this.form.countdown,300);"><?php echo $this->session->get('ip_sender_comments'); ?></textarea><br />
                    <font size="1">(<?php echo JText::_( 'COM_IPROPERTY_MAX_CHARS' ); ?>: 300)<br />
                    <?php echo JText::_( 'COM_IPROPERTY_YOU_HAVE' ); ?> <input readonly="readonly" type="text" class="inputbox" name="countdown" size="3" value="300" /> <?php echo JText::_( 'COM_IPROPERTY_CHARS_LEFT' ); ?>.
                    </font>
                </td>
            </tr>
            <?php $this->dispatcher->trigger( 'onDisplayIpCaptcha', array( 'stf' )); ?>
            <tr>
                <td align="right">&nbsp;</td>
                <td align="left" valign="top"><input type="submit" class="button" alt="<?php echo JText::_( 'COM_IPROPERTY_SUBMIT_SEND' ); ?>" title="<?php echo JText::_( 'COM_IPROPERTY_SUBMIT_SEND' ); ?>" value="<?php echo JText::_( 'COM_IPROPERTY_SUBMIT_SEND' ); ?>" /></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
        </table>
        <input type="hidden" name="option" value="com_iproperty" />
        <input type="hidden" name="view" value="property" />
        <input type="hidden" name="id" value="<?php echo $this->p->id; ?>" />
        <input type="hidden" name="task" value="property.sendTofriend" />
        <input type="hidden" name="layout" value="default" />
        <?php echo JHTML::_( 'form.token' ); ?>
    </form>
</div>