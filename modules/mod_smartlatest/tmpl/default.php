<?php
/*------------------------------------------------------------------------
# mod_smartlatest.php - Smart Latest News (module)
# ------------------------------------------------------------------------
# version		1.0.0
# author    	Master Comunicacion
# copyright 	Copyright (c) 2011 Top Position All rights reserved.
# @license 		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website		http://master-comunicacion.es/joomla-extensions/
-------------------------------------------------------------------------

# this module is based on Aixeena Zaragoza latest News (GNU licensed)

*/

defined('_JEXEC') or die;

if($params->get('include_css',1)) $document->addStyleSheet(JURI::base().'modules/mod_smartlatest/css/css'.$params->get('css',1).'.css');

?>

<ul class="smartlatest">
<?php foreach ($list as $item) : 

	if($params->get('show_intro',1)) {
		$introtext = $item->introtext;
		if($params->get('strip_intro',1)) 	$introtext = strip_tags($introtext);
		if($params->get('crop_intro',1)) 	$introtext = modSmartlatestHelper::firstXChars($introtext, $params->get('crop',200));
	}
	if($params->get('show_image1',0)) $images  = json_decode($item->images);
		
 ?>
	<li class="smartlatest-newsli">
    	<?php if($params->get('show_image1',0)) { ?>
        <div class="smartlatest-img">
			<img
			<?php if (isset($images->image_intro_caption) && $images->image_intro_caption):
				echo 'class="caption"'.' title="' .htmlspecialchars($images->image_intro_caption) .'"';
			endif; ?>
			src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/>
		</div>
        <?php } ?>
    	
		<?php if($params->get('show_header',1)) echo '<div class="smartlatest-category">'.$item->category_title.'</div>'; ?>
    	<div class="smartlatest-title">
        	<?php if($params->get('link_title',1)) { ?><a href="<?php echo $item->link; ?>" class="smartlatest-title-link"><?php } ?>
			<?php echo $item->title; ?>
            <?php if($params->get('link_title',1)) { ?></a><?php } ?>
            </div>
   		<?php if($params->get('show_date',1)) echo '<div class="smartlatest-date">'.strftime($params->get('date_format','%d-%m-%Y'), strtotime($item->publish_up)).'</div>'; ?>
    	<?php if($params->get('show_intro',1)) echo '<div class="smartlatest-introtext">'.$introtext.'</div>'; ?>
    	<?php if($params->get('show_readmore',1)) echo '<div class="smartlatest-readmore"><a href="'.$item->link.'" class="smartlatest-lreadmore">'.$params->get('readmore_text',"Read more").'</a></div>'; ?>
		
	</li>
<?php endforeach; ?>
<?php if($params->get('show_link',1)) { ?>
	<li  class="smartlatest-more"><a href="<?php echo $params->get('link',""); ?>"><?php echo $params->get('link_text',"More news..."); ?></a></li>
<?php } ?>
</ul>
<div style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px; font-style:italic; text-align:right; display:block;">By <a href="http://master-comunicacion.es">Master en comunicaci&oacute;n</a></div>

