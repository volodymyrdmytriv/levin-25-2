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

$user		= JFactory::getUser();
$userId		= $user->get('id');

// build approve options
$aoptions = array();
$aoptions[] = JHtml::_('select.option', '1', 'COM_IPROPERTY_APPROVED');
$aoptions[] = JHtml::_('select.option', '0', 'COM_IPROPERTY_UNAPPROVED');

$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$ordering   = ($listOrder == 'ordering');
$colspan    = ($this->settings->edit_rights) ? 17 : 16;
?>

<script type="text/javascript">
    function resetForm(){
        document.id('filter_search').value='';
        document.id('filter_company_id').selectedIndex='';
        document.id('filter_stype').selectedIndex='';
        document.id('filter_city').selectedIndex='';
        document.id('filter_cat_id').selectedIndex='';
        document.id('filter_agent_id').selectedIndex='';
        document.id('filter_beds').selectedIndex='';
        document.id('filter_baths').selectedIndex='';
        document.id('filter_state').selectedIndex='';
        document.id('filter_approved').selectedIndex='';
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_iproperty&view=properties'); ?>" method="post" name="adminForm" id="adminForm">
    <fieldset id="filter-bar" style="height: auto;">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" class="inputbox" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="resetForm();this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
        <div class="filter-select fltrt">
            <select name="filter_beds" id="filter_beds" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', JFormFieldBeds::getOptions(), 'value', 'text', $this->state->get('filter.beds'));?>                
			</select>
            <select name="filter_baths" id="filter_baths" class="inputbox" onchange="this.form.submit()">
                <?php echo JHtml::_('select.options', JFormFieldBaths::getOptions(false), 'value', 'text', $this->state->get('filter.baths'));?>                
			</select>
            <select name="filter_state" id="filter_state" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived'=>false, 'trash'=>false, 'all'=>false)), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>
            <select name="filter_approved" id="filter_approved" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JSELECT');?></option>
                <?php echo JHtml::_('select.options', $aoptions, 'value', 'text', $this->state->get('filter.approved'), true);?>
			</select>
		</div>
        <div class="clear"></div>
		<div class="filter-select fltrt">
			<select name="filter_cat_id" id="filter_cat_id" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', JFormFieldCategory::getOptions(), 'value', 'text', $this->state->get('filter.cat_id'));?>                
			</select>
            <select name="filter_company_id" id="filter_company_id" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', JFormFieldCompany::getOptions(true), 'value', 'text', $this->state->get('filter.company_id'));?>                
			</select>
            <select name="filter_agent_id" id="filter_agent_id" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', JFormFieldAgent::getOptions(true), 'value', 'text', $this->state->get('filter.agent_id'));?>                
			</select>
            <select name="filter_stype" id="filter_stype" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', JFormFieldStypes::getOptions(true), 'value', 'text', $this->state->get('filter.stype'));?>                
			</select>
            <select name="filter_city" id="filter_city" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', JFormFieldCity::getOptions(), 'value', 'text', $this->state->get('filter.city'));?>                
			</select>           
        </div>        
	</fieldset>
    <div class="clr"></div>

    <table class="adminlist" cellspacing="1">
        <thead>
            <tr>
                <th width="1%"><input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" /></th>
                <th width="5%"><?php echo JText::_( 'COM_IPROPERTY_IMAGE' ); ?></th>
                <th width="5%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_REF' ), 'mls_id', $listDirn, $listOrder ); ?></th>
                <th width="30%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_STREET' ), 'street', $listDirn, $listOrder ); ?> / <?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_TITLE' ), 'title', $listDirn, $listOrder ); ?></th>
                <th width="10%"><?php echo JText::_( 'COM_IPROPERTY_AGENTS' ); ?></th>
                <th width="10%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_LOCATION' ), 'city', $listDirn, $listOrder ); ?></th>
                <th width="2%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_BEDS' ), 'beds', $listDirn, $listOrder ); ?></th>
                <th width="2%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_BATHS' ), 'baths', $listDirn, $listOrder ); ?></th>
                <th width="2%"><?php echo JHTML::_('grid.sort', (!$this->settings->measurement_units) ? JText::_( 'COM_IPROPERTY_SQFT' ) : JText::_( 'COM_IPROPERTY_SQM' ), 'sqft', $listDirn, $listOrder ); ?></th>
                <th width="5%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_PRICE' ), 'price', $listDirn, $listOrder ); ?></th>
                <th width="5%"><?php echo JText::_( 'COM_IPROPERTY_CATEGORIES' ); ?></th>
                <th width="5%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_HITS' ), 'hits', $listDirn, $listOrder ); ?></th>
                <th width="5%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_ACCESS' ), 'access', $listDirn, $listOrder ); ?></th>
                <?php if($this->settings->edit_rights): ?>
                    <th width="1%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_APPROVED' ), 'approved', $listDirn, $listOrder ); ?></th>
                <?php endif; ?>
                <th width="5%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_PUBLISHED' ), 'state', $listDirn, $listOrder ); ?></th>
                <th width="5%"><?php echo JHTML::_('grid.sort', JText::_( 'COM_IPROPERTY_HOT' ), 'featured', $listDirn, $listOrder ); ?></th>                
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
                    $canEdit        = $this->ipauth->canEditProp($item->id) && !$item->checked_out;
                    $canPublish     = $this->ipauth->canPublishProp($item->id, ($item->state == 1) ? 0 : 1) && !$item->checked_out;
                    $canFeature     = $this->ipauth->canFeatureProp($item->id, ($item->featured == 1) ? 0 : 1) && !$item->checked_out;
                    $canOrder       = ($this->ipauth->getAdmin() || $this->ipauth->getSuper()) && !$item->checked_out;
                    $canCheckin     = $user->authorise('core.manage',		'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                    ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td class="center">
                            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                        </td>
                        <td class="center"><?php echo ipropertyHTML::getThumbnail($item->id, '', $item->street_address, 50); ?></td>
                        <td class="center"><?php echo ($item->mls_id) ? $item->mls_id : '--'; ?></td>
                        <td>
                            <?php if ($item->checked_out) : ?>
                                <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'properties.', $canCheckin); ?>
                            <?php endif; ?>
                            <?php if ($canEdit) : ?>
                                <a href="<?php echo JRoute::_('index.php?option=com_iproperty&task=property.edit&id='.(int) $item->id); ?>">
                                    <?php echo $this->escape($item->street_address); ?>
                                </a>
                            <?php else : ?>
                                <?php echo $this->escape($item->street_address); ?>
                            <?php endif; ?>
                            <?php
                                if($item->agent_notes) echo ' <span class="editlinktip hasTip" title="'.JText::_( 'COM_IPROPERTY_AGENT_NOTES' ).'::'.nl2br($item->agent_notes).'">'.JHtml::_('image.administrator','notes.gif','/components/com_iproperty/assets/images/','','',JText::_('COM_IPROPERTY_AGENT_NOTES')).'</span>';
                                if($item->title) echo '<p class="smallsub">'.$item->title.'</p>'; 
                            ?>
                            <p class="smallsub">
                                <?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias));?></p>
                            <p class="smallsub">
                        </td>
                        <td>
                            <?php
                                $agents = ipropertyHTML::getAvailableAgents($item->id);
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
                        <td>
                            <?php
                            $location = '';
                            if($item->city) $location .= $item->city;
                            if($item->locstate) $location .= ', '.ipropertyHTML::getstatename($item->locstate);
                            if($item->province) $location .= ', '.$item->province;
                            echo ($location) ? $location : '--';
                            ?>
                        </td>
                        <td class="center">
                            <?php
                                if(($item->beds < $this->settings->adv_beds_low) || ($item->beds > $this->settings->adv_beds_high)){
                                    echo '<span class="hasTip invalid" title="'.JText::_( 'COM_IPROPERTY_BEDS' ).' :: '.JText::_( 'COM_IPROPERTY_BEDS' ).'">'.$item->beds.'</span>';
                                }else{
                                    echo $item->beds;
                                }
                            ?>
                        </td>
                        <td class="center">
                            <?php
                                if(($item->baths < $this->settings->adv_baths_low) || ($item->baths > $this->settings->adv_baths_high)){
                                    echo '<span class="hasTip invalid" title="'.JText::_( 'COM_IPROPERTY_BATHS' ).' :: '.JText::_( 'COM_IPROPERTY_BATHS' ).'">'.$item->baths.'</span>';
                                }else{
                                    echo $item->baths;
                                }
                            ?>
                        </td>
                        <td class="center">
                            <?php
                                if(($item->sqft < $this->settings->adv_sqft_low) || ($item->sqft > $this->settings->adv_sqft_high)){
                                    echo '<span class="hasTip invalid" title="'.JText::_( 'COM_IPROPERTY_SQFT' ).' :: '.JText::_( 'COM_IPROPERTY_SQFT' ).'">'.$item->sqft.'</span>';
                                }else{
                                    echo $item->sqft;
                                }
                            ?>
                        </td>
                        <td class="center">
                            <?php
                                if((($item->price < $this->settings->adv_price_low) || ($item->price > $this->settings->adv_price_high)) && !$this->settings->adv_nolimit){
                                    echo '<span class="hasTip invalid" title="'.JText::_( 'COM_IPROPERTY_PRICE' ).' :: '.JText::_( 'COM_IPROPERTY_PRICE' ).'">'.ipropertyHTML::getFormattedPrice($item->price, $item->stype_freq).'</span>';
                                }else{
                                    echo ipropertyHTML::getFormattedPrice($item->price, $item->stype_freq, '', '', $item->price2, true);
                                    if($item->call_for_price) echo ' [<span class="invalid">'.JText::_( 'COM_IPROPERTY_CALL_FOR_PRICE' ).'</span>]';
                                }
                            ?>
                        </td>
                        <td>
                        <?php
                            $cats   = ipropertyHTML::getAvailableCats($item->id);
                            if($cats){
                                foreach( $cats as $c ){
                                    echo ipropertyHTML::getCatIcon($c, 20, true);
                                }
                            }else{
                                echo '<span class="invalid">'.JText::_( 'COM_IPROPERTY_NONE' ).'</span>';
                            }
                        ?>
                        </td>
                        <td class="center"><?php echo $item->hits; ?></td>
                        <?php if ($this->ipauth->getAdmin() || $this->ipauth->getSuper()): ?>
                            <td class="center"><?php echo $item->groupname;?></td>
                            <?php if($this->settings->edit_rights): ?>
                            <td class="center">
                                <?php echo JHtml::_('ipadministrator.approved', $item->approved, $i, $canEdit, 'properties'); ?>
                            </td>
                            <?php endif; ?>
                            <td class="center">
                                <?php echo JHtml::_('jgrid.published', $item->state, $i, 'properties.', $canPublish, 'cb'); ?>
                            </td>
                            <td class="center">
                                <?php echo JHtml::_('ipadministrator.featured', $item->featured, $i, $canFeature, 'properties'); ?>
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