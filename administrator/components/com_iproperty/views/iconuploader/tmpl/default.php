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
<form action="index.php" method="post" name="adminForm" id="adminForm">
    <div class="iconhead">
        <?php echo JText::_( 'COM_IPROPERTY_SEARCH' ).' '; ?>
        <input type="text" name="search" id="search" value="<?php echo $this->search; ?>" class="inputbox" />
        <button onclick="document.adminForm.submit();"><?php echo JText::_( 'COM_IPROPERTY_GO' ); ?></button>
        <button onclick="document.adminForm.search.value='';document.adminForm.submit();"><?php echo JText::_( 'COM_IPROPERTY_RESET' ); ?></button>
        <div class="iconfoldername"><?php echo "/media/com_iproperty/". $this->folder; ?></div>
    </div>
    <div class="iconlist">
        <?php
        for ($i = 0, $n = count($this->images); $i < $n; $i++) :
            $this->setImage($i);
            echo $this->loadTemplate('icon');
        endfor;
        ?>
    </div>
	<input type="hidden" name="option" value="com_iproperty" />
	<input type="hidden" name="view" value="iconuploader" />
	<input type="hidden" name="tmpl" value="component" />
	<input type="hidden" name="task" value="<?php echo $this->task; ?>" />
    <div class="clear"></div>
    <div class="iconnav"><?php echo $this->pageNav->getListFooter(); ?></div>
</form>
