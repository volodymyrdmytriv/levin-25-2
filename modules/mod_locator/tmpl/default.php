<?php // no direct access
/**
 * @package Locator Component
 * @copyright 2009 - Fatica Consulting L.L.C.
 * @license GPL - This is Open Source Software 
 * $Id: zip_form.php 525 2010-09-29 21:34:59Z fatica $
 */
defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<div class="locator_module <?php echo $params->get('moduleclass_sfx'); ?>">

<?php
$doc =& JFactory::getDocument();

require_once(JPATH_BASE. DS . 'components' . DS . 'com_locator' . DS . 'views' . DS . 'directory' . DS . 'view.html.php');

$view = new LocatorViewDirectory();

$doc =& JFactory::getDocument();
$view->initDOMLoadHook($params);
	
if($module_params->get('showmap',0) == 1){

$doc->addScriptDeclaration("jqLocator(document).ready(moduleInitialize);");

$doc =& JFactory::getDocument();
$doc->addScript("http://maps.google.com/maps/api/js?sensor=false");
	
//default to the US view 
$gmap_default_lat = $params->get( 'gmap_default_lat',39.7391667);
$gmap_default_lng = $params->get( 'gmap_default_lng',-104.9841667 );
$gmap_default_zoom = $params->get( 'gmap_default_zoom',10 );
$gmap_width = $params->get( 'gmap_width','230');
$gmap_height = $params->get( 'gmap_height','230');
$defaultmapview = $params->get( 'defaultmapview','ROADMAP' );
$jslinkmarkers = $params->get( 'jslinkmarkers','0' );



ob_start();
?>

	var module_map;
	var module_openWindow;
	var latlng = new Array();

		function moduleInitialize() 
		{
			try{
				var myLatlng = new google.maps.LatLng(<?php echo $gmap_default_lat; ?>,<?php echo $gmap_default_lng; ?>);
				var myOptions = {
					zoom:<?php echo $gmap_default_zoom; ?>,
					center: myLatlng,
					streetViewControl: true,
					mapTypeId: google.maps.MapTypeId.<?php echo $defaultmapview; ?>
				}
				
			}catch(e){
				alert("Error, cannot create Google Map object." + e);
				return;
			}
			
			module_map = new google.maps.Map(document.getElementById("locator_map_module_canvas"), myOptions);
	<?php
	
	//$view->addMTCompat($params);

	if(isset($this->items) && is_array($this->items)){
	
		for ($i = 0; $i < count($this->items);  $i++){
		
		$item = $this->items[$i];
	
		$Address = $Address2 = $City = $State = $PostalCode = $Phone = $Link = "";
		
		$label = "";
		$value = "";
		
		$j = $i + 1;
								
		//ensure we have at least one field so there's no empty span tag
		if(isset($item->fields[0]->value)){

			//declare the item type variables
			foreach ($item->fields as $field){ 
				
				foreach ($field as $key=>$val){

					if ($key == "name" && strlen($val) > 0){ 
						$label = str_replace(" ","",$val);
					}
					
					if ($key != "name" && $key != "type" && strlen($val) > 0){ 
						$value = $val;
					}
					
					if (strlen($value) && strlen($label)){ 
		
						//declare the template variable dynamically
						$$label = str_replace(array("\n","\r"),'',str_replace('"','\"',$value));
						
						$label = "";
						$value = "";
					}
				
				}
			
			}
				
			if(strlen($item->lat) > 0){
				
				$item->description  = str_replace(array("\n","\r"),'',$item->description);
				$item->title  = str_replace(array("\n","\r"),'',$item->title);

				?>
				var myLatlng = new google.maps.LatLng(<?php echo (string)$item->lat; ?>,<?php echo (string)$item->lng; ?>);
				var point = myLatlng;
				<?php 
				$item->title = str_replace("'","\'",$item->title);
				?>
				
				var contentString = '<div class="popupWindow"><h2 class="title"><?php 
				
				if(isset($linktoitempage)){
					if ($linktoitempage == 1) { ?><a href="<?php echo JURI::base(); ?>index.php?option=com_locator&id=<?php echo (int)$item->id;?>&Itemid=<?php echo (int)$menuitemid; ?>"><?php }
				} ?><?php echo $item->title ?><?php if(isset($linktoitempage)){ if ($linktoitempage == 1) { ?></a><?php }} ?></h2><span class="address"><?php echo str_replace("'","\'",$Address); ?><br /><?php echo str_replace("'","\'","$City, $State $PostalCode"); ?><br /><?php echo str_replace("'","\'",$Phone); ?></span><div class="description"><?php echo str_replace("'","\'",$item->description); ?></div><?php 
				
				if(isset($Link)){
					if(strlen($Link) > 0){
						
						echo '<span class="line_item locator_link">' . $Link . '</span>';
					}	
				}
				echo "</div>';";
				?>
				<?php if ( $params->get( 'show_directions', 1 ) == 1){ ?>
				//add the driving directions code
				contentString += '<form target="_blank" name="directions<?php echo $j;?>" method="get" action="http://maps.google.com/maps"><a href="#" onclick="document.directions<?php echo $j?>.submit();" ><?php echo JText::_('LOCATOR_GET_DIRECTIONS'); ?></a><input type="hidden" value="<?php echo (string)$item->lat; ?>,<?php echo (string)$item->lng; ?>" name="daddr" /></form>';
				<?php } ?>				       
				
			    var module_infowindow<?php echo $j; ?> = new google.maps.InfoWindow({
			        content: contentString
			    });
			    
				latlng[<?php echo $i?>] = myLatlng;
				<?php 
					$icon = "";
					$shadow = "";
					if(strlen($item->marker) > 0){
					?> 
        				//var myIcon = new GIcon(G_DEFAULT_ICON);
       					myIcon = "<?php echo $item->marker; ?>";
       					
       					<?php if (strlen($item->marker_shadow) > 0){ ?>
       					
						myShadow = "<?php echo $item->marker_shadow; ?>";
						
						<?php 
       					
						$shadow = "shadow:myShadow,";
						
       					} ?>
					<?php 
						$icon = "icon:myIcon,";
					}
				?>
				
				 var marker<?php echo $j; ?> = new google.maps.Marker({
	       			position: myLatlng, 
	       		 	map: module_map,
	       		 	<?php echo $icon; ?>
	       		 	<?php echo $shadow; ?>
	       		 	title:'<?php echo $item->title; ?>'
	    		});
				
	    		google.maps.event.addListener(marker<?php echo $j; ?>, 'click', function() {
	    		 <?php 
	    		 
	    		
	    		  if ( $params->get( 'jslinkmarkers', 0 ) == 1){ 
	    		 		if(strlen($Link)){ 
	    		 					 	
	    		 ?>
	    		 		//fatica tc
	    		 		window.location.href='<?php echo $Link; ?>';
	    		 		
	    		 <?php		
	    		 		}
	    		 		
	    		 	}else{ 
	    		 ?>
	    		 	//close any open window
	    		 	if(module_openWindow > 0){
	    		 		eval("module_infowindow" + module_openWindow + ".close();");
	    		 	}
	    		 	
			      	module_infowindow<?php echo $j; ?>.open(module_map,marker<?php echo $j; ?>);
			      	
			      	module_openWindow = <?php echo $j; ?>;
			     <?php
	    		 	}
	    		 ?>
			      	
			    });
				<?php
				}
				
				$Address = $Address2 = $City = $State = $PostalCode = $Phone = $Link = "";
			}
		}
	}

if ( $params->get( 'centeronresults', 1 ) == 1){ ?>
 
 	var latlngbounds = new google.maps.LatLngBounds();
 
	if(latlng.length > 0){
	
	  if(latlng.length == 1){
	   	
	   	latlngbounds.extend( latlng[ 0 ] );
	  	module_map.setCenter( latlngbounds.getCenter( ));
	  	module_map.setZoom(<?php echo $params->get( 'zoomlevelonsingle', 16 ); ?>);
	  
	  }else{
	  
	  	for ( var i = 0; i < latlng.length; i++ )
		  {
		  	if(latlng[ i ]){
		    	latlngbounds.extend( latlng[ i ] );
		  	}
		  }
		  
		  module_map.setCenter( latlngbounds.getCenter( ));
		  module_map.fitBounds(latlngbounds);
		  
	  }
}

<?php }  ?>
	
}<!-- end initialize -->
<?php	
	          
$buffer = ob_get_contents();
ob_end_clean();
$doc->addScriptDeclaration($buffer);
?>
<div class="locator_map">
	<div id="locator_map_module_canvas" style="width:<?php echo $gmap_width; ?>px; height:<?php echo $gmap_height; ?>px;"></div>
</div>
<?php
}
?>
<?php
if($module_params->get('showlegend',0) == 1){
?>
<div class="locator_legend">
<?php
	if(count($this->lists['legend']) > 0){ ?>
		<ul class="locator_legend_list">
		<?php
		
		$i = 0;
		
		foreach ($this->lists['legend'] as $legend_entry){
			
			$i++;
			
			if(strlen(trim($legend_entry->marker)) <= 0){
				$legend_entry->marker = "http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png";	
			}
			
			$marker = '<img class="locator_legend_icon" src="' . trim($legend_entry->marker) . '" alt="' . $legend_entry->name . '" />';
			
			$entry_text = $marker . $legend_entry->name;
			
			if($module_params->get('linklegend',0) == 1){
				//break the link apart so the image is linked, but the text underline doesn't go under the image.  (Looks uglier than this code )
				$entry_text = '<a href="' . JRoute::_($this->lists['link'] . '&amp;task=search_zip&amp;tags='. $legend_entry->id) .'">' . $marker . '</a>';
				$entry_text .= '<a href="' .  JRoute::_($this->lists['link'] . '&amp;task=search_zip&amp;tags='. $legend_entry->id) .'">' . $legend_entry->name . '</a>';
			}
			
		?>
			<li class="locator_row<?php echo ($i % 2); ?>"><?php echo $entry_text; ?></li>
		<?php
		}
		?>
		</ul>
		<?php
	}
?>
</div>
<?php } ?>
<form name="locatorModule" method="get" action="<?php echo JRoute::_('index.php'); ?>">
<?php 
$show_submit = false;


if($module_params->get('showzipform') == 1){
	require('components' .DS. 'com_locator' .DS. 'views' .DS. 'directory' .DS. 'tmpl' .DS. 'zip_form.php'); 
	$show_submit = true;
} 

if($module_params->get('showkeywordform') == 1){
	require('components' .DS. 'com_locator' .DS. 'views' .DS. 'directory' .DS. 'tmpl' .DS. 'keyword_form.php'); 
	$show_submit = true;
}

if($module_params->get('showtagdropdown') == 1){
	require('components' .DS. 'com_locator' .DS. 'views' .DS. 'directory' .DS. 'tmpl' .DS. 'tag_form.php'); 
	$show_submit = true;
}

if($params->get('showstatedropdown') == 1){
	require('components' .DS. 'com_locator' .DS. 'views' .DS. 'directory' .DS. 'tmpl' .DS. 'state_form.php'); 
	$show_submit = true;
}
		
if($params->get('showcitydropdown',0) == 1){
	require('components' .DS. 'com_locator' .DS. 'views' .DS. 'directory' .DS. 'tmpl' .DS. 'city_form.php'); 
	$show_submit = true;
}

if($module_params->get('showcountrydropdown') == 1){
	require('components' .DS. 'com_locator' .DS. 'views' .DS. 'directory' .DS. 'tmpl' .DS. 'country_form.php'); 
	$show_submit = true;
}

if($show_submit === true){
?>
<input type="hidden" value="search_zip" name="task" />
<input type="hidden" value="com_locator" name="option" />
<?php
if(defined('MODULE_LOCATOR_POSTAL_CODE')){ ?>
<input type="button" value="<?php echo JText::_('LOCATOR_SUBMIT'); ?>" name="go" onclick="module_sendPostalQuery(document.getElementById('module_postal_code').value,document.locatorModule);"/>
<?php } else { ?>
<input type="submit" value="<?php echo JText::_('LOCATOR_SUBMIT'); ?>" name="go" />
<?php }
}
?>
<?php
$options = explode('&',$this->lists['link']);

foreach ($options as $o){
	
	if(strpos($o,'index.php') !== false)continue;
	
	$o = str_replace('amp;','',$o);
	
	$pair = explode('=',$o);
	
	echo '<input type="hidden" value="'.$pair[1].'" name="'.$pair[0].'" />';
	
}
?>
</form>
</div>