<div class="ip_spacer"></div>
<div>
	<button type="button" onclick="saveSpaces()">Save Spaces</button>
	&nbsp;&nbsp;<span id="spacesmessage" style="color: blue; font-weight: bold"></span>
</div>
<div class="ip_spacer" style="clear: both" ></div>
<script>

jQuery.noConflict();
jQuery(document).ready(function($) {
    
	jQuery('#spacesGrid').appendGrid({
        caption: 'Property Spaces',
        initRows: 1,
        columns: [
                { name: 'id', type: 'hidden'},
                { name: 'prop_id', type: 'hidden'},
                { name: 'space_id2', display: 'Space ID(1,2,3,3A,3B...)', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '150px' } },
                { name: 'space_name', display: 'Space Name', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '150px' } },
				{ name: 'space_sqft', display: 'Space Sq.Ft.', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '120px'} }
            ],
        initData: [
                { id: 1, prop_id: 1, space_id2: '1A', space_name: 'Space 1A', space_sqft: '3500' }
            ],
		beforeRowRemove: function (caller, rowIndex) {

			var confirm_res = confirm('Are you sure to remove this space?');

			var rowdata = jQuery('#spacesGrid').appendGrid('getRowValue', rowIndex);

			if(confirm_res)
			{
				removeSpace(rowdata.id);
			}

			return confirm_res;
		}
    });

	loadSpaces();
    
});

function saveSpaces()
{

	var data = jQuery('#spacesGrid').appendGrid('getAllValue');

	var ajaxData = {};
	ajaxData.prop_id = <?php echo $this->propid ?>;
	ajaxData.spaces_data = JSON.stringify(data);
	ajaxData.format = "raw";
	ajaxData['<?php echo JUtility::getToken(); ?>'] = '1';

	var staturl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.saveSpaces';
	
	jQuery.ajax({
		url: staturl,
		method: "POST",
		data: ajaxData,
		success: function(data){

			jQuery("#spacesmessage").text('Spaces are updated.').fadeIn().delay(2000).fadeOut();
			
			loadSpaces();
			
	   },
	   error:function(){
		   
	   }
	});
	
}

function removeSpace(space_id)
{

	var ajaxData = {};
	ajaxData.space_id = space_id;
	ajaxData.format = 'raw';
	ajaxData['<?php echo JUtility::getToken(); ?>'] = '1';
	
	var ajaxurl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.removeSpace';
	
	jQuery.ajax({
      url: ajaxurl,
      type: "POST",
      data: ajaxData,
	  success: function(data){
			
		  loadSpaces();
		  jQuery("#spacesmessage").text('Spaces are updated.').fadeIn().delay(2000).fadeOut();
		
           //onAjaxResult(data);
      },
      error:function(){
	      
      }
	});
	
}

function loadSpaces()
{
	
	
	var ajaxData = {};
	ajaxData.prop_id = <?php echo $this->propid ?>;
	ajaxData.format = 'raw';
	ajaxData['<?php echo JUtility::getToken(); ?>'] = '1';
	
	var ajaxurl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.getSpacesTableData';
	
	jQuery.ajax({
      url: ajaxurl,
      type: "POST",
      data: ajaxData,
	  dataType: 'json',
	  success: function(data){
		
		  jQuery('#spacesGrid').appendGrid('load', data);

		//reloading tenant list tab
		loadTenants();
          
      },
      error:function(){
	      
      }
	});
	
}

</script>


<table id="spacesGrid">

</table>


