<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.modal');

$user		= JFactory::getUser();
$userId		= $user->get('id');

$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$colspan    = 9;
?>

<script type="text/javascript">
    function resetForm(){
        document.id('filter_search').value='';
        document.id('filter_company_id').selectedIndex='';
        document.id('filter_state').selectedIndex='';
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_iproperty&view=openhouses'); ?>" method="post" name="adminForm" id="adminForm">
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
                <th width="25%" class="title"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_NAME' ), 'o.name', $listDirn, $listOrder ); ?> / <?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_STREET' ), 'p.street', $listDirn, $listOrder ); ?> / <?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_TITLE' ), 'p.title', $listDirn, $listOrder ); ?></th>
                <th width="10%" class="title"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_REF' ), 'p.mls_id', $listDirn, $listOrder ); ?></th>
                <th width="15%" class="title"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_START' ), 'o.openhouse_start', $listDirn, $listOrder ); ?></th>
                <th width="15%" class="title"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_END' ), 'o.openhouse_end', $listDirn, $listOrder ); ?></th>
                <th width="15%" class="title"><?php echo JText::_( 'COM_IPROPERTY_AGENT' ); ?></th>
                <th width="15%" class="title"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_COMPANY' ), 'company', $listDirn, $listOrder ); ?></th>
                <th width="1%" nowrap="nowrap"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_PUBLISHED' ), 'o.state', $listDirn, $listOrder ); ?></th>
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

        <?php 
            if(count($this->items) > 0):
                foreach ($this->items as $i => $item) :
                    $canEdit        = !$item->checked_out;
                    $canPublish     = !$item->checked_out;
                    $canCheckin     = $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                    $expired        = ($item->openhouse_end && ($item->openhouse_end <= date('Y-m-d H:i:s'))) ? true : false;
                    ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td class="center">
                            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                        </td>
                        <td>
                            <?php if ($item->checked_out) : ?>
                                <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'openhouses.', $canCheckin); ?>
                            <?php endif; ?>
                            <?php 
                                if($item->ohname) echo '<em>'.$this->escape($item->ohname).'</em><br />';
                                if ($canEdit){
                                    echo '<a href="'.JRoute::_('index.php?option=com_iproperty&task=openhouse.edit&id='.(int) $item->id).'">
                                            '.$this->escape($item->street_address).'
                                          </a>';
                                }else{ 
                                    echo $this->escape($item->street_address);                                   
                                }
                                if($item->title) echo '<br />'.$this->escape($item->title);
                            ?>
                        </td>
                        <td align="center"><?php echo ($item->mls_id) ? $item->mls_id : '--'; ?></td>
                        <td align="center"><?php echo ($item->openhouse_start) ? $item->openhouse_start : '--'; ?></td>
                        <td align="center"><?php echo ($item->openhouse_end) ? (($expired) ? '<span class="invalid">'.$item->openhouse_end.'</span>' : $item->openhouse_end ) : '--'; ?></td>
                        <td>
                            <?php
                                $agents = ipropertyHTML::getAvailableAgents($item->prop_id);
                                $x = 0;
                                if($agents){
                                    foreach($agents AS $a){
                                        echo ipropertyHTML::getAgentName($a->id);
                                        $x++;
                                        if($x < count($agents)) echo '<br />';
                                    }
                                }else{
                                    echo '--';
                                }
                            ?>
                        </td>
                        <td><?php echo ipropertyHTML::getCompanyName($item->company); ?></td>
                        <td class="center">
                            <?php echo JHtml::_('jgrid.published', $item->state, $i, 'openhouses.', $canPublish, 'cb'); ?>
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