document.observe("dom:loaded", function() {
	if(Autocompleter.selectortype == 'id'){
		setInstantSearch($(WP_Instant.searchfield_id));
	} else {
		$$('input[name=' + WP_Instant.searchfield_id + ']').each(function(elm){
			setInstantSearch(elm);
		});
	}
});

function setInstantSearch(elm){
	new Form.Element.DelayedObserver(elm, 0.5, function(){
	    new Ajax.Updater(WP_Instant.content_id, WP_Instant.ajaxurl + '?action=wp_instant_results&lang=' + WP_Instant.lang, {
			parameters: {s: this.lastValue},
			method: 'get'
		});
	});
	elm.autocomplete = "off";
}