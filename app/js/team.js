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
			$.getJSON("?n=/match/setspirit/", {"matchId": matchId, "side": side, "spirit": inp.val()}, onSaveSpirit);
		}
	}
	
	function onSaveSpirit(o) {
		if(o.error != "1") {
			
		}else{
			alert(o.message);
		}
	}
	
	

	return {
		init: init
	}
}();