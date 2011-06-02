$(document).ready(function() {
	PoolManager.init();
});


var PoolManager = function() {
	
	var _selectedMatches;
	
	function init() {
		_selectedMatches = new Array();
		$("#pool-switch-fields").click(clickSwitchFields);
		$("tr.match").click(clickMatch);
	}
	
	function clickMatch() {
		var tr = $(this);
		
		if(tr.hasClass("active")) {
			tr.removeClass("active");
			removeSelectedRow(tr.attr("id"));
		}else{
			if(_selectedMatches.length < 2) {
				_selectedMatches.push(tr.attr("id"));
				tr.addClass("active");
			}
		}
		
		
		if(_selectedMatches.length == 2) {
			showOptionsAtObject(tr);
		}else{
			hideOptions();
		}
	} 

	function showOptionsAtObject(o) {
		l = o.offset().left;
		t = o.offset().top + 30;
		
		$("#sc9-match-options").css("left", l+"px");
		$("#sc9-match-options").css("top", t+"px");
		$("#sc9-match-options").fadeIn();
	}
	
	function hideOptions() {
		$("#sc9-match-options").fadeOut();
	}
	
	
	function clickSwitchFields() {
		var id1 = _selectedMatches[0].split("-")[3];
		var id2 = _selectedMatches[1].split("-")[3];
		
		
		var o = {"id1": id1, "id2": id2};
		
				
		$.getJSON("?n=/match/switchfields/", o, onSwitchFields);
		
		return false;
	}
	
	
	function onSwitchFields(o) {
		if(o.error == "1") {
			alert(o.message);
		}else{
			var field = $("#"+_selectedMatches[0]+" .field").html();

			$("#"+_selectedMatches[0]+" td.field").html($("#"+_selectedMatches[1]+" td.field").html());
			$("#"+_selectedMatches[1]+" td.field").html(field);
		}
		
		reset();
	}
	
	function reset() {
		for(var i = 0; i < _selectedMatches.length; i++) {
			$("#"+_selectedMatches[i]).removeClass("active");
		}
		_selectedMatches = new Array();
		
		hideOptions();
	}
	
	
	function removeSelectedRow(id) {
		for(var i = 0; i < _selectedMatches.length; i++) {
			if(_selectedMatches[i] == id) {
				_selectedMatches.splice(i, 1);
				return;
			}
		}
	}
	

	return {
		init: init
	}
}();