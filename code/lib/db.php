<?php
#connect to the database
$dbconn = pg_pconnect("host=$pg_host port=$pg_port dbname=$pg_dbname user=$pg_dbuser password=$pg_dbpassword") or die("Could not connect");
if ($debug) {
	echo "host=$pg_host, port=$pg_port, dbname=$pg_dbname, user=$pg_dbuser, password=$pg_dbpassword<br>";
	$stat = pg_connection_status($dbconn);
	if ($stat === PGSQL_CONNECTION_OK) {
		echo 'Connection status ok';
	} else {
		echo 'Connection status bad';
		error_log("Connection status bad", 0);
	}    
}

function run_query($dbconn, $query) {
	if ($debug) {
		echo "$query<br>";
	}
	$result = pg_query($dbconn, $query);
	if ($result == False and $debug) {
		echo "Query failed<br>";
		error_log("Query failed", 0);
	}
	return $result;
}

//database functions
function get_plants($dbconn){
	$query= 
		"SELECT * from plants order by id";
return run_query($dbconn, $query);
}

function update_status($dbconn, $w_array){
	switch (sizeof($w_array)){
		case 1:
			$query = "UPDATE plants set p_status='WATERED' where id = '$w_array[0]'";
			break;
		case 2:
			$query = "UPDATE plants set p_status='WATERED' 
			where id = '$w_array[0]'
			or id = '$w_array[1]'";
			break;
		case 3:
			$query = "UPDATE plants set p_status='WATERED' 
			where id = '$w_array[0]' 
			or id = '$w_array[1]' 
			or id = '$w_array[2]'";
			break;
		case 4:
			$query = "UPDATE plants set p_status='WATERED' 
			where id = '$w_array[0]'
			or id = '$w_array[1]' 
			or id = '$w_array[2]' 
			or id = '$w_array[3]'";
			break;
		case 5:
			$query = "UPDATE plants set p_status='WATERED' 
			where id = '$w_array[0]' 
			or id = '$w_array[1]' 
			or id = '$w_array[2]' 
			or id = '$w_array[3]' 
			or id = '$w_array[4]'";
			break;
		default:
			echo "none selected";
			break;
	}
	return run_query($dbconn, $query);
	//after update get back result

}
?>