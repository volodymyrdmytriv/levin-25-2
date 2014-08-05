<?php
/**
 * @version 2.0.3 2013-04-08
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

// No direct access.
defined('_JEXEC') or die;
?>
<div class="icon-wrapper">
	<div class="icon">
		<a href="<?php echo $button['link']; ?>">
			<?php echo JHtml::_('image', $button['image'], NULL, NULL, false); ?>
			<span><?php echo $button['text']; ?></span>
        </a>
	</div>
</div>
