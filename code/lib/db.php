<?php

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
function get_article_list($dbconn){
	$query= 
		"SELECT 
		articles.created_on as date,
		articles.aid as aid,
		articles.title as title,
		authors.username as author,
		articles.stub as stub
		FROM
		articles
		INNER JOIN
		authors ON articles.author=authors.id
		ORDER BY
		date DESC";
return run_query($dbconn, $query);
}

//student page articles
function student_get_article_list($dbconn){
	$query= 
		"SELECT 
		articles.created_on as date,
		articles.aid as aid,
		articles.title as title,
		authors.username as author,
		articles.stub as stub
		FROM
		articles
		INNER JOIN
		authors ON articles.author=authors.id
		where authors.username = 'student'
		ORDER BY
		date DESC";
return run_query($dbconn, $query);
}

function get_article($dbconn, $aid) {
	$query= 
		"SELECT 
		articles.created_on as date,
		articles.aid as aid,
		articles.title as title,
		authors.username as author,
		articles.stub as stub,
		articles.content as content
		FROM 
		articles
		INNER JOIN
		authors ON articles.author=authors.id
		WHERE
		aid='".$aid."'
		LIMIT 1";
return run_query($dbconn, $query);
}

function delete_article($dbconn, $aid) {
	$query= "DELETE FROM articles WHERE aid='".$aid."'";
	return run_query($dbconn, $query);
}

function add_article($dbconn, $title, $content, $author) {
	$stub = substr($content, 0, 30);
	$aid = str_replace(" ", "-", strtolower($title));
	$query="
		INSERT INTO
		articles
		(aid, title, author, stub, content) 
		VALUES
		('$aid', '$title', $author, '$stub', '$content')";
	return run_query($dbconn, $query);
}

function update_article($dbconn, $title, $content, $aid) {
	$query=
		"UPDATE articles
		SET 
		title='$title',
		content='$content'
		WHERE
		aid='$aid'";
	return run_query($dbconn, $query);
}

function authenticate_user($dbconn, $username, $password) {
	$name = $pw = $rs = $prs = "";
    $name = $username;
    $pw = $password;
	$statementname = "AuthQuery";
	#prepared statement 
	#for checking if values exists
	$sqlquery = '
		select authors.id as id, 
		authors.username as username,
		authors.password as password,
		authors.role as role
		FROM authors
		WHERE
		username=$1 AND password=$2
		LIMIT 1';
	
	#get value from db
	$presult = pg_query_params($dbconn, 'SELECT "password" FROM authors WHERE username = $1', array($name));
	#row 0
	if($presult){
	$row = pg_fetch_array($presult,0);
	}
	else{
		error_log("no value found" ,0);
		throw new Exception("no value");
	}
	#put received password from column 1 in a value
	$dbpw = hashvar($row[0]);

	#if hash doesnt match table exit
	if(!(password_verify($pw, $dbpw))){
		error_log("Incorrect username or password", 0);
		return;
	}
	else{
	#check for prepared statement names in statement db
	$result = pg_query_params($dbconn, 'SELECT "name" FROM pg_prepared_statements WHERE name = $1', array($statementname));
	if (pg_num_rows($result) == 0) {
    	#create statement if it doesnt exist
		$result = pg_prepare($dbconn, $statementname, $sqlquery);
	}
	#execute statement using input parameters
	$rs = pg_execute($dbconn, $statementname, array($name, $pw));
	return $rs;
}
}	

function test_input($data) {
if (!empty($data)){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
}
  return $data;
}

function hashvar($data){
   $hashp04 = password_hash($data, PASSWORD_DEFAULT);
   return $hashp04;
}
?>
