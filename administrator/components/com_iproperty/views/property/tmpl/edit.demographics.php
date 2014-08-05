<div class="ip_spacer"></div>
<div>
	<button type="button" onclick="saveStatistics()">Save Statistics</button>
	&nbsp;&nbsp;<span id="statmessage" style="color: blue; font-weight: bold"></span>
</div>
<div class="ip_spacer" style="clear: both" ></div>
<script>

jQuery.noConflict();
jQuery(document).ready(function($) {
    
	jQuery('#demographicsGrid').appendGrid({
        caption: 'Demographics',
        initRows: 1,
        columns: [
                { name: 'id', type: 'hidden'},
                { name: 'stat_id', type: 'hidden'},
                { name: 'stat_name', display: 'Statistic Name', type: 'text', ctrlAttr: { maxlength: 100, disabled: "disabled" }, ctrlCss: { width: '180px' } },
                { name: 'miles1_value', display: 'Miles1 Value', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '120px'} },
                { name: 'miles2_value', display: 'Miles2 Value', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '120px'} },
                { name: 'miles3_value', display: 'Miles3 Value', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '120px'} }
            ],
        initData: [
                { id: 1, stat_id: 1, 'stat_name': 'Miles', 'miles1_value': '1', 'miles2_value': '2', 'miles3_value': 3 }
            ],
        hideButtons: {
            	append: true,
            	removeLast: true,
            	insert: true,
            	remove: true,
            	moveUp: true,
            	moveDown: true
        	}
    });

	loadStatistics();
    
});

function saveStatistics() {

	var data = jQuery('#demographicsGrid').appendGrid('getAllValue');

	var ajaxData = {};
	
	ajaxData.prop_id = <?php echo $this->propid ?>;
	ajaxData.stat_data = JSON.stringify(data);
	ajaxData.format = "raw";
	ajaxData['<?php echo JUtility::getToken(); ?>'] = '1';

	var staturl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.saveDemographics';
	
	jQuery.ajax({
		url: staturl,
		method: "POST",
		data: ajaxData,
		success: function(data){

			jQuery("#statmessage").text('Statistics are updated.').fadeIn().delay(2000).fadeOut();
			
			loadStatistics();
			
	   },
	   error:function(){
		   
	   }
	});
	
}

function loadStatistics() {

	var ajaxData = {};
	ajaxData.prop_id = <?php echo $this->propid ?>;
	ajaxData.format = 'raw';
	ajaxData['<?php echo JUtility::getToken(); ?>'] = '1';
	
	var staturl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.getDemographicsTableData';
	
	jQuery.ajax({
      url: staturl,
      type: "POST",
      data: ajaxData,
	  dataType: 'json',
	  success: function(data){

		  jQuery('#demographicsGrid').appendGrid('load', data);
			
           //onAjaxResult(data);
      },
      error:function(){
	      
      }
	});
	
}

</script>

<table id="demographicsGrid">

</table>