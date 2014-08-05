<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

echo '<div class="ip-slider-div">';
//see if user is logged in
if( !$this->user->id ){
    ?>
    <div align="center">
        <?php echo JHTML::_('image.site', 'iproperty1.png','/components/com_iproperty/assets/images/','','',JText::_( 'COM_IPROPERTY_PLEASE_LOG_IN' )); ?><br />
        <?php echo JText::_( 'COM_IPROPERTY_LOG_IN_TO_SAVE_FAVORITES' ); ?><br />
        <a href="<?php echo JRoute::_('index.php?option=com_users&view=login&return='.base64_encode(JURI::getInstance()->toString())); ?>"><?php echo JText::_( 'COM_IPROPERTY_PLEASE_LOG_IN' ); ?></a>
    </div>
    <?php
}else{
    ?>
    <form name="ipsaveProperty" action="<?php echo JRoute::_('index.php', true); ?>" method="post" class="ip_saveprop_form">
        <table width="100%" cellpadding="0" cellspacing="4">
            <tr>
                <td>
                    <table width="100%" cellpadding="10">
                        <tr>
                            <td colspan="2"><?php echo JText::_( 'COM_IPROPERTY_SAVE_PROPERTY_TO_FAVORITES_TEXT' ); ?></td>
                        </tr>
                        <tr>
                            <td align="right" width="30%" class="form_title"><?php echo JText::_( 'COM_IPROPERTY_NOTES' ); ?>:</td>
                            <td width="70%" class="form_input">
                                <input type="text" class="inputbox" name="notes" value="" size="40" maxlength="125" />
                            </td>
                        </tr>
                        <?php if($this->settings->show_propupdate): ?>
                        <tr>
                            <td align="right" width="30%" class="form_title"><?php echo JText::_( 'COM_IPROPERTY_EMAIL_UPDATES' ); ?>:</td>
                            <td width="70%" class="form_input">
                                <input type="checkbox" class="inputbox" name="email_update" value="1" checked="checked" />
                            </td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="form_input"><input type="submit" value="<?php echo JText::_( 'COM_IPROPERTY_SAVE_PROPERTY_TO_FAVORITES' ); ?>" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                   </table>
               </td>
           </tr>
        </table>
        <input type="hidden" name="task" value="ipuser.saveProperty" />
        <input type="hidden" name="option" value="com_iproperty" />
        <input type="hidden" name="view" value="property" />
        <input type="hidden" name="userid" value="<?php echo $this->user->id; ?>" />
        <input type="hidden" name="id" value="<?php echo $this->p->id; ?>" />
        <?php echo JHTML::_( 'form.token' ); ?>
    </form>
    <?php 
}//end logged in if
echo '</div>';
?>