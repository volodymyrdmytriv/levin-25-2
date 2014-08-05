<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

$core_ip_css = ($this->fname == 'iproperty.css' || $this->fname == 'advsearch.css' || $this->fname == 'catmap.css') ? true : false;
$edit_width = ($core_ip_css) ? 80 : 100;

//get template list
$db = JFactory::getDbo();
$query = $db->getQuery(true);

$query->select('element as value, name as text');
$query->from('#__extensions');
$query->where('type='.$db->quote('template'));
$query->where('enabled=1');
$query->where('client_id=0');
$query->order('client_id');
$query->order('name');
$db->setQuery($query);
$options = $db->loadObjectList();
?>
<form action="<?php echo JRoute::_('index.php?option=com_iproperty'); ?>" method="post" name="adminForm" id="adminForm">		
    
    <div class="width-<?php echo $edit_width; ?> fltlft">
		<fieldset class="adminform">
            <legend><?php echo JText::_('COM_IPROPERTY_EDIT_CSS'); ?> - <?php echo $this->filename; ?></legend>
            <textarea style="width: 100%; height:500px;" cols="110" rows="25" name="filecontent" class="inputbox"><?php echo $this->content; ?></textarea>
        </fieldset>
    </div>
    <?php if($core_ip_css): ?>
        <div class="width-20 fltrt">
            <fieldset class="adminform">
                <legend><?php echo JText::_('JTOOLBAR_DUPLICATE').' '.JText::_('JSTATUS'); ?></legend>            
                <fieldset id="filter-bar">
                    <div class="filter-select fltrt">
                        <select name="copy_template" class="inputbox">
                            <option value=""><?php echo JText::_('JOPTION_SELECT_TEMPLATE'); ?></option>
                            <?php echo JHtml::_('select.options', $options, 'value', 'text', '');?>
                        </select>
                    </div>
                </fieldset>
                <div class="clr"> </div> 
                <?php 
                foreach($options as $o){
                    $status = (JFile::exists(JPATH_ROOT.DS.'templates'.DS.$o->value.DS.'css'.DS.$this->fname)) ? JText::_('JYES') : JText::_('JNO');
                    echo '<div class="ip_tmplist '.$status.'">'.$o->text.' - <b>'.$status.'</b></div>';
                }
                ?>
            </fieldset>
        </div>
    <?php endif; ?>
    <?php echo JHTML::_( 'form.token' ); ?>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="selectview" value="1" />
    <input type="hidden" name="edit_css_file" value="<?php echo $this->fname; ?>" />	
</form>
<div class="clr"></div>
<p class="copyright"><?php echo ipropertyAdmin::footer( ); ?></p>
	