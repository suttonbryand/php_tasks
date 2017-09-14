<?php

	if(isset($_GET['artist'])){

		$artist = preg_replace('/[^A-Za-z0-9\-\/\s]/', '', $_GET['artist']);

		$results = search_track($artist);

		header('Content-Type: application/json');
		echo json_success($results);

	}


function search_track($artist){

		$sql = new SQLite3("Chinook_Sqlite.sqlite") or die(json_failure("Could not connect to database"));

		$query_text = "SELECT Artist.Name as ArtistName, Track.Name as TrackName, Album.Title as AlbumTitle
						FROM Artist
						LEFT OUTER JOIN Album on Artist.ArtistId = Album.ArtistId
						LEFT OUTER JOIN Track on Album.AlbumId = Track.AlbumId
						where Artist.Name like '%$artist%'
						LIMIT 30"; 

		$query = $sql->query($query_text);
		$results = array();

		while ($table = $query->fetchArray(SQLITE3_ASSOC)) {
	        $results[] = $table;
	    }

	    return $results;

}

function json_success($body){

	$response = array();
	$response['code'] = 200;
	$response['message'] = "";
	$response['body'] = $body;
	return json_encode($response);
}

function json_failure($message = "", $code = 500){

	$response = array();
	$response['code']= $code;
	$response['message'] = $message;
	return $json_encode($response);
}

?>