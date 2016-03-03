$(document).ready(function() {
	console.log('jQuery running properly');

	$('#where-am-i, #find-a-room, #navigation, #footer, #begin-menu, #campus-map, #modal').hide();
	
	
	$('map').imageMapResize();
	
	startPress();
	whereAmI();
	findRoom();
	navigationSectionShow();
	campusMapShow();
	//campusMapCoordinates();
	interactArea();
	customRightClickMenu();


});

function startPress() {
	$('#begin-button').on('click', function() {
		$('#where-am-i,#find-a-room, #navigation, #footer, #campus-map').hide();
		$('#begin-menu').fadeIn('medium');
	});
};


function whereAmI() {
	$('#smenuc-where, #side-where, #where-link, #side-link3').on('click', function() {
		console.log('where clicked.');
		$('#find-a-room, #navigation, #footer, #campus-map').hide();
		$('#where-am-i').fadeIn('medium');
	});
};

function findRoom() {
	$('#smenuc-find, #side-find, #find-link, #side-link4').on('click', function() {
		$('#where-am-i, #navigation, #footer, #campus-map').hide();
		$('#find-a-room').fadeIn('medium');
	});
};

function navigationSectionShow() {
	$('#smenuc-navig, #side-nav, #navig-link, #side-link5').on('click', function() {
		$('#where-am-i, #find-a-room, #campus-map').hide();
		$('#navigation').fadeIn('medium');

	});
};

function campusMapShow() {
	$('#smenu-campmap, #side-map, #navig-link, #side-link6').on('click', function() {
		$('#where-am-i, #find-a-room, #navigation').hide();
		$('#campus-map').fadeIn('medium');

	});
};
/*function campusMapCoordinates() {
	$('#span-image-holder').on('click', function(event) {
		console.log('you clicked. \n');
        window.current_x = Math.round(event.pageX - $('#span-image-holder').offset().left);
        window.current_y = Math.round(event.pageY - $('#span-image-holder').offset().top);
        window.current_coords = window.current_x + ', ' + window.current_y;
        console.log("page: " + event.pageX + "," + event.pageY);
        console.log(($('#span-image-holder').offset().left) + "," + ($('#span-image-holder').offset().top));
        console.log(window.current_coords);
        
        loadModalForBuilding(window.current_x, window.current_y);
        
	});
}
function loadModalForBuilding(xCord, yCord) {
	if (xCord >= 59 && xCord <= 329 && yCord >= 261 && yCord <= 476) {
		//load the modal for floors in this building
		alert('this bull works. \n');
	}
	else {
		console.log('waiting for click. \n');
	}
/*	else if () {
		
	}
	else if () {
		
	}
	
} */

function interactArea() {
	$('#campus-coordinates area').on('click', function(e){
		e.preventDefault();
		console.log('You clicked a place that was declared with shaping. \n');
		$('#').fadeOut('medium');
		$('#modal').fadeIn('medium');
	})
}
function modalPress() {
	
}
function customRightClickMenu() {
	$("#svg-map").bind("contextmenu", function (event) {
    
	    // Avoid the real one
	    event.preventDefault();
	    
	    // Show contextmenu
	    $(".custom-menu").finish().toggle(100).
	    
	    // In the right position (the mouse)
	    css({
	        top: event.pageY + "px",
	        left: event.pageX + "px"
	    });
	});


	// If the document is clicked somewhere
	$("#svg-map").bind("mousedown", function (e) {
	    
	    // If the clicked element is not the menu
	    if (!$(e.target).parents(".custom-menu").length > 0) {
	        
	        // Hide it
	        $(".custom-menu").hide(100);
	    }
	});


	// If the menu element is clicked
	$(".custom-menu li").click(function(){
	    
	    // This is the triggered action name
	    switch($(this).attr("data-action")) {
	        
	        // A case for each action. Your actions here
	        case "first": alert("first"); break;
	        case "second": alert("second"); break;
	        case "third": alert("third"); break;
	    }
	  
	    // Hide it AFTER the action was triggered
	    $(".custom-menu").hide(100);
	  });
}