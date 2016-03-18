var selectedBuilding = '';
var inst = '';
var floorModal = '';
var blueprint = '';
var point = {};
var secondPoint = {};
var floorClicked = '';
var clickCount = 0;
var closestEdgeC1 = '';
var closestEdgeC2 = '';

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
	//pathNearestToClick();
	coordinatesFloor();


	//dijsktraAttempt('I','G');


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
		floorClicked = $(this).attr('id');
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
		            	//console.log(response);
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
		            	//console.log(response);
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
	})
}


function sqrExp(x) { return x * x }
function lineDist(a, b) { return sqrExp(a.x - b.x) + sqrExp(a.y - b.y) }
function distToSegmentSquared(point, a, b) {
  var lineDistanceSq = lineDist(a, b);
  if (lineDistanceSq == 0) return lineDist(point, a);   //This was originally causing the NaN values! The line is essentially a point.
  var result = ((point.x - a.x) * (b.x - a.x) + (point.y - a.y) * (b.y - a.y)) / lineDistanceSq;
  	// If result is less than zero, calculate the distance from the starting point of the line, a.
  if (result < 0) return lineDist(point, a);
  	// If result is greater than one, calculate the distance from the end point of the line, b.
  if (result > 1) return lineDist(point, b);
  	// If result the point is along the line, then find the point on the line:
  return lineDist(point, { x: a.x + result * (b.x - a.x),
                    y: a.y + result * (b.y - a.y) });
}
// Return minimum distance between line segment vw and point p
function distToLineFinal(point, a, b) { 
	return Math.sqrt(distToSegmentSquared(point, a, b));
}

function coordinatesFloor() {
	$('#displayBlues').on('click', function (event){
		window.current_x = Math.round(event.pageX - $('#displayBlues').offset().left);
        window.current_y = Math.round(event.pageY - $('#displayBlues').offset().top);
        window.current_coords = window.current_x + ', ' + window.current_y;
        clickCount++;
        if (clickCount == 1) {
        	point = {x: window.current_x, y:window.current_y};
        	pathNearestToClick(point, closestEdgeC1)
        }
        else if(clickCount == 2) {
        	secondPoint = {x: window.current_x, y:window.current_y};
        	//console.log('secondClick:' + secondPoint);
        	pathNearestToClick(secondPoint);
        }
	});
}

function pathNearestToClick(clickedSection) {
        $.ajax({    //create an ajax request to getPaths.php
		            type: "GET",
		            url: "getPaths.php", 
		            dataType: "json",
		            data: { building_clicked : selectedBuilding, floor_clicked : floorClicked},
		            success: function(response){ 
		            	var shortestDistance = '';
		            	var pathName = '';
		            	  //Test each value to see if the point clicked is close to the line clicked:
						    for (var i = 0; i < response.length; i++) {
						    		var distance = distToLineFinal(clickedSection, {x:parseFloat(response[i].x1Cord), y:parseFloat(response[i].y1Cord)}, {x:parseFloat(response[i].x2Cord), y:parseFloat(response[i].y2Cord)});
						    		console.log('Distance from: ' + response[i].svg_id+': ' + distance);
							    		if (shortestDistance == '') {
							    			shortestDistance = distance;
							    			pathName = response[i].svg_id;
							    		}
							    		else if (shortestDistance > distance) {
							    			shortestDistance = distance;
							    			pathName = response[i].svg_id;
							    		}
						    }
						    if (clickCount == 1) {
		            			console.log('The edge closest to ' + clickCount +  'st click: '+ clickedSection.x + ',' + clickedSection.y + ' is: \n' + pathName + ': ' + shortestDistance + '\n');
		            			closestEdgeC1 = pathName;
						    }
		            		// If you clicked twice, pass the closest paths to each click to find fastest path function:
		            		else if (clickCount == 2) {
		            			closestEdgeC2 = pathName;
		            			console.log('The edge closest to ' + clickCount +  'nd click: '+ clickedSection.x + ',' + clickedSection.y + ' is: \n' + pathName + ': ' + shortestDistance + '\n');
		            			// Only needs the first letter of each path.
		            			console.log(closestEdgeC1.charAt(0));
		            			console.log(closestEdgeC2.charAt(1));
		            			
		            			dijsktraAttempt(closestEdgeC1.charAt(0), closestEdgeC2.charAt(1));
		            			clickCount = 0;
		            		}
		            
		            },
		            error: function(XMLHttpRequest, textStatus, errorThrown) { 
		                console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
		            }  
		        });
		        
		        ///////ATTEMPT AT MAKING IT DONE IN PHP
		        /*
		        $.ajax({    //create an ajax request to load_page.php
		            type: "GET",
		            url: "testPointLine.php",
		            data: { building_clicked : selectedBuilding, floor_clicked : floorClicked, point : JSON.stringify(point)},
		            success: function(response){ 
		            	console.log(response);
		            },
		            error: function(XMLHttpRequest, textStatus, errorThrown) { 
		                console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
		            }  
		        });
		        */
		        
}
function createArray(length) {
	var arr = new Array(length || 0),
    i = length;

    if (arguments.length > 1) {
      	var args = Array.prototype.slice.call(arguments, 1);
        while(i--) arr[length-1 - i] = createArray.apply(this, args);
    }

    return arr;
	}


function dijsktraAttempt(start, end) {
	var map = { 
		A:{B: 82},
		B:{C: 145, F: 121},
		C:{D: 83},
		D:{C: 83},
		G:{F:136},
		F:{H:47, G: 136, B: 121},
		H:{I:213, F:47},
		I:{H: 213}
	};
	var graph = new Graph(map);
	console.log(graph.findShortestPath(start, end));

}

function whatRoomClicked() {
	$('#').on('click', function() {
		
	})
}
