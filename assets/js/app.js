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
var startNode = '';
var click1X = '';
var click2X = '';
var click1Y = '';
var click2Y = '';
var shortestPointDist = '';
var closestNode = '';

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
	        	break;
	        	
	        case "floor-2":
	        	floorClicked = "Floor 2";
		        break;
		        
		     case "floor-3":
		     	floorClicked = "Floor 3";
		     	break;
		        
	        default:
	        		break;
	    }
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
						    newRect.setAttribute('height',42);
						    newRect.setAttribute('width',55);
						    newRect.setAttribute('y',response[i].yCord );
						    newRect.setAttribute('x',response[i].xCord);
						    newRect.setAttribute('fill', '#fff');
						    newRect.setAttribute('stroke','#000');
						    $("#displayBlues").append(newRect);
		                }

						
		            },
		            error: function(XMLHttpRequest, textStatus, errorThrown) { 
		                console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
		            }  
		        });
	    
	    
		
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
        	pathNearestToClick(point)
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
		            console.log(response);
		            	var shortestDistance = '';
		            	var pathName = '';
		            	
		            	  //Test each value to see if the point clicked is close to the line clicked:
		            	  
						    for (var i = 0; i < response.length; i++) {
						    		var distance = distToLineFinal(clickedSection, {x:parseFloat(response[i].x1Cord), y:parseFloat(response[i].y1Cord)}, {x:parseFloat(response[i].x2Cord), y:parseFloat(response[i].y2Cord)});
						    	//	console.log('Distance from path: ' + response[i].pointOne + ',' + response[i].pointTwo + ': \n ' + distance);
							    		if (shortestDistance == '') {
							    			shortestDistance = distance;
							    			pathName = response[i].pointOne + ',' + response[i].pointTwo;
							    		}
							    		else if (shortestDistance > distance) {
							    			shortestDistance = distance;
							    			startNode = response[i].pointOne;
							    			pathName = response[i].pointOne + ',' + response[i].pointTwo;
							    		}
						    }
						    
						    // GO FOR NEAREST NODE INSTEAD!
						    /*
						    for (var i = 0; i < response.length; i++) {
						    	
						    		var distance = 0;
							    		if (shortestDistance == '') {
							    			shortestDistance = distance;
							    			pathName = response[i].pointOne + ',' + response[i].pointTwo;
							    		}
							    		else if (shortestDistance > distance) {
							    			shortestDistance = distance;
							    			startNode = response[i].pointOne;
							    			pathName = response[i].pointOne + ',' + response[i].pointTwo;
							    		}
						    }
						    */
						
						    if (clickCount == 1) {
		            			//console.log('The edge closest to ' + clickCount +  'st click: '+ clickedSection.x + ',' + clickedSection.y + ' is: \n' + pathName + ': ' + shortestDistance + '\n');
		            			click1X = clickedSection.x;
		            			click1Y = clickedSection.y;
		            			clickedObject = {
		            								x: click1X,
		            								y: click1Y
		            							};
		            			closestEdgeC1 = pathName;
		            			//console.log('closest edge is: ' + closestEdgeC1);
		            			var splitEdge = closestEdgeC1.split(",");
		            			//console.log('0: ' + splitEdge[0] + '\n' + '1: ' + splitEdge[1] + '\n')
		            			 for (var i = 0; i < response.length; i++) {
		            			 	if (response[i].pointOne == splitEdge[0]) {
		            			 		locObject = {
		            			 						x: response[i].x1Cord ,
		            			 						y: response[i].y1Cord
		            			 					}
		            			 		var disPoints = lineDist(clickedObject, locObject);
		            			 		if (shortestPointDist == '') {
		            			 			shortestPointDist = disPoints;
		            			 			closestNode = response[i].pointTwo;
		            			 		}
		            			 		else if (disPoints < shortestPointDist) {
		            			 			shortestPointDist = disPoints;
		            			 			closestNode = response[i].pointOne;
		            			 		}
		            			 	}	
		            			 	else if (response[i].pointTwo == splitEdge[1]) {
		            			 		locObject = {
		            			 						x: response[i].x2Cord ,
		            			 						y: response[i].y2Cord
		            			 					}
		            			 		var disPoints = lineDist(clickedObject, locObject);
		            			 		if (shortestPointDist == '') {
		            			 			shortestPointDist = disPoints;
		            			 			closestNode = response[i].pointTwo;
		            			 		}
		            			 		else if (disPoints < shortestPointDist) {
		            			 			shortestPointDist = disPoints;
		            			 			closestNode = response[i].pointTwo;
		            			 			
		            			 		}
		            			 	}
		            			 }
		            			console.log('Shortest distance to node on path is: ' + shortestDistance + ': ' + closestNode );
		            			
						    }
						    
		            		// If you clicked twice, pass the closest paths to each click to find fastest path function:
		            		/*
		            		else if (clickCount == 2) {
		            			closestEdgeC2 = pathName;
		            			click2X = clickedSection.x;
		            			click2Y = clickedSection.y;
		            			console.log('The edge closest to ' + clickCount +  'nd click: '+ clickedSection.x + ',' + clickedSection.y + ' is: \n' + pathName + ': ' + shortestDistance + '\n');
		            			//dijsktraDraw(closestEdgeC1, closestEdgeC2, click1X, click1Y, click2X, click2Y, response);
		            		}
		            		*/
		            		clickCount = 0;
		            
		            },
		            error: function(XMLHttpRequest, textStatus, errorThrown) { 
		                console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
		            }  
		        });
		        
}

function dijsktraDraw(start, end, clickedObject) {
	
	$.ajax({    //create an ajax request to load_page.php
		            type: "GET",
		            url: "jefftestDijkstra.php",
		            data: {
		            	startNode : start ,
		            	endNode :   end
		            },
		            success: function(response){ 
		            	console.log(response);
		            },
		            error: function(XMLHttpRequest, textStatus, errorThrown) { 
		                console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
		            }  
		        });
		        
/*		        
	
	console.log(shortestPath);
	
	// Time to draw the path:
	// First delete any pre-existing routes:
	$('#displayBlues').find('line').remove();
	for (var i = 0; i <shortestPath.length-1; i++) {
			//Every shortest path will refer to an edge, makeEdge. MakeEdge is from the DB.
			var makeEdge = shortestPath[i] + shortestPath[i+1];
			console.log('Combining: ' + i + ',' + i + '+1 : ' + makeEdge);
			
			// Go through the data array and find the right SVG element so we can draw its path:
			 var edgeStoredIn = '';
			 for (var j = 0; j < data.length; j++) {
        		if (data[j].svg_id == makeEdge) {
        			//console.log('datasvg id: ' + data[j].svg_id + '\n');
            		edgeStoredIn = j;
        		}
		 	}
			//Draw the edge that contributes to the overall route:
			var newPath = document.createElementNS('http://www.w3.org/2000/svg','line');
			newPath.setAttribute('id', data[edgeStoredIn].svg_id);
			newPath.setAttribute('x1', data[edgeStoredIn].x1Cord);
			newPath.setAttribute('y1', data[edgeStoredIn].y1Cord);
			newPath.setAttribute('x2', data[edgeStoredIn].x2Cord);
			newPath.setAttribute('y2', data[edgeStoredIn].y2Cord);
			newPath.setAttribute('stroke','#000000');
			newPath.setAttribute('stroke-width', '12.5');
			newPath.setAttribute('fill', 'none');
			/// Then show the new route we just made:
			$("#displayBlues").append(newPath);
	}
*/
	
}

function whatRoomClicked() {
	$('#').on('click', function() {
		
	})
}
