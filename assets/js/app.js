var selectedBuilding = '';
var inst = '';
var floorModal = '';
var blueprint = '';

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
	clickMap();
	clickRoomsModal();
	whatFloorClick();
	pathNearestToClick();


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


	// If the svg-map is clicked somewhere
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
	        case "first": alert("I am Here"); break;
	        case "second": alert("Navigate Me"); break;
	        case "third": alert("Here are the floors (proof of concept)"); break;
	    }
	  
	    // Hide it AFTER the action was triggered
	    $(".custom-menu").hide(100);
	  });
}
function clickMap() {
	$(".mapSVGClass").on('click', function() {
		
			inst = $('[data-remodal-id=buildingModal]').remodal();
		
		var svgID = $(this).attr('id');
		switch(svgID) {
	        
	        // A case for each action. Your actions here
	        case "UU": 
	        	$("#UU").css({
            		"fill": "red"
        		});
        		selectedBuilding = "University Union";
        		$('#Modal-Head1, #modal-floorshead').empty().append(selectedBuilding);
        		inst.open();
	        	break;
	        case "svg_2": 
	        	$("#svg_2").css({
            		"fill": "yellow"
        		});
	        	break;
	        case "svg_3":
	        	$("#svg_3").css({
            		"fill": "orange"
        		});
	        	break;
	        case "GBL":
	        	$("#GBL").css({
            		"fill": "pink"
        		});
        		selectedBuilding = "Glenn G. Bartle Library";
        		$('#Modal-Head1, #modal-floorshead').empty().append(selectedBuilding);
        		inst.open();
	        	break;
	        case "EB":
	        	$("#EB").css({
            		"fill": "red"
        		});
        		selectedBuilding = "Engineering Building";
        		$('#Modal-Head1, #modal-floorshead').empty().append(selectedBuilding);
        		inst.open();
	        	break;
	    }
	})
}
function clickRoomsModal() {
	$('#modalRoomLink').on('click', function(e) {
		e.preventDefault();
		inst.close();
		floorModal = $('[data-remodal-id=floorsModal]').remodal();
		floorModal.open();
		
	})
}
function whatFloorClick() {
	$('#floor-1, #floor-2').on('click', function(e) {
		var floorClicked = $(this).attr('id');
		e.preventDefault();
		
			switch(floorClicked) {
	        
	        // A case for each action. Your actions here
	        case "floor-1": 
	        	floorClicked = "Floor 1";
	        	$('#modal-blueprinthead').empty().append(selectedBuilding + ' - ' + floorClicked);
	        	// Send call to server to grab information from SQL to draw out the SVG:
	        	
	        	$.ajax({    //create an ajax request to load_page.php
		            type: "GET",
		            url: "UIgrabMap.php",
		            dataType: "json",
		            data: { building_clicked : selectedBuilding, floor_clicked : floorClicked},
		            success: function(response){
		            	$("#displayBlues").empty();
		                for (var i = 0; i < response.length; i++) {
			                var newRect = document.createElementNS('http://www.w3.org/2000/svg','rect');
						    newRect.setAttribute('id', response[i].svg_id);
						    newRect.setAttribute('height',response[i].height);
						    newRect.setAttribute('width',response[i].width);
						    newRect.setAttribute('y',response[i].yCord );
						    newRect.setAttribute('x',response[i].xCord);
						    $("#displayBlues").append(newRect);
		                }


		            },
		            error: function(XMLHttpRequest, textStatus, errorThrown) { 
		                console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
		            }  
		        });
	        	break;
	        	
	        case "floor-2":
	        	floorClicked = "Floor 2";
	        	$('#modal-blueprinthead').empty().append(selectedBuilding + ' - ' + floorClicked);
	        	
	        	$.ajax({    //create an ajax request to load_page.php
		            type: "GET",
		            url: "UIgrabMap.php", 
		            dataType: "json",
		            data: { building_clicked : selectedBuilding, floor_clicked : floorClicked},
		            success: function(response){ 
		            	$("#displayBlues").empty();
		                 for (var i = 0; i < response.length; i++) {
			                var newRect = document.createElementNS('http://www.w3.org/2000/svg','rect');
						    newRect.setAttribute('id', response[i].svg_id);
						    newRect.setAttribute('height',response[i].height);
						    newRect.setAttribute('width',response[i].width );
						    newRect.setAttribute('y',response[i].yCord );
						    newRect.setAttribute('x',response[i].xCord);
						    $("#displayBlues").append(newRect);
		                 }
		            },
		            error: function(XMLHttpRequest, textStatus, errorThrown) { 
		                console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
		            }  
		        });
		        
	        default:
	        		break;
	    }
		
		floorModal.close();
		blueprint = $('[data-remodal-id=blueprintModal]').remodal();
		blueprint.open();
		console.log('worked.');
	})
}

function pathNearestToClick() {
	$('#displayBlues').on('click', function (event){
		window.current_x = Math.round(event.pageX - $('#displayBlues').offset().left);
        window.current_y = Math.round(event.pageY - $('#displayBlues').offset().top);
        window.current_coords = window.current_x + ', ' + window.current_y;
        return {x: window.current_x, y:window.current_y};
	})
}






function whatRoomClicked() {
	$('#').on('click', function() {
		
	})
}
