jQuery(document).ready(function($) {
    setTimeout('show_tb()',600);
});

function show_tb()
{
	tb_show('Warning', wpcw_wpurl + '/?wpcw=message&height=300&width=500&modal=true',false);
}

function wpdoor_remove()
{
	// remove THICK BOX
	tb_remove();
	
	// Send Ajax Request to LOG
	jQuery.get(wpcw_wpurl, { wpcw: "log" });
	/*,
	  function(data){
	    alert("Data Loaded: " + data);
	  }*/
}