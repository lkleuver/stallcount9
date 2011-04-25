$(document).ready(function() {
	PoolMoves.init();
});


var PoolMoves = function() {
	
	var sourceSpot = null;
	var destinationSpot = null;
	
	var _stageId;
	
	function init() {
		$("#sourceMoves ul.moves li").click(onClickSourceSpot);
		$("#destinationMoves ul.moves li").click(onClickDestinationSpot);
		_stageId = $("#stageId").html();
	}
	
	function onClickSourceSpot() {
		$(this).addClass("activeSpot");
		var o = getSpotObject($(this));
		sourceSpot = o;
		if(destinationSpot != null) {
			saveMove(sourceSpot, destinationSpot);
		}
	}
	
	function onClickDestinationSpot() {
		$(this).addClass("activeSpot");
		var o = getSpotObject($(this));
		destinationSpot = o;
		if(sourceSpot != null) {
			saveMove(sourceSpot, destinationSpot);
		}
	}
	
	function saveMove(s, d) {
		var o = new Object();
		o.sourcePoolId = s.poolId;
		o.sourceSpot = s.rank;
		o.destinationPoolId = d.poolId;
		o.destinationSpot = d.rank;
		
		$.getJSON("/?n=/stage/setmove/"+_stageId, o, onSaveMove);
		reset();
	}
	
	function onSaveMove(o) {
		if(o.error != "1") {
			window.location.href = window.location.href;
		}else{
			alert(o.message);
		}
	}
	
	function reset() {
		$("ul.moves li").removeClass("activeSpot");
		destinationSpot = null;
		sourceSpot = null;
	}
	
	
	function getSpotObject(info) {
		var idv = info.attr("id").split("-");
		return {"poolId" : idv[1], "rank" : idv[2]};
		
	}
	
	return {
		init: init
	}
}();