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

<div class="width-100 fltlft">
    <form method="post" action="<?php echo JRoute::_('index.php?option=com_iproperty'); ?>" enctype="multipart/form-data" name="adminForm" id="adminForm">
        <fieldset class="adminform">
        <legend><?php echo JText::_( 'COM_IPROPERTY_SELECT_IMAGE_UPLOAD' ); ?></legend>
            <ul class="adminformlist">
                <li><input class="inputbox" name="userfile" id="userfile" type="file" /></li>
                <li><input class="button" type="submit" value="<?php echo JText::_( 'COM_IPROPERTY_UPLOAD' ) ?>" name="adminForm" /></li>
            </ul>
        </fieldset>

        <fieldset class="adminform">
        <legend><?php echo JText::_( 'COM_IPROPERTY_DETAILS' ); ?></legend>
            <ul class="adminformlist">
                <li><label><?php echo JText::_( 'COM_IPROPERTY_TARGET_DIRECTORY' ).':'; ?></label>
                    <fieldset class="radio inputbox">
                        <span class="ipblue">
                        <?php
                        switch($this->task){
                            case 'companiesimg':
                                echo "/media/com_iproperty/companies/";
                                $this->task = 'companiesimgup';
                            break;

                            case 'agentsimg':
                                echo "/media/com_iproperty/agents/";
                                $this->task = 'agentsimgup';
                            break;

                            case 'categoriesimg':
                                echo "/media/com_iproperty/categories/";
                                $this->task = 'categoriesimgup';
                            break;
                        }
                        ?>
                        </span>
                    </fieldset>
                </li>
                <li><label><?php echo JText::_( 'COM_IPROPERTY_IMAGE_FILESIZE' ).':'; ?></label>
                    <fieldset class="radio inputbox"><b><span class="ipblue"><?php echo $this->settings->maximgsize; ?> kb</span></b></fieldset>
                </li>
            </ul>
        </fieldset>
        <?php echo JHTML::_( 'form.token' ); ?>
        <input type="hidden" name="task" value="iconuploader.<?php echo $this->task; ?>" />
    </form>
</div>    
<div class="clr"></div>
<p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>