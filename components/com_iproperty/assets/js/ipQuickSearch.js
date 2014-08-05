var qs_opened = false;
var propertiesitem_mouseover = false;
var qs_mouseover = false;
var qs_timeout1 = 0;
var qs_timeout2 = 0;
var qs_timeout3 = 0;

var qs_keepopened_flag = false;

function onFormChanged()
{
	qs_keepopened_flag = true;
	
	clearTimeout(qs_timeout3);
	qs_timeout3 = setTimeout(function() {
		
		qs_keepopened_flag = false;
		
	}, 650);
}

jQuery(document).ready(function($) {

		// adding ajax support for selectors and doing filtering
	
		jQuery("#qs_property_type").change(function() {
			var type_value = jQuery("#qs_property_type").val();

			qs_resetPropertySpace();
			
			qs_doAjaxSearch({property_type: type_value, return_states: true, return_cities: true});
			
		});
	
		jQuery("#qs_property_state").change(function() {
			onFormChanged();
			
			var type_value = jQuery("#qs_property_type").val();
			var state_value = jQuery("#qs_property_state").val();

			qs_resetPropertySpace();
			
			qs_doAjaxSearch({property_type: type_value, property_state: state_value, return_cities:true });
			
		});
	
		jQuery("#qs_property_city").change(function() {
			
			onFormChanged();
			
			
			qs_resetPropertySpace();
			
			//updateGoogleMap();
		});

		jQuery("#qs_property_space").change(function() {

			//updateGoogleMap();

		});

		jQuery(".qs_propertysearch_mainform .search_reset").click(function() {

			var type_value = jQuery("#qs_property_type").val();
			
			qs_resetPropertyType();
			jQuery("#qs_property_state").val("");
			jQuery("#qs_property_city").val("");
			qs_resetPropertySpace();
			
			qs_doAjaxSearch({return_states: true, return_cities: true});
			
		});
		
		var qs_left = 0;
		
		qs_left += jQuery("#rt-menu .casestudies_item").position().left + jQuery("#rt-menu .casestudies_item").width() + parseInt(jQuery("#rt-menu .casestudies_item").css("padding-right").replace("px", ""));
		
		qs_left -= jQuery("#rt-menu .quicksearch").width();
		
		qs_left += 2;
		
		jQuery("#rt-menu .quicksearch").css("left", qs_left); 
		
		//#rt-menu .quicksearch minheight=0px
		//#rt-menu .quicksearch maxheight=163px
		
		jQuery("#rt-menu .properties_item").mouseenter(function() {
			
			propertiesitem_mouseover = true;
			
			if(qs_opened == true)
			{
				return;
			}
			
			qs_opened = true;
			
			jQuery("#rt-menu .quicksearch").animate(
				{height: 202},
				200,
				"swing",
				function () {
					//onamination complete
					
				}
			);
			
		});
		jQuery("#rt-menu .properties_item").mouseleave(function() {
			
			propertiesitem_mouseover = false;
			
			clearTimeout(qs_timeout1);
			qs_timeout1 = setTimeout(function() {
				
				if(qs_mouseover)
				{
					return;
				}
				
				qs_hide();
			}, 100);
			
		});
		jQuery("#rt-menu .quicksearch").mouseenter(function() {
			
			qs_mouseover = true;
			
		})
		jQuery("#rt-menu .quicksearch").mouseleave(function(e) {
			
			// fix the select problem in firefox
			if(e.target.tagName.toLowerCase() != 'div')
			{
				return;
			}
			
			qs_mouseover = false;
			
			if(qs_keepopened_flag)
			{
				qs_keepopened_flag = false;
				
				return;
			}
			
			clearTimeout(qs_timeout2);
			qs_timeout2 = setTimeout(function() {

				if(propertiesitem_mouseover)
				{
					return;
				}
				
				qs_hide();
				
			}, 100);
			
		})
		
		
		
});

function qs_hide()
{
	if(qs_opened == false)
	{
		return;
	}
	
	qs_opened = false;
	
	jQuery("#rt-menu .quicksearch").animate(
			{height: 0},
			200,
			"swing",
			function () {
				//onamination complete
				
			}
	);
}

	function qs_resetPropertyType()
	{
		jQuery("#qs_property_type option").removeAttr("selected");
		jQuery("#qs_property_type").val("");
	}
	
	function qs_resetPropertySpace()
	{
		jQuery("#qs_property_space option").removeAttr("selected");
		jQuery("#qs_property_space").val("");
	}
	
	function qs_doAjaxSearch(dataObj)
	{
		
		if(dataObj.return_states)
		{
			jQuery("#qs_property_state").attr( "disabled", "disabled" );
		}
		if(dataObj.return_cities)
		{
			jQuery("#qs_property_city").attr( "disabled", "disabled" );
		}

		jQuery("#qs_property_space").attr( "disabled", "disabled" );
		
		dataObj[j_token] = '1';
		dataObj.format = 'raw';
		
		var checkurl = jurl_base + '/index.php?option=com_iproperty&task=ajax.ajaxSearch2';
		
		jQuery.ajax({
	      url: checkurl,
	      type: "POST",
	      data: dataObj,
		  dataType: 'json',
		  success: function(data){

				//alert(data.abc);
	           qs_onAjaxResult(data);
	      },
	      error:function(){
		      
	      }   
		});
	}

	function qs_onAjaxResult(jsonData)
	{
		
		var i;
		
		if(jsonData['states'] !== undefined)
		{
			jQuery("#qs_property_state").removeAttr('disabled');
			
			var states = jsonData['states'];

			jQuery("#qs_property_state option[value!='']").remove();

			for(i=0; i<states.length; i++)
			{
				var state_data = states[i];
				
				jQuery("#qs_property_state").append('<option value="' + state_data.mc_name + '" >' + state_data.title.toUpperCase() + '</option>');
				
			}
			
		}

		if(jsonData['cities'] !== undefined)
		{
			jQuery("#qs_property_city").removeAttr('disabled');
			
			var cities = jsonData['cities'];

			jQuery("#qs_property_city option[value!='']").remove();
			
			for(i=0; i<cities.length; i++)
			{
				var city_data = cities[i];
				
				jQuery("#qs_property_city").append('<option value="' + city_data.city + '" >' + city_data.city.toUpperCase() + '</option>');
				
			}
			
		}

		jQuery("#qs_property_space").removeAttr('disabled');
		
		//updateGoogleMap();
		
	}
