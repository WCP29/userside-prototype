var selectedBuilding = '';
var inst = '';
var floorModal = '';
var blueprint = '';
var point = {};
var secondPoint = {};
var floorClicked = '';
var clickCount = 0;
var closestEdgeC1 = '';
var startNode = '';
var click1X = '';
var click1Y = '';
var shortestPointDist = '';
var closestNode = '';
var destinationMondal = '';
var featureSelectedmodal = '';
var nextPathModal = '';
var PathFloor_ID ='';
var pfloorIDs=[];
var floorStuff = [];
var floor1 =[];
var floor2 =[];
var floor3 =[];
var floor4 =[];
var floor5 =[];
var floor6 =[];
var floor7 =[];
var floor8 =[];
var floor9 =[];

$(document).ready(function() {
	
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
	destinationClick();
	featureClick();
	featureEndPointDesired();
	
	
	floorPlans(1);
	floor1.push(floorStuff);
	floorPlans(2);
	floor2.push(floorStuff);
	floorPlans(3);
	floor3.push(floorStuff);
	floorPlans(4);
	floor4.push(floorStuff);
	floorPlans(5);
	floor5.push(floorStuff);
	floorPlans(6);
	floor6.push(floorStuff);
	floorPlans(7);
	floor7.push(floorStuff);
	floorPlans(8);
	floor8.push(floorStuff);
	floorPlans(9);
	floor9.push(floorStuff);
	
	
	// Remove this later:
	extractFullPathArray();
	nextPathButton(0);
	nextPathButton(1);
	nextPathButton(2);
	nextPathButton(3);
	nextPathButton(4);
	

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

function interactArea() {
	$('#campus-coordinates area').on('click', function(e){
		e.preventDefault();
		console.log('You clicked a place that was declared with shaping. \n');
		$('#').fadeOut('medium');
		$('#modal').fadeIn('medium');
	})
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
	$('#floor-1, #floor-2, #floor-3').on('click', function(e) {
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

function destinationClick() {
	$('#destinations-button').on('click', function(e) {
		e.preventDefault();
		blueprint.close();
		destinationModal = $('[data-remodal-id=destinations-modal]').remodal();
		destinationModal.open();
	});
}

function capitalizeEachWord(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function featureClick() {
	$('#req-bathroom, #req-elevator, #req-stairwell').on('click', function(e) {
		e.preventDefault();
		var clickedFeature = $(this).attr('id');
		var splitFeatureID = clickedFeature.split('-');
		clickedFeature = splitFeatureID[1];
		destinationModal.close();
		$('#feature-list-location').empty();
		
		$.ajax({
		            type: "GET",
		            url: "getClickedFeatures.php",
		            dataType: "json",
		            data: { feature_desired : clickedFeature},
		            success: function(response){ 
		            	console.log(response);
		            	
		            	for (var i = 0; i < response.length; i++) {
		            		$('#feature-list-location').append(
		            			'<li id=""><a href="#" class="featureDesire" id="' + response[i].featID + '_' + response[i].floor_id + '">' + capitalizeEachWord(clickedFeature) + ' - ' + response[i].buildingName + ' Floor ' + response[i].floorLevel + '</a></li>'
		            			);
		            	};
		            		
		            	
		            	featureSelectedmodal = $('[data-remodal-id=featureSelected-modal]').remodal();
		            	featureSelectedmodal.open();
		            },
		            error: function(XMLHttpRequest, textStatus, errorThrown) { 
		                console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
		            }  
			});
	});
}
function featureEndPointDesired() {
	$(document).on('click','.featureDesire', function(e) {
		e.preventDefault();
		var clickedFeature = $(this).attr('id');
		var splitID = clickedFeature.split('_');
		featureSelectedmodal.close();
		///console.log('SHOW THIS.');
		// AJAX TO JOEY
		$.ajax({
		            type: "GET",
		            url: "moretesting.php",
		            //dataType: "json",
		            data: { feature_desired : splitID[0], building_clicked : selectedBuilding, floor_clicked : floorClicked, user_clicked : point, featureFloorID : splitID[1]},
		            success: function(response){ 
		            //	console.log('SENT TO PHP');
		            	console.log('Length is: ' + response.length);
		            	console.log(response);
		            	// Open modal titled: Directions to `Feature` on `Building` Floor `#`
		            	//extractFullPathArray();
		            	
		            },
		            error: function(XMLHttpRequest, textStatus, errorThrown) { 
		                console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
		            }  
			});
		
	})
		
}
function extractFullPathArray() {
	$.ajax({
        type: "GET",
        url: "GrabTotalPathXY.php",
        dataType: "json",
        //data: { flag : '1' },
        success: function(response){
        	console.log("Length of Joey's Array: " + response.length);
        	console.log("joey array" + response);
        	
        	// Make the modal templates:
        	for (var iffy = 0; iffy <response.length; iffy++) {
        		$('footer').before('<div data-remodal-id="Path' + iffy + '"><button data-remodal-action="close" class="remodal-close"></button><h1 id="path' + iffy + '-head">You are on the X floor of Building Y</h1><div id="pathMapHolder"><svg id="Path' + iffy + '-svg"width="580" height="400" xmlns="http://www.w3.org/2000/svg"> </svg><button id="Path' + iffy + '-next">Next</button></div></div>');
        	}
        	
        	
        	for (var iffy = 0; iffy < response.length; iffy++) {
        		for (var j = 0; j < response[iffy].length; j++) {
        			var miniPathPoint = response[iffy][j] ;
        			//console.log(miniPathPoint);
        			
        			// IF THE PATH DISPLAY IS BUILDING TO BUILDING, YOU DONT HAVE FLOOR_ID
        			if (miniPathPoint.floor_id == null) {
        				//$('#Path' + iffy + '-svg').empty();
        				var newRect = document.createElementNS('http://www.w3.org/2000/svg','rect');
					    newRect.setAttribute('height','45');
					    newRect.setAttribute('width','45');
					    newRect.setAttribute('y', '54.99997' );
					    newRect.setAttribute('x','59');
					    newRect.setAttribute('fill', '#000000');
					    newRect.setAttribute('stroke','#000000');
					    newRect.setAttribute('stroke-width','5');
					    newRect.setAttribute('stroke-linecap','null');
					    newRect.setAttribute('stroke-linejoin','null');
					    newRect.setAttribute('transform','rotate(121.16, 105.5, 88.5)');
					    //console.log(i);
        				$('#Path' + iffy + '-svg').append(newRect);
        				
        				var secRec = document.createElementNS('http://www.w3.org/2000/svg','rect');
						secRec.setAttribute('height','45');
					    secRec.setAttribute('width','45');
					    secRec.setAttribute('y', '225' );
					    secRec.setAttribute('x','100');
					    secRec.setAttribute('fill', '#000000');
					    secRec.setAttribute('stroke','#000000');
					    secRec.setAttribute('stroke-width','5');
					    secRec.setAttribute('stroke-linecap','null');
					    secRec.setAttribute('stroke-linejoin','null');
					    //console.log(i);
        				$('#Path' + iffy + '-svg').append(secRec);
        				
        				var thirdRec = document.createElementNS('http://www.w3.org/2000/svg','rect');
					    thirdRec.setAttribute('height','50.060501');
					    thirdRec.setAttribute('width','50.926947');
					    thirdRec.setAttribute('y', '271.969722' );
					    thirdRec.setAttribute('x','401.536476');
					    thirdRec.setAttribute('fill', '#000000');
					    thirdRec.setAttribute('stroke','#000000');
					    thirdRec.setAttribute('stroke-width','5');
					    thirdRec.setAttribute('transform','rotate(73.5001, 462, 146.5)');
					   // console.log(iffy);
        				$('#Path' + iffy + '-svg').append(thirdRec);
        				//console.log('response[iffy] length: '+ response[iffy].length);
        				//console.log('iffy: ' + i);
        				var newPath = document.createElementNS('http://www.w3.org/2000/svg','line');
	            		if (j < (response[iffy].length - 1) ) {
	            			//console.log(j);
	            			//console.log(miniPathPoint.x + `, ` + miniPathPoint.y);
	            			//console.log(response[i][j + 1].x + ', ' + response[i][j + 1].y);
							newPath.setAttribute('x1', miniPathPoint.x);
							newPath.setAttribute('y1', miniPathPoint.y);
							newPath.setAttribute('x2', response[iffy][j + 1].x);
							newPath.setAttribute('y2', response[iffy][j + 1].y);
							newPath.setAttribute('stroke','#0000ff');
							newPath.setAttribute('stroke-width', '12.5');
							newPath.setAttribute('fill', 'none');
							//console.log(newPath);
							/// Then show the new route we just made:
							$('#Path' + iffy + '-svg').append(newPath);
	            		}
        			}
        			else {
        				console.log(miniPathPoint.floor_id);
    				 		switch(miniPathPoint.floor_id) {
    				 			case '1':
    				 				drawPathFloor(floor1, iffy);
    				 				break;
    				 			case '2':
    				 				drawPathFloor(floor2, iffy);
    				 				break;
    				 			case '3':
    				 				drawPathFloor(floor3, iffy);
    				 				break;
    				 			case '4':
    				 				drawPathFloor(floor4, iffy);
    				 				break;
    				 			case '5':
    				 				drawPathFloor(floor5, iffy);
    				 				break;
    				 			case '6':
    				 				drawPathFloor(floor6, iffy);
    				 				break;
    				 			case '7':
    				 				drawPathFloor(floor7, iffy);
    				 				break;
    				 			case '8':
    				 				drawPathFloor(floor8, iffy);
    				 				break;
    				 			case '9':
    				 				drawPathFloor(floor9, iffy);
    				 				break;
    				 		}
    				 		
					      //// Draw the routes
					      
					      var newPath = document.createElementNS('http://www.w3.org/2000/svg','line');
	            		  if (j < (response[iffy].length - 1) ) {
							newPath.setAttribute('x1', miniPathPoint.x);
							newPath.setAttribute('y1', miniPathPoint.y);
							newPath.setAttribute('x2', response[iffy][j + 1].x);
							newPath.setAttribute('y2', response[iffy][j + 1].y);
							newPath.setAttribute('stroke','#0000ff');
							newPath.setAttribute('stroke-width', '12.5');
							newPath.setAttribute('fill', 'none');
							console.log(newPath);
							$('#Path' + iffy + '-svg').append(newPath);
	            		  }
	            		  
    				}
        		}
        	}
        	
        	nextPathModal = $('[data-remodal-id=Path0').remodal();
        	nextPathModal.open();
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
        }  
	});
}



function drawPathFloor(information, iffy) {
 	for(var itr = 0; itr < information[0][0].length; itr++) {
 		//console.log(information[0][0][itr]);	
 		
        var newRect = document.createElementNS('http://www.w3.org/2000/svg','rect');
	    newRect.setAttribute('id', information[0][0][itr].svg_id);
	    newRect.setAttribute('height',42);
	    newRect.setAttribute('width',55);
	    newRect.setAttribute('y',information[0][0][itr].yCord );
	    newRect.setAttribute('x',information[0][0][itr].xCord);
	    newRect.setAttribute('fill', '#fff');
	    newRect.setAttribute('stroke','#000');
	    console.log(iffy);
	    $('#Path' + iffy + '-svg').append(newRect);
	   
 	}
		                
}

function nextPathButton(num) {
	$(document).on('click', '#Path' + num + '-next', function(e) {
		//alert('yo');
		e.preventDefault();
		var currentNextPressed = $(this).attr('id').charAt(4);
		nextPathModal.close();
		var openNext = parseInt(currentNextPressed) + 1;
		alert(currentNextPressed + '   ' + openNext );
		nextPathModal = $('[data-remodal-id=Path' + openNext + ']').remodal();
		nextPathModal.open();
		
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
// Return minimum distance between line segment ab and point
function distToLineFinal(point, a, b) { 
	return Math.sqrt(distToSegmentSquared(point, a, b));
}

function coordinatesFloor() {
	$('#displayBlues').on('click', function (event){
		window.current_x = Math.round(event.pageX - $('#displayBlues').offset().left);
        window.current_y = Math.round(event.pageY - $('#displayBlues').offset().top);
        window.current_coords = window.current_x + ', ' + window.current_y;

        	point = {x: window.current_x, y:window.current_y};
        	pathNearestToClick(point);
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
		            	shortestPointDist = '';
		            	
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
						
						   // if (clickCount == 1) {
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
						    //dijkstraDraw(closestNode, 203, clickedObject); // DONT FORGET TO PUT BACK ON OR RECONFIGURE!
		            },
		            error: function(XMLHttpRequest, textStatus, errorThrown) { 
		                console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
		            }  
		});
	
}

function dijkstraDraw(start_node, end_option, clickedObject) {
	
	$.ajax({
		            type: "GET",
		            url: "jefftestDijkstra.php",
		            dataType: "json",
		            data: { startNode : start_node, endNode :   end_option },
		            success: function(response){ 
		            	//console.log(response);
		            	$('#displayBlues').find('line').remove();
		            	for (var i = 0; i < response.length; i++) {
		            		var newPath = document.createElementNS('http://www.w3.org/2000/svg','line');
		            		if (i !== (response.length - 1) ) {
							newPath.setAttribute('id', 'step_' + i);
							newPath.setAttribute('x1', response[i].xCord);
							newPath.setAttribute('y1', response[i].yCord);
							newPath.setAttribute('x2', response[i+1].xCord);
							newPath.setAttribute('y2', response[i+1].yCord);
							newPath.setAttribute('stroke','#000000');
							newPath.setAttribute('stroke-width', '12.5');
							newPath.setAttribute('fill', 'none');
							/// Then show the new route we just made:
							$("#displayBlues").append(newPath);
		            		}
		            	 }
		            	 // Connect the route generated with the right starting point, where it was clicked:
		            	var routeFirstNode = $('#step_0');
		            	var startingPath = document.createElementNS('http://www.w3.org/2000/svg','line');
		            	startingPath.setAttribute('id', 'Step_' + -1);
						startingPath.setAttribute('x1', clickedObject.x);
						startingPath.setAttribute('y1', clickedObject.y);
						startingPath.setAttribute('x2', routeFirstNode.attr('x1'));
						startingPath.setAttribute('y2', routeFirstNode.attr('y1'));
						startingPath.setAttribute('stroke','#000000');
						startingPath.setAttribute('stroke-width', '12.5');
						startingPath.setAttribute('fill', 'none');							/// Then show the new route we just made:
						$("#displayBlues").append(startingPath);
		            },
		            error: function(XMLHttpRequest, textStatus, errorThrown) { 
		                console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
		            }  
	});
}
function floorPlans(floorID) {
	$.ajax({
        type: "GET",
        async: "true",
        url: "floorPath.php",
        dataType: "json",
        data: { floor_id : floorID },
        success: function(info){
        	floorStuff.push(info); 
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
            console.log("Status: " + textStatus); console.log("Error: " + errorThrown); 
        }  
	});
}