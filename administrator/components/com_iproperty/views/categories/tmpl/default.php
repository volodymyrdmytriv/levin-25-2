<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
JHtml::_('behavior.tooltip');
JHtml::_('behavior.modal');
?>

<form action="<?php echo JRoute::_('index.php?option=com_iproperty&view=categories'); ?>" method="post" name="adminForm" id="adminForm">
    <fieldset id="filter-bar">
		<div class="filter-search fltlft">
            <label class="filter-search-lbl" for="catrecurse"><?php echo JText::_( 'COM_IPROPERTY_APPLY_TO_SUBTREE' ); ?>:&nbsp;</label>
            <input type="checkbox"<?php echo (JRequest::getInt('catrecurse', 0) == 1) ? ' checked="checked"' : ''; ?> value="1" name="catrecurse" />
        </div>
    </fieldset>
    <div class="clr"></div>
    
    <table class="adminlist" cellspacing="1">
        <thead>
            <tr>                
                <th width="1%">&nbsp;</th>
                <th width="5%"><?php echo JText::_( 'COM_IPROPERTY_IMAGE' ); ?></th>
                <th width="30%"><?php echo JText::_( 'JGLOBAL_TITLE' ); ?></th>
                <th width="40%"><?php echo JText::_( 'JGLOBAL_DESCRIPTION' ); ?></th>
                <th width="10%"><?php echo JText::_( 'JGRID_HEADING_ACCESS' ); ?></th>
                <th width="1%"><?php echo JText::_( 'JGRID_HEADING_ORDERING' ); ?></th>
                <th width="5%"><?php echo JText::_( 'COM_IPROPERTY_ENTRIES' ); ?></th>
                <th width="5%"><?php echo JText::_( 'JPUBLISHED' ); ?></th>
                <th width="1%"><?php echo JText::_( 'JGRID_HEADING_ID' ); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="9">
                    &nbsp;
                </td>
            </tr>
        </tfoot>
        <tbody>
            <?php
                $model          = $this->getModel('categories');
                $i              = 0;
                $parent         = 0;
                $spacer         = '';
                $published      = 1;
                $model->catLoop($i, $parent, $spacer, $published, $this->settings, $this->ipauth);
            ?>
        </tbody>
    </table>
	<input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
<p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>