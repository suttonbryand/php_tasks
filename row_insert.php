<?php



const DB_SERVER="localhost";
const DB_DATABASE = "People";
const DB_TABLE = "People";
const DB_USER = "people";
const DB_PASSWD = "secret";

const INSERT_LIMIT = 1000; 

function insert_rows($rows){

	$mysqli = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWD, DB_DATABASE);

	if(!$mysqli){
		exit("Could not establish connection");
	}

	$row_count = 0;
	$query_ran = false;

	foreach($rows as $row){
		
		if($row_count == 0){
			$query = "INSERT INTO " . DB_TABLE . " (firstname,lastname,phone,email) VALUES ";
			$query_ran = false;
		}

		$query .= "('" . $row[0] . "','" . $row[1] . "','" . $row[2] . "','" . $row[3] . "'),";

		if($row_count == INSERT_LIMIT){
			run_query($mysqli,$query);
			$query_ran = true;

			echo INSERT_LIMIT . " rows processed\n";

			$row_count = 0;
		}

		else{
			$row_count++;
		}		

	}

	if(!$query_ran){
		run_query($mysqli,$query);
	}

	echo "Done processing\n";

}

function run_query($mysqli,$query){
	$mysqli->query(rtrim($query,',')) or die(mysqli_error($mysqli));
}

function test_run(){

	$rows = array();

	for($i = 0; $i < 10000; $i++){
		$rows[] = array("firstname_$i",'lastname','1231231234','address@gmail.com ');
	}

	insert_rows($rows);
}

test_run();



?>
