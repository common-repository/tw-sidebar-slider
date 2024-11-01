jQuery.noConflict();
jQuery(document).ready(function($){
	//open the lateral panel
	$('.cd-btn-twitter').on('click', function(event){
		event.preventDefault();
		$('.cd-panel-twitter').addClass('is-visible');
	});
	//clode the lateral panel
	$('.cd-panel-twitter').on('click', function(event){
		if( $(event.target).is('.cd-panel-twitter') || $(event.target).is('.cd-panel-close-twitter') ) { 
			$('.cd-panel-twitter').removeClass('is-visible');
			event.preventDefault();
		}
	});
});