<div class="ip_spacer"></div>
<div>
	<button type="button" onclick="saveTenants()">Save Tenants</button>
	&nbsp;&nbsp;<span id="tenantsmessage" style="color: blue; font-weight: bold"></span>
</div>
<div class="ip_spacer" style="clear: both" ></div>
<div>Tenants are ordered authomatically by SpaceID after saved!</div>
<div class="ip_spacer" style="clear: both" ></div>
<script>

jQuery.noConflict();
jQuery(document).ready(function($) {
    
	jQuery('#tenantsGrid').appendGrid({
        caption: 'Property Tenants',
        initRows: 1,
        columns: [
                { name: 'id', type: 'hidden'},
                { name: 'prop_id', type: 'hidden'},
				{ name: 'space_id', display: 'SpaceID', type: 'select', ctrlOptions: { 0: 'None', 1: 'Space1'} },
                { name: 'store_number', type: 'hidden'},
                { name: 'tenant', display: 'Tenant Name', type: 'text', ctrlAttr: { maxlength: 100 }, ctrlCss: { width: '150px' } },
                { name: 'square_feet', type: 'hidden'},
                { name: 'available', display: 'Is Available?', type: 'select', ctrlOptions: { 0: 'No', 1: 'Yes'}, type: 'hidden' }
                
            ],
        initData: [
                { id: 0, prop_id: 0, space_id: '1', tenant: 'Tenant 1', available: '1' }
            ]
    });

	loadTenants();
    
});

function saveTenants()
{
	
	var data = jQuery('#tenantsGrid').appendGrid('getAllValue');

	var ajaxData = {};
	ajaxData.prop_id = <?php echo $this->propid ?>;
	ajaxData.tenants_data = JSON.stringify(data);
	ajaxData.format = "raw";
	ajaxData['<?php echo JUtility::getToken(); ?>'] = '1';

	var ajaxurl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.saveTenants';
	
	jQuery.ajax({
		url: ajaxurl,
		method: "POST",
		data: ajaxData,
		success: function(data){

			jQuery("#tenantsmessage").text('Tenants are updated.').fadeIn().delay(2000).fadeOut();
			
			loadTenants();
			
	   },
	   error:function(){
		   
	   }
	});
	
}

function removeTenant(tenant_id)
{

	var ajaxData = {};
	ajaxData.tenant_id = tenant_id;
	ajaxData.format = 'raw';
	ajaxData['<?php echo JUtility::getToken(); ?>'] = '1';
	
	var ajaxurl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.removeTenant';
	
	jQuery.ajax({
      url: ajaxurl,
      type: "POST",
      data: ajaxData,
	  success: function(data){
			
		  loadTenants();
		  jQuery("#tenantsmessage").text('Tenants are updated.').fadeIn().delay(2000).fadeOut();
		
           //onAjaxResult(data);
      },
      error:function(){
	      
      }
	});
	
}

function loadTenants()
{

	var ajaxData = {};
	ajaxData.prop_id = <?php echo $this->propid ?>;
	ajaxData.format = 'raw';
	ajaxData['<?php echo JUtility::getToken(); ?>'] = '1';
	
	var ajaxurl = '<?php echo JURI::base('true'); ?>/index.php?option=com_iproperty&task=ajax.getTenantsTableData';
	
	jQuery.ajax({
      url: ajaxurl,
      type: "POST",
      data: ajaxData,
	  dataType: 'json',
	  success: function(data){
		  updateTenantsTable(data);
      },
      error:function(){
	      
      }
	});
	
}

function updateTenantsTable(data)
{

	var space_selector = data.spaces_selector;

	// we should redefine the table
	jQuery('#tenantsGrid').appendGrid({
	    caption: 'Property Tenants',
		columns: [
	                { name: 'id', type: 'hidden'},
	                { name: 'prop_id', type: 'hidden'},
					{ name: 'space_id', display: 'SpaceID', type: 'select', ctrlOptions: space_selector, ctrlCss: { width: '170px' } },
	                { name: 'store_number', type: 'hidden'},
	                { name: 'tenant', display: 'Tenant Name', type: 'text', ctrlCss: { width: '260px' } },
	                { name: 'square_feet', type: 'hidden'},
	                { name: 'available', display: 'Is Available?', type: 'select', ctrlOptions: { 0: 'No', 1: 'Yes'}, type: 'hidden' }
	                
	     ],
	     beforeRowRemove: function (caller, rowIndex) {

  			var confirm_res = confirm('Are you sure to remove this tenant?');

  			var rowdata = jQuery('#tenantsGrid').appendGrid('getRowValue', rowIndex);

  			if(confirm_res)
  			{
  				removeTenant(rowdata.id);
  			}

  			return confirm_res;
	     }
    });
	
	jQuery('#tenantsGrid').appendGrid('load', data.tenants);
	
}

</script>

<table id="tenantsGrid">

</table>