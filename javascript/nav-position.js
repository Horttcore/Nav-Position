jQuery(document).ready(function(){

	var navPosition = {

		init: function(){
			navPosition.viewPort = jQuery('.nav-position-viewport');
			navPosition.title = jQuery('.nav-position-title');
			navPosition.post_id = jQuery('#post_ID').val();

			navPosition.bindEvents();
		},

		bindEvents: function(){
			/*
			navPosition.viewPort.click(function(e){
				navPosition.setNavPosition(e);
			});
			*/
			navPosition.title.draggable({
				stop: function( event, ui ){
					console.log( ui );
					navPosition.setNavPosition();
				},
				containment: 'parent'
			});
		},

		setNavPosition: function(){
			relativeX = parseInt( navPosition.title.offset().left - navPosition.viewPort.offset().left, 10 );
			relativeY = parseInt( navPosition.title.offset().top - navPosition.viewPort.offset().top, 10 );
			jQuery.post( ajaxurl, {action: 'save_nav_position', left: relativeX, top: relativeY, post_id: navPosition.post_id}, function(response){
				console.log(response);
			});
		}

	};

	navPosition.init();

});