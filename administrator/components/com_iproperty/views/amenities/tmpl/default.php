<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$colspan    = 6;
?>

<form action="<?php echo JRoute::_('index.php?option=com_iproperty&view=amenities'); ?>" method="post" name="adminForm" id="adminForm">
    <fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" class="inputbox" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';document.id('filter_cat_id').selectedIndex='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
        <div class="filter-select fltrt">
			<select name="filter_cat_id" id="filter_cat_id" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', JFormFieldAmenityCat::getOptions(true), 'value', 'text', $this->state->get('filter.cat_id'));?>
			</select>
		</div>
	</fieldset>
	<div class="clr"></div>

    <table class="adminlist" cellspacing="1">
        <thead>
            <tr>                
                <th width="1%"><input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" /></th>
                <th width="25%"><?php echo JHtml::_('grid.sort',  'COM_IPROPERTY_TITLE', 'title', $listDirn, $listOrder); ?></th>
                <th width="24%"><?php echo JHtml::_('grid.sort',  'COM_IPROPERTY_CATEGORY', 'cat', $listDirn, $listOrder); ?></th>
                <th width="1%">&nbsp;</th>
                <th width="25%"><?php echo JHtml::_('grid.sort',  'COM_IPROPERTY_TITLE', 'title', $listDirn, $listOrder); ?></th>
                <th width="24%"><?php echo JHtml::_('grid.sort',  'COM_IPROPERTY_CATEGORY', 'cat', $listDirn, $listOrder); ?></th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <td colspan="<?php echo $colspan; ?>">
                    <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
        
        <tbody>
            <?php
            $amenity_cats = array(0 => JText::_('COM_IPROPERTY_GENERAL_AMENITIES'), 1 => JText::_('COM_IPROPERTY_INTERIOR_AMENITIES'), 2 => JText::_('COM_IPROPERTY_EXTERIOR_AMENITIES'));
            if(count($this->items) > 0):
                echo '<tr>
                        <td colspan="3" style="border-right: solid 1px #d6d6d6;" width="50%" valign="top">
                            <table width="100%">';  
                                $x = 0;
                                foreach ($this->items as $i => $item) : ?>
                                    <tr class="row<?php echo $i % 2; ?>">
                                        <td width="1%"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
                                        <td width="25%" align="left">
                                            <a href="<?php echo JRoute::_('index.php?option=com_iproperty&task=amenity.edit&id='.(int) $item->id); ?>"><?php echo $item->title; ?></a>
                                        </td>
                                        <td width="24%" class="center">
                                            <select name="amen_cat_<?php echo $item->id; ?>" class="inputbox" onchange="document.getElementById('cb<?php echo $i; ?>').checked = true;">
                                                <?php echo JHtml::_('select.options', JFormFieldAmenityCat::getOptions(), 'value', 'text', $item->cat);?>
                                            </select>                            
                                        </td>
                                    </tr>
                                    <?php 
                                    $x++;
                                    if($x == 10 && $x != count($this->items)){
                                        echo '</table>
                                            </td>
                                            <td colspan="3" width="50%" valign="top">
                                                <table width="100%">';
                                    }
                                endforeach;
                    echo '</table>
                        </td>
                    </tr>';
            else:
            ?>
                <tr>
                    <td colspan="<?php echo $colspan; ?>" class="center">
                        <?php echo JText::_('COM_IPROPERTY_NO_RESULTS'); ?>
                    </td>
                </tr>
            <?php
            endif; ?>
        </tbody>

    </table>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
    <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
    <?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
<p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>