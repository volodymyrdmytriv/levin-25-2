<?php
/**
 * @version 2.0.2 2013-03-20
 * @package Joomla
 * @subpackage Iproperty
 * @copyright (C) 2013 the Thinkery
 * @license see LICENSE.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access'); 

if (count($images) > 0) : ?>
<div class="ipslidemod<?php echo str_replace(' ', '_', $moduleclass_sfx); ?>">
        <div id="ip_slideshow<?php echo str_replace(' ', '_', $moduleclass_sfx); ?>" class="slideshow" style="width: <?php echo $params->get( 'width', 400 ); ?>px; margin-left: <?php echo $params->get( 'margin_left', 0 ); ?>px; margin-top: <?php echo $params->get( 'margin_top', 0 ); ?>px;">
            <div class="slideshow-images">
                <div class="slideshow-loader"></div>
            </div>
            <?php if ($params->get( 'showCaption', false )) echo '<div class="slideshow-captions"></div>'; ?>
            <?php if ($params->get( 'showController', false )) echo '<div class="slideshow-controller"></div>'; ?>
            <?php if ($params->get( 'showThumbnails', false )) echo '<div class="slideshow-thumbnails"></div>'; ?>
        </div>
    </div>
<?php endif;?>