<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Intellectual Property
 * @copyright (C) 2013 the Thinkery
 * @license GNU/GPL see LICENSE.php
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
JHTML::_('behavior.modal');

?>

<?php if($this->settings->show_saveproperty): ?>
<div id="save-panel">
    <?php echo $this->loadTemplate('searchsave'); ?>
</div>
<?php endif; ?>
<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif; ?>
<?php if ($this->params->get('show_ip_title') && $this->iptitle) : ?>
    <div class="ip_mainheader">
        <h2><?php echo $this->iptitle; ?></h2>
    </div>
<?php endif; ?>

<div id="mapCanvas"></div>
<?php if ($this->params->get('show_ip_disclaimer') && $this->settings->disclaimer) : ?>
    <div class="ip_disclamer">
        <?php echo $this->settings->disclaimer; ?>
    </div>
<?php endif; ?>
<?php
if( $this->settings->footer == 1):
    echo ipropertyHTML::buildThinkeryFooter();
endif;
?>