$(document).ready(function() {
	PoolManager.init();
});


var PoolManager = function() {
	
	var _selectedMatches;
	
	var _lastTimeValue;
	var _lastScoreValue;
	
	function init() {
		_selectedMatches = new Array();
		$("#pool-switch-fields").click(clickSwitchFields);
		$("tr.match td.field").click(clickMatch);
		
		$("input.sc9-time-input").click(clickTimeInput);
		$("input.sc9-time-input").blur(blurTimeInput);
		
		$("input.sc9-score-input").click(clickScoreInput);
		$("input.sc9-score-input").blur(blurScoreInput);
	}

	
/* Match stuff */
	function clickMatch() {
		var tr = $(this).parent("tr");
		
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
	
	
	
	/* TIME STUFF ---- */
	
	
	function clickTimeInput() {
		var inp = $(this);
		_lastTimeValue = inp.val();
		inp.val("");
	}
	
	function blurTimeInput() {
		var inp = $(this);
		var matchId = inp.attr("id").split("-")[3];
		
		if(inp.val() == "") {
			inp.val(_lastTimeValue);
		}else{
			
			var s = inp.val().split(":");
			if(s.length == 2) {
				var hour = parseInt(s[0]);
				var minute = parseInt(s[1]);
				
				if (hour < 24 && hour > 0 && minute < 60 && minute > 0) {
					
					var timeValue = hour * 60 + minute;
					
					$.getJSON("?n=/match/settime/", {"matchId": matchId, "scheduledTime": timeValue}, onSaveTime);
					
				}else{
					alert("invalid time");
					inp.val(_lastTimeValue);
				}
			}else{
				alert("faulty format")
				inp.val(_lastTimeValue);
			}
		}
	}
	
	function onSaveTime(o) {
		if(o.error != "1") {
			
		}else{
			alert(o.message);
		}
	}
	
	
	/* SCORE STUFF ------- */
	
	
	
	function clickScoreInput() {
		var inp = $(this);
		_lastScoreValue = inp.val();
		inp.val("");
	}
	
	function blurScoreInput() {
		var inp = $(this);
		var matchId = inp.attr("id").split("-")[3];
		
		if(inp.val() == "") {
			inp.val(_lastScoreValue);
		}else{
			var s1 = inp.val().replace(" ", "");
			var s = s1.split("-");
			
			if(s.length == 2) {
				var homeScore = parseInt(s[0]);
				var awayScore = parseInt(s[1]);
				
				if(homeScore >= awayScore) {
					$("#sc9-hometeam-row-"+matchId).addClass("winner");
				}else{
					$("#sc9-hometeam-row-"+matchId).removeClass("winner");
				}
				
				if(awayScore >= homeScore) {
					$("#sc9-awayteam-row-"+matchId).addClass("winner");
				}else{
					$("#sc9-awayteam-row-"+matchId).removeClass("winner");
				}
				
				$.getJSON("?n=/match/setscore/", {"matchId": matchId, "homeScore": homeScore, "awayScore" : awayScore}, onSaveScore);

			}else{
				alert("faulty format")
				inp.val(_lastScoreValeue);
			}
		}
	}
	
	function onSaveScore(o) {
		if(o.error != "1") {
			$("#sc9-match-row-"+o.matchId).addClass("finished");
		}else{
			alert(o.message);
		}
	}
	

	return {
		init: init
	}
}();