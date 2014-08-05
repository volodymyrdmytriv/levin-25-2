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
$colspan    = ($this->ipauth->getAdmin()) ? '13' : '12';
?>

<script type="text/javascript">
    function resetForm(){
        document.id('filter_search').value='';
        document.id('filter_company_id').selectedIndex='';
        document.id('filter_state').selectedIndex='';
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_iproperty&view=agents'); ?>" method="post" name="adminForm" id="adminForm">
    <fieldset id="filter-bar">
        <div class="filter-search fltlft">
            <label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
            <input type="text" name="filter_search" class="inputbox" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>" />
            <button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
            <button type="button" onclick="resetForm();this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
        </div>
        <div class="filter-select fltrt">
            <select name="filter_company_id" id="filter_company_id" class="inputbox" onchange="this.form.submit()">
                <?php echo JHtml::_('select.options', JFormFieldCompany::getOptions(true), 'value', 'text', $this->state->get('filter.company_id'));?>
            </select>
            <select name="filter_state" id="filter_state" class="inputbox" onchange="this.form.submit()">
                <option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
                <?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived'=>false, 'trash'=>false, 'all'=>false)), 'value', 'text', $this->state->get('filter.state'), true);?>
            </select>
        </div>
    </fieldset>
    <div class="clr"></div>

    <table class="adminlist">
        <thead>
            <tr>
                <th width="1%"><input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" /></th>
                <th width="3%"><?php echo JText::_('COM_IPROPERTY_IMAGE'); ?></th>
                <th width="20%"><?php echo JHtml::_('grid.sort',  'COM_IPROPERTY_LNAME', 'lname', $listDirn, $listOrder); ?> / <?php echo JHtml::_('grid.sort',  'COM_IPROPERTY_FNAME', 'fname', $listDirn, $listOrder); ?></th>
                <th width="10%"><?php echo JHTML::_('grid.sort',  'COM_IPROPERTY_USER', 'user_name', $listDirn, $listOrder ); ?></th>
                <th width="10%"><?php echo JHtml::_('grid.sort',  'COM_IPROPERTY_COMPANY', 'company', $listDirn, $listOrder); ?></th>
                <th width="10%"><?php echo JHtml::_('grid.sort',  'COM_IPROPERTY_EMAIL', 'email', $listDirn, $listOrder); ?></th>
                <th width="10%"><?php echo JHtml::_('grid.sort',  'COM_IPROPERTY_PHONE', 'phone', $listDirn, $listOrder); ?></th>
                <th width="10%"><?php echo JHtml::_('grid.sort',  'COM_IPROPERTY_PROPERTIES', 'prop_count', $listDirn, $listOrder); ?></th>
                <th width="5%"><?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'state', $listDirn, $listOrder); ?></th>
                <th width="5%"><?php echo JHtml::_('grid.sort',  'COM_IPROPERTY_FEATURED', 'featured', $listDirn, $listOrder); ?></th>
                <?php if ($this->ipauth->getAdmin()): //admin can set super agent ?>
                    <th width="5%"><?php echo JHTML::_('grid.sort', 'COM_IPROPERTY_SUPER', 'agent_type', $listDirn, $listOrder ); ?></th>
                <?php endif; ?>
                <th width="10%">
                    <?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'ordering', $listDirn, $listOrder); ?>
                    <?php
                        if($this->ipauth->getAdmin() || $this->ipauth->getSuper()){
                            echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'agents.saveorder', $ordering);
                        }
                    ?>
                </th>
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
                    $canEdit        = $this->ipauth->canEditAgent($item->id) && !$item->checked_out;
                    $canPublish     = $this->ipauth->canPublishAgent($item->id, ($item->state == 1) ? 0 : 1) && !$item->checked_out;
                    $canFeature     = $this->ipauth->canFeatureAgent($item->id, ($item->featured == 1) ? 0 : 1) && !$item->checked_out;
                    $canSuper       = $this->ipauth->getAdmin() && !$item->checked_out;
                    $canOrder       = ($this->ipauth->getAdmin() || $this->ipauth->getSuper()) && !$item->checked_out;
                    $canCheckin     = $user->authorise('core.manage',       'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                    $icon           = ipropertyHTML::getIconpath($item->icon, 'agent');
                    ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td class="center">
                            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                        </td>
                        <td class="center"><?php echo ($item->icon) ? '<a href="'.$icon.'" class="modal"><img src="'.$icon.'" width="20" style="border: solid 1px #377391 !important;" /></a>' : '--'; ?>
                        <td>
                            <?php if ($item->checked_out) : ?>
                                <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'agents.', $canCheckin); ?>
                            <?php endif; ?>
                            <?php if ($canEdit) : ?>
                                <a href="<?php echo JRoute::_('index.php?option=com_iproperty&task=agent.edit&id='.(int) $item->id); ?>">
                                    <?php echo $this->escape($item->lname); ?>
                                </a>
                            <?php else : ?>
                                <?php echo $this->escape($item->lname); ?>
                            <?php endif; ?>
                            <?php echo ($item->fname) ? ', '.$this->escape($item->fname) : '--'; ?>
                            <p class="smallsub">
                                <?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias));?></p>
                            <p class="smallsub">
                        </td>
                        <td><?php echo ($item->user_name) ? '<a href="'.JRoute::_('index.php?option=com_users&task=user.edit&id='.(int)$item->user_id).'" target="_blank" class="hasTip" title="'.$item->user_name.'::ID: '.$item->user_id.'<br />'.JText::_('JGLOBAL_USERNAME').': '.$item->user_username.'" >'.$item->user_name.'</a>' : '--'; ?></td>
                        <td><?php echo ($item->company_title) ? $this->escape($item->company_title) : '--'; ?></td>
                        <td class="center"><?php echo ($item->email) ? $item->email : '--'; ?></td>
                        <td class="center"><?php echo ($item->phone && $item->phone != ' ') ? $item->phone : '--'; ?></td>
                        <td class="center"><?php echo ($item->prop_count) ? $item->prop_count : '--'; ?></td>
                        <?php if ($this->ipauth->getAdmin() || $this->ipauth->getSuper()): ?>
                            <td class="center">
                                <?php echo JHtml::_('jgrid.published', $item->state, $i, 'agents.', $canPublish, 'cb'); ?>
                            </td>
                            <td class="center">
                                <?php echo JHtml::_('ipadministrator.featured', $item->featured, $i, $canFeature, 'agents'); ?>
                            </td>
                            <?php if ($this->ipauth->getAdmin()): //admin can set super agent ?>
                                <td align="center">
                                    <?php echo JHtml::_('ipadministrator.super', $item->agent_type, $i, $canSuper, 'agents'); ?>
                                </td>
                            <?php endif; ?>
                            <td class="order">
                                <?php if ($canOrder) : ?>
                                    <?php if ($listDirn == 'asc') : ?>
                                        <span><?php echo $this->pagination->orderUpIcon($i, (@$this->items[$i-1]->company == $item->company), 'agents.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                        <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, (@$this->items[$i+1]->company == $item->company), 'agents.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                    <?php elseif ($listDirn == 'desc') : ?>
                                        <span><?php echo $this->pagination->orderUpIcon($i, (@$this->items[$i-1]->company == $item->company), 'agents.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                        <span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, (@$this->items[$i+1]->company == $item->company), 'agents.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
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
