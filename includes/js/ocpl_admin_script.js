//jquery tab
jQuery(document).ready(function(){
    //slider setting options by tabbing
    jQuery('ul.tabs li').click(function(){
        var tab_id = jQuery(this).attr('data-tab');
        jQuery('ul.tabs li').removeClass('current');
        jQuery('.tab-content').removeClass('current');
        jQuery(this).addClass('current');
        jQuery("#"+tab_id).addClass('current');
    })


    var pro_con = jQuery('.ocpl_pro_condition').find(":selected").val();
    if(pro_con == "") {
    	jQuery('.ocpl_price_div').hide();
    	jQuery('.ocpl_category_div').hide();
    	jQuery('.ocpl_tag_div').hide();
    	jQuery('.ocpl_onsale_div').hide();
    }
    if(pro_con == "price") {
    	jQuery('.ocpl_price_div').show();
    	jQuery('.ocpl_category_div').hide();
    	jQuery('.ocpl_tag_div').hide();
    	jQuery('.ocpl_onsale_div').hide();
    }
    if(pro_con == "category") {
    	jQuery('.ocpl_category_div').show();
    	jQuery('.ocpl_price_div').hide();
    	jQuery('.ocpl_tag_div').hide();
    	jQuery('.ocpl_onsale_div').hide();
    }
    if(pro_con == "tag") {
    	jQuery('.ocpl_tag_div').show();
    	jQuery('.ocpl_category_div').hide();
    	jQuery('.ocpl_price_div').hide();
    	jQuery('.ocpl_onsale_div').hide();
    }
    if(pro_con == "onsale") {
    	jQuery('.ocpl_onsale_div').show();
    	jQuery('.ocpl_tag_div').hide();
    	jQuery('.ocpl_category_div').hide();
    	jQuery('.ocpl_price_div').hide();
    }


    var price_con = jQuery('.ocpl_price_condition').find(":selected").val();
    if(price_con == "between") {
    	jQuery('.ocpl_price_between_div').show();
    	jQuery('.ocpl_price_single_div').hide();
    }
    if(price_con == "lessthan") {
    	jQuery('.ocpl_price_single_div').show();
    	jQuery('.ocpl_price_between_div').hide();
    }	    
    if(price_con == "greaterthan") {
    	jQuery('.ocpl_price_single_div').show();
    	jQuery('.ocpl_price_between_div').hide();
    }

	jQuery('.ocpl_pro_condition').change(function() {
	    var option = jQuery(this).find('option:selected');
	    var val = option.val();
	   	//alert(val);
	   	if(val == "") {
	    	jQuery('.ocpl_price_div').hide();
	    	jQuery('.ocpl_category_div').hide();
	    	jQuery('.ocpl_tag_div').hide();
	    	jQuery('.ocpl_onsale_div').hide();
	    }
	    if(val == "price") {
	    	jQuery('.ocpl_price_div').show();
	    	jQuery('.ocpl_category_div').hide();
	    	jQuery('.ocpl_tag_div').hide();
	    	jQuery('.ocpl_onsale_div').hide();
	    }
	    if(val == "category") {
	    	jQuery('.ocpl_category_div').show();
	    	jQuery('.ocpl_price_div').hide();
	    	jQuery('.ocpl_tag_div').hide();
	    	jQuery('.ocpl_onsale_div').hide();
	    }
	    if(val == "tag") {
	    	jQuery('.ocpl_tag_div').show();
	    	jQuery('.ocpl_category_div').hide();
	    	jQuery('.ocpl_price_div').hide();
	    	jQuery('.ocpl_onsale_div').hide();
	    }
	    if(val == "onsale") {
	    	jQuery('.ocpl_onsale_div').show();
	    	jQuery('.ocpl_tag_div').hide();
	    	jQuery('.ocpl_category_div').hide();
	    	jQuery('.ocpl_price_div').hide();
	    }
	    
	});


	jQuery('.ocpl_price_condition').change(function() {
	    var option = jQuery(this).find('option:selected');
	    var val = option.val();

	    if(val == "between") {
	    	jQuery('.ocpl_price_between_div').show();
	    	jQuery('.ocpl_price_single_div').hide();
	    }
	    if(val == "lessthan") {
	    	jQuery('.ocpl_price_single_div').show();
	    	jQuery('.ocpl_price_between_div').hide();
	    }	    
	    if(val == "greaterthan") {
	    	jQuery('.ocpl_price_single_div').show();
	    	jQuery('.ocpl_price_between_div').hide();
	    }
	});
})

