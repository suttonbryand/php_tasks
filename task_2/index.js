var getTracks = function(){
	$("#trackTable tbody").html("");
	var tracksJSON = $.getJSON("process.php?artist=" + $("#artist").val(), function(data){
		var tracks = data.body;
		var tbl = "";

		$.each(tracks,function(index,track){
			tbl += "<tr><td>" + track.TrackName + "</td><td>" + track.ArtistName + "</td><td>" + track.AlbumTitle + "</td></tr>";
		});

		$("#trackTable tbody").html(tbl);
	});

};