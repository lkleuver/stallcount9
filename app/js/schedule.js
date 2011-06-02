$(document).ready(function() {
	Schedule.init();
});


var Schedule = function() {
	
	var _targetId;
	
	function init() {
		$("a.sc9-schedule").click(scheduleClick);
	}
	
	
	
	function scheduleClick() {
		var a = $(this);
		var comp = a.attr('href').split("/");
		
		_targetId = comp[0];
		
		
		
		
		return false;
	}
	
	return {
		init: init
	}
}();