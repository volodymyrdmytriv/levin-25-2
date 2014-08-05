<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.modal');

$user       = JFactory::getUser();
$userId     = $user->get('id');

$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$ordering   = ($listOrder == 'ordering');
$colspan    = 12;
?>

<script type="text/javascript">
    function resetForm(){
        document.id('filter_search').value='';
        document.id('filter_state').selectedIndex='';
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_iproperty&view=companies'); ?>" method="post" name="adminForm" id="adminForm">

    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
            <input type="text" name="filter_search" class="inputbox" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>" />
            <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="resetForm();this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>
        <div class="filter-select fltrt">
            <select name="filter_state" id="filter_state" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
                <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived'=>false, 'trash'=>false, 'all'=>false)), 'value', 'text', $this->state->get('filter.state'), true);?>
            </select>
        </div>
    </fieldset>
    <div class="clr"></div>

    <table class="adminlist" cellspacing="1">
        <thead>
            <tr>
                <th width="1%"><input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" /></th>
                <th width="3%"><?php echo JText::_( 'COM_IPROPERTY_IMAGE' ); ?></th>
                <th width="20%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_TITLE' ), 'c.name', $listDirn, $listOrder); ?></th>
                <th width="20%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_EMAIL' ), 'c.email', $listDirn, $listOrder); ?></th>
                <th width="15%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_PHONE' ), 'c.phone', $listDirn, $listOrder); ?></th>
                <th width="10%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_WEBSITE' ), 'c.website', $listDirn, $listOrder); ?></th>
                <th width="5%"><?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'state', $listDirn, $listOrder); ?></th>
                <th width="5%"><?php echo JHtml::_('grid.sort',  'COM_IPROPERTY_FEATURED', 'featured', $listDirn, $listOrder); ?></th>
                <th width="10%">
                    <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'ordering', $listDirn, $listOrder); ?>
                    <?php
                        if($this->ipauth->getAdmin()){
                            echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'companies.saveorder', $ordering);
                        }
                    ?>
                </th>
                <th width="5%" class="nowrap"><?php echo JHtml::_('grid.sort', 'COM_IPROPERTY_AGENTS', 'agent_count', $listDirn, $listOrder); ?></th>
                <th width="5%" class="nowrap"><?php echo JHtml::_('grid.sort', 'COM_IPROPERTY_PROPERTIES', 'prop_count', $listDirn, $listOrder); ?></th>
                <th width="1%" class="nowrap"><?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id', $listDirn, $listOrder); ?></th>
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
            if(count($this->items) > 0):
                foreach ($this->items as $i => $item) :
                    $canEdit        = $this->ipauth->canEditCompany($item->id) && !$item->checked_out;
                    $canPublish     = $this->ipauth->canPublishCompany($item->id) && !$item->checked_out;
                    $canFeature     = $this->ipauth->canFeatureCompany($item->id) && !$item->checked_out;
                    $canOrder       = $this->ipauth->getAdmin() && !$item->checked_out;
                    $canCheckin     = $user->authorise('core.manage',       'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                    $icon           = ipropertyHTML::getIconpath($item->icon, 'company');
                    ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td class="center">
                            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                        </td>
                        <td class="center"><?php echo ($item->icon) ? '<a href="'.$icon.'" class="modal"><img src="'.$icon.'" width="20" style="border: solid 1px #377391 !important;" /></a>' : '--'; ?>
                        <td>
                            <?php if ($item->checked_out) : ?>
                                <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'companies.', $canCheckin); ?>
                            <?php endif; ?>
                            <?php if ($canEdit) : ?>
                                <a href="<?php echo JRoute::_('index.php?option=com_iproperty&task=company.edit&id='.(int) $item->id); ?>">
                                    <?php echo $this->escape($item->name); ?>
                                </a>
                            <?php else : ?>
                                <?php echo $this->escape($item->name); ?>
                            <?php endif; ?>
                            <p class="smallsub">
                                <?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias));?></p>
                            <p class="smallsub">
                        </td>
                        <td align="left"><?php echo ($item->email) ? $item->email : '--'; ?>&nbsp;</td>
                        <td align="left"><?php echo ($item->phone) ? $item->phone : '--'; ?>&nbsp;</td>
                        <td align="left"><?php echo ($item->website) ? $item->website : '--'; ?>&nbsp;</td>
                        <?php if ($this->ipauth->getAdmin()): ?>
                            <td class="center">
                                <?php echo JHtml::_('jgrid.published', $item->state, $i, 'companies.', $canPublish, 'cb'); ?>
                            </td>
                            <td class="center">
                                <?php echo JHtml::_('ipadministrator.featured', $item->featured, $i, $canFeature, 'companies'); ?>
                            </td>
                            <td class="order">
                                <?php if ($canOrder) : ?>
                                    <?php if ($listDirn == 'asc') : ?>
                                        <span><?php echo $this->pagination->orderUpIcon($i, true, 'companies.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                        <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'companies.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                    <?php elseif ($listDirn == 'desc') : ?>
                                        <span><?php echo $this->pagination->orderUpIcon($i, true, 'companies.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                        <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'companies.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                    <?php endif; ?>
                                    <?php $disabled = $ordering ?  '' : ' disabled="disabled"'; ?>
                                    <input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>"<?php echo $disabled; ?> class="text-area-order" />
                                <?php else : ?>
                                    <?php echo $item->ordering; ?>
                                <?php endif; ?>
                            </td>
                        <?php else: ?>
                            <td colspan="3" align="center" class="ip_blockedout">--</td>
                        <?php endif; ?>
                        <td class="center">
                            <?php echo $item->agent_count; ?>
                        </td>
                        <td class="center">
                            <?php echo $item->prop_count; ?>
                        </td>
                        <td class="center">
                            <?php echo $item->id; ?>
                        </td>
                    </tr>
                <?php
                endforeach;
            else:
            ?>
                <tr>
                    <td colspan="<?php echo $colspan; ?>" class="center">
                        <?php echo JText::_('COM_IPROPERTY_NO_RESULTS'); ?>
                    </td>
                </tr>
            <?php
            endif;
            ?>
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
