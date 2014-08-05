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

<?php if ($this->params->get('show_page_heading', 1)) : ?>
	<h1>
	<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
<?php endif; ?>
<?php if ($this->params->get('show_ip_title') && $this->iptitle) : ?>
<div class="ip_mainheader">
	<h2><?php echo $this->iptitle; ?></h2>
</div>
<?php endif; ?>

<?php

    $this->k = 1;
    echo '<table class="ptable">';
    echo $this->loadTemplate('company');
    echo '</table>';
    
    echo $this->loadTemplate('cform');
    if( $this->settings->footer == 1):
        echo ipropertyHTML::buildThinkeryFooter();
    endif;
?>
