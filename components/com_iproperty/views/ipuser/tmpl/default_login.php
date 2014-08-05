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

<div class="ip_mainheader">
	<h2><?php echo JText::_( 'COM_IPROPERTY_PLEASE_LOG_IN' ); ?></h2>
</div>

<table class="ptable">	
    <tr>
      <td colspan="2">
        <div class="property_header">
        <?php echo JText::_( 'COM_IPROPERTY_PLEASE_LOG_IN' ); ?>
        </div>
      </td>
    </tr>
    <tr>
       <td colspan="2" align="center">
        <div class="ip_loginform_wrapper">
        <div class="ip_loginform_container">
          <form action="<?php echo JRoute::_( 'index.php', true ); ?>" method="post" name="login" >
             <fieldset>
                <div class="login-fields">
                    <label for="modlgn_username"><?php echo JText::_( 'COM_IPROPERTY_USERNAME' ); ?><span class="star">&#160;*</span></label>
                    <input id="modlgn_username" type="text" name="username" class="inputbox required" />
                </div>
                <div class="login-fields">
                    <label for="modlgn_passwd"><?php echo JText::_( 'COM_IPROPERTY_PASSWORD' ); ?><span class="star">&#160;*</span></label>
                    <input id="modlgn_passwd" type="password" name="password" class="inputbox required" />
                </div>
                <div class="login-fields">
                    <label for="modlgn_remember"><?php echo JText::_( 'COM_IPROPERTY_REMEMBER_ME' ); ?></label>
                    <input id="modlgn_remember" type="checkbox" name="remember" class="inputbox" value="yes" alt="<?php echo JText::_( 'COM_IPROPERTY_REMEMBER_ME' ); ?>" />
                </div>
                <input type="submit" name="Submit" class="button" value="<?php echo JText::_( 'COM_IPROPERTY_LOG_IN' ); ?>" />
            </fieldset>
            <ul>
                <li>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>"><?php echo JText::_( 'COM_IPROPERTY_FORGOT_PASSWORD' ); ?></a>
                </li>
                <li>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>"><?php echo JText::_( 'COM_IPROPERTY_FORGOT_USERNAME' ); ?></a>
                </li>
                <?php if($this->allowreg): ?>
                <li>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>"><?php echo JText::_( 'COM_IPROPERTY_CREATE_ACCOUNT' ); ?></a>
                </li>
                <?php endif; ?>
            </ul>

            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="user.login" />
            <input type="hidden" name="return" value="<?php echo $this->return; ?>" />
            <?php echo JHTML::_( 'form.token' ); ?>
        </form>
        </div>
        </div>
       </td>
    </tr>    
</table>
<?php
    if( $this->settings->footer == 1):
        echo ipropertyHTML::buildThinkeryFooter();
    endif;
?>

