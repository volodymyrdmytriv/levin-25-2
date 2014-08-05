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
?>
<div class="item">
    <div align="center" class="iconBorder">
        <a onclick="window.parent.ipSwitchIcon('<?php echo $this->_tmp_icon->name; ?>');">
            <div class="image">
                <img src="<?php echo JURI::root(true); ?>/media/com_iproperty/<?php echo $this->folder; ?>/<?php echo $this->_tmp_icon->name; ?>"  width="<?php echo $this->_tmp_icon->width_60; ?>" height="<?php echo $this->_tmp_icon->height_60; ?>" alt="<?php echo $this->_tmp_icon->name; ?> - <?php echo $this->_tmp_icon->size; ?>" />
            </div>
        </a>
    </div>
    <div class="iconcontrols">
        <?php echo $this->_tmp_icon->size; ?>
        <a class="delete-item" href="<?php echo JRoute::_('index.php?option=com_iproperty&task=iconuploader.delete&tmpl=component&folder='.$this->folder.'&rm[]='.$this->_tmp_icon->name); ?>">
            <?php echo JHtml::_('image', 'media/remove.png', JText::_('JACTION_DELETE'), array('width' => 16, 'height' => 16), true); ?>
        </a>
    </div>
    <div class="iconinfo">
        <span class="hasTip" title="<?php echo $this->_tmp_icon->name; ?>"><?php echo $this->escape( substr( $this->_tmp_icon->name, 0, 10 ) . ( strlen( $this->_tmp_icon->name ) > 10 ? '...' : '')); ?></span>
    </div>
</div>