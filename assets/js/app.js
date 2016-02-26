$(document).ready(function() {
	console.log('jQuery running properly');

	$('#where-am-i, #find-a-room, #navigation, #footer, #begin-menu, #campus-map').hide();
	startPress();
	whereAmI();
	findRoom();
	navigationSectionShow();
	campusMapShow();



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
		$('#campus-map, #footer').fadeIn('medium');

	});
};
