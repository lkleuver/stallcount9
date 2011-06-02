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
		showScheduler(comp[1]);
	
		return false;
	}

	function showScheduler(v) {
		var html = [];
		
		var year = 2011;
		var month = 6;
		var day = 18;
		var hour = 12;
		var minute = 15;
		

	}
	
	return {
		init: init
	}
}();