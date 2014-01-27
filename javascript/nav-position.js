jQuery(document).ready(function(){

	var navPosition = {

		init: function(){
			navPosition.viewPort = jQuery('.nav-position-viewport');
			navPosition.title = jQuery('.nav-position-title');
			navPosition.post_id = jQuery('#post_ID').val();
			navPosition.deletePos = jQuery('.delete-position');
			navPosition.info = jQuery('.nav-position-info');

			navPosition.bindEvents();
		},

		bindEvents: function(){

			navPosition.title.draggable({
				stop: function( event, ui ){
					// console.log( ui );
					navPosition.setNavPosition();
				},
				containment: 'parent'
			});

			navPosition.deletePos.click(function(e){
				e.preventDefault();
				navPosition.deletePosition();
			});
		},

		deletePosition:function(){
			jQuery.post( ajaxurl, {action: 'save_nav_position', left: 'false', top: 'false', post_id: navPosition.post_id}, function(response){
				navPosition.info.html('');
				navPosition.title.css({
					left: 0,
					top: 0
				})
				// console.log(response);
			});
		},

		setNavPosition: function(){
			relativeX = parseInt( navPosition.title.offset().left - navPosition.viewPort.offset().left, 10 );
			relativeY = parseInt( navPosition.title.offset().top - navPosition.viewPort.offset().top, 10 );
			jQuery.post( ajaxurl, {action: 'save_nav_position', left: relativeX, top: relativeY, post_id: navPosition.post_id}, function(response){
				navPosition.info.html(relativeX + ':' + relativeY);
				// console.log(response);
			});
		}

	};

	navPosition.init();

});