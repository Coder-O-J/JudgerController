
judgerList();
function judgerList(){
	
	$.get("api.php",{'judgerList':1},function(response){
		response = JSON.parse(response);
		$("#judgerArea").html("<table id='judgerTable'><tr><td>Name</td><td>Created</td><td>Action</td></tr></table>")
		 $.each(response, function(i, item) {
        	var $tr = $('<tr>').append(
            	$('<td>').html("<a href='judger/"+item.name+"'  target='_blank'>"+item.name+"</a>"),
            	$('<td>').html(item.created),
            	$('<td>').html("<button onclick='deleteJudger(this)' id='"+item.name+"' value='"+item.name+"'>Delete</button>")
        	).appendTo('#judgerTable');
    	});
	});
}


function createJudger(){
	$("#createJudgerBtn").html("Creating...");
	$("#createJudgerBtn").prop("disabled",true);
	$.get("api.php",{'createJudger':1},function(response){
		response = JSON.parse(response);
		judgerList();
		$("#createJudgerBtn").html("Create Judger");
		$("#createJudgerBtn").prop("disabled",false);
	});
}

function resetJudger(){
	ok = confirm('Are you want to reset all judger');
	if(!ok)return;
	
	$("#resetJudgerBtn").html("Reseting...");
	$("#resetJudgerBtn").prop("disabled",true);
	$.get("api.php",{'resetJudger':1},function(response){
		judgerList();
		$("#resetJudgerBtn").html("Reset Jugger");
		$("#resetJudgerBtn").prop("disabled",false);
	});
}

function deleteJudger(e){
	ok = confirm('Are you want to delete this judger');
	if(!ok)return;

	$("#"+e.id).html("Deleting...");
	$("#"+e.id).prop("disabled",true);
	$.get("api.php",{'deleteJudger':e.value},function(response){
		judgerList();
		$("#"+e.id).html("Delete");
		$("#"+e.id).prop("disabled",false);
	});
}

