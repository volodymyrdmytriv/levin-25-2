<?php 
$styles = array("slide_right","slide_left ","slide_top ","slide_bottom ","fade ");
$rexs = array( "ex4", "ex1", "ex2" , "ex3","ex5" , "ex6" );
?>        
<div class="repv-slideshow" style="position:relative;width:100%">
<ul id="unoslider<?php echo $module->id;?>" class="unoslider" style="width:100%">
    <?php foreach( $list as $item ) :  	 
		$class = array_rand($styles);
		$ex = array_rand( $rexs );
	?>
    <li style=" max-width:<?php echo $mainWidth;?>px">
   <a href="<?php echo $item->link; ?>" title="<?php echo JText::_("READ_MORE");?>">
    	<img <?php echo ($showCaption?'title="'.$item->title.'"':"");?>  src="<?php echo $item->thumbnail; ?>" /></a>
    	<?php if( $showDescription ):?> <div class='unoslider_layers' > 
            <div class='<?php  echo $styles[$class]." ".$rexs[$ex];?>' style="max-width:300px; background:<?php echo $bgdesc ;?>; ">
            	<?php if( $showTitle)  :?>
					<h4>
					<a href="<?php echo $item->link; ?>" title="<?php echo $item->title;?>">
						<?php echo $item->title;?>
                    </a>
                    </h4>
				<?php endif; ?>
                
				<?php echo $item->description;?>
              
            	<?php if( $showReadmore ): ?>
            		<div><a href="<?php echo $item->link; ?>" title="<?php echo JText::_("READ_MORE");?>"><?php echo JText::_("READ_MORE");?></a></div>
                <?php endif; ?>
            </div> 
		 </div>  <?php endif; ?>
    </li>
 	<?php endforeach; ?>
</ul>
</div>
<script type='text/javascript'> 
  jQuery(document).ready(function( $ ){ 
		 var options = {
			  width:  <?php echo $mainWidth ;?>,
			  height:  <?php echo $mainHeight ;?>,
              tooltip: true,
              indicator: { autohide:  <?php echo $params->get("autohide_indicator",1);?> },
              navigation: { autohide: <?php echo $params->get("autohide_navigation",1);?> },
              slideshow: { hoverPause: true, continuous: true, timer: true, speed: <?php echo (int)$params->get("interval",5);?>, infinite: true, autostart: <?php echo $params->get("auto_start",1);?> },
              responsive: true,
              preset: [<?php echo $effect; ?>],
              order: 'random',
              block: {
                vertical: 10,
                horizontal: 4
              },
              animation: {
                speed: 500,
                delay: 50,
                transition: 'grow',
                variation: 'topleft',
                pattern: 'diagonal',
                direction: 'topleft'
              }
            }; 	
		jQuery('#unoslider<?php echo $module->id;?> .unoslider_layers').css({"opacity":0.7});	
		jQuery('#unoslider<?php echo $module->id;?>').unoslider(options);
		
		$("#unoslider<?php echo $module->id;?> > img").click( function(){  
			if( $("a", this).attr("href") != "" ){  
			 	window.location.href=$("a", this).attr("href");
			}
		} );
  }); 
</script>