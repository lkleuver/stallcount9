$(document).ready(function() {
	TeamManager.init();
});


var TeamManager = function() {
	
	
	var _lastSpiritScoreValue;
	
	function init() {
		
		$("input.sc9-input-spirit").click(clickSpiritInput);
		$("input.sc9-input-spirit").blur(blurSpiritInput);
	}

	
	function clickSpiritInput() {
		var inp = $(this);
		_lastSpiritScoreValue = inp.val();
		inp.val("");
	}
	
	function blurSpiritInput() {
		var inp = $(this);
		var side = inp.attr("id").split("-")[3];
		var matchId = inp.attr("id").split("-")[4];
		
		
		
		if(inp.val() == "") {
			inp.val(_lastSpiritScoreValue);
		}else{
			
			var v = parseInt(inp.val());
			if(v < 0 || v > 20) {
				alert("Spirit must be between 0 and 20");
				inp.val(_lastSpiritScoreValue);
			}else{
				$.getJSON("?n=/match/setspirit/", {"matchId": matchId, "side": side, "spirit": inp.val()}, onSaveSpirit);
			}
		}
	}
	
	function onSaveSpirit(o) {
		if(o.error != "1") {
			$("#sc9-input-spirit-"+o.side+"-"+o.matchId).addClass("saved");
		}else{
			alert(o.message);
		}
	}
	
	

	return {
		init: init
	}
}();