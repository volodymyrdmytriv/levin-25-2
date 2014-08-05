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

<div align="center" class="ip_cform_wrapper">
<form name="contactForm" method="post" action="<?php echo JRoute::_( 'index.php', true ); ?>" id="ipCform" onsubmit="return formValidate(document.id('ipCform'))">
    <table width="40%" align="left" cellpadding="2" cellspacing="0" class="ip_form_table">
        <tr>
          <td width="70%" align="left"><?php echo JText::_( 'COM_IPROPERTY_YOUR_NAME' ); ?>:<br><input name="sender_name" class="inputbox contactbox required" id="ip_sendername" value="<?php echo JRequest::getVar('sender_name'); ?>" size="30" /></td>
        </tr>
        <tr>
            <td align="left"><?php echo JText::_( 'COM_IPROPERTY_YOUR_EMAIL' ); ?>:<br><input name="sender_email" class="inputbox contactbox required" value="<?php echo JRequest::getVar('sender_email'); ?>" size="30" /></td>
        </tr>        
        <tr>
            <td align="left"><?php echo JText::_( 'COM_IPROPERTY_DAY_PHONE' ); ?>:<br><input name="sender_dphone" class="inputbox contactbox" value="<?php echo JRequest::getVar('sender_dphone'); ?>" size="30" /></td>
        </tr>
        <tr>
            <td align="left"><?php echo JText::_( 'COM_IPROPERTY_EVENING_PHONE' ); ?>:<br><input name="sender_ephone" class="inputbox contactbox" value="<?php echo JRequest::getVar('sender_ephone'); ?>" size="30" /></td>
        </tr>        
        <!--<tr>
            <td align="right"><?php echo JText::_( 'COM_IPROPERTY_CONTACT_PREFERENCE' ); ?>:</td>
            <td align="left"><?php echo $this->lists['preference']; ?> *</td>
        </tr>-->
        <tr>
            <td align="left"><?php echo JText::_( 'COM_IPROPERTY_SPECIAL_REQUESTS' ); ?>:<br>
                <textarea class="inputbox contactbox" name="special_requests" rows="5" cols="60" onkeydown="limitText(this.form.special_requests,this.form.countdown,300);" onkeyup="limitText(this.form.special_requests,this.form.countdown,300);"><?php echo JRequest::getVar('special_requests'); ?></textarea><br />
                <font size="1">(<?php echo JText::_( 'COM_IPROPERTY_MAX_CHARS' ); ?>: 300)<br />
                <?php echo JText::_( 'COM_IPROPERTY_YOU_HAVE' ); ?> <br><input readonly type="text" class="inputbox" name="countdown" size="3" value="300" /> <?php echo JText::_( 'COM_IPROPERTY_CHARS_LEFT' ); ?>.
                </font>
          </td>
        </tr>
        <?php $this->dispatcher->trigger( 'onDisplayIpCaptcha', array( 'contact' )); ?>
        <tr>
            <td align="left"><?php echo $this->lists['copyme']; ?></td>
        </tr>
        <tr>
            <td align="left" valign="top"><input type="submit" class="button" alt="<?php echo JText::_( 'COM_IPROPERTY_SUBMIT_FORM' ); ?>" title="<?php echo JText::_( 'COM_IPROPERTY_SUBMIT_FORM' ); ?>" value="<?php echo JText::_( 'COM_IPROPERTY_SUBMIT_FORM' ); ?>" /></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
    </table>
    <input type="hidden" name="option" value="com_iproperty" />
    <input type="hidden" name="view" value="contact" />
    <input type="hidden" name="id" value="<?php echo JRequest::getInt('id'); ?>" />
    <input type="hidden" name="task" value="contact.contactForm" />
    <input type="hidden" name="ctype" value="<?php echo $this->ctype; ?>" />
    <?php echo JHTML::_( 'form.token' ); ?>
</form>
</div>