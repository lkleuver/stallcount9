$(document).ready(function() {
	ManualRanking.init();
});


var ManualRanking = function() {
	
	var _teamList;
	
	function init() {
		_teamList = $("#sc9-team-list")
		if(_teamList.length > 0) {
			_teamList.sortable({stop:onStopSorting});
        }
	}
	
	
	function onStopSorting() {
        var datas = _teamList.find("span.data");
        var result = new Array();
        for(var i = 0; i < datas.length; i++) {
               result.push(datas.eq(i).html());
        }
        	
        var poolId = $("#sc9-pool-id").html();
        
    	
        var o = {"poolId": poolId , "ranks": result.join(",")};
        
        _teamList.find("div.rank").each(function(n) {
        	$(this).html(n + 1);
        });
        
		$.getJSON("?n=/pool/rankteams/", o, onRankTeams);
	}
	
	function onRankTeams(o) {
		if(o.error != "1") {
			
		}else{
			alert(o.message);
		}
	}

	return {
		init: init
	}
}();