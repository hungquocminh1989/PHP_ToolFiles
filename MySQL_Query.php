<?php
define('SERVERNAME', '');
define('USERNAME', '');
define('PASSWORD', '');
define('DBNAME', '');

try{
	switch ($_POST["mode"]) {
	    case "CREATE_ACC[INSERT]":
	    	$res = insert_account_autoreg();
	    	echo $res;
	        break;
	    case "CHECK_LICENSE[SELECT]":
	    	$res = check_license();
	    	print json_encode($res);
	        break;
	    case "REQUEST_LICENSE[INSERT]":
	    	$res = request_license();
	    	echo $res;
	        break;   
	    case "ACTIVE_LICENSE[UPDATE]":
	    	$res = active_license();
	    	echo $res;
	        break;     
	    case "TEST":
	        $sql = "SELECT * FROM wp_users";
	    	$res = command_select($sql);
	    	print json_encode($res);
	        break;    
	}
} 
catch (Exception $e) {
	echo "Occur error: ".$e->getMessage();
}

/**
* ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
* Function framework
*/

function get_connection(){
	// Create connection
	$conn = new mysqli(SERVERNAME, USERNAME, PASSWORD, DBNAME);
	
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
	return $conn;
}

function command_select($sql){
	try{
		$conn = get_connection();
		
		$result = $conn->query($sql);
		$rows = array();
		if ($result->num_rows > 0) {
			while($r = mysqli_fetch_assoc($result)) {
				$rows[] = $r;
			}
		}
		
		$conn->close();
		
		return $rows;
		
	} catch (Exception $e) {
		return "Error command_select: ".$e->getMessage();
	}
}

function command_query($sql){
	try{
		$conn = get_connection();
		
		if ($conn->query($sql) === TRUE) {
	    	echo "OK";
		} 
		else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
		
		$conn->close();
		
	} catch (Exception $e) {
		return "Error command_query: ".$e->getMessage();
	}
}

/**
* ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
* Function customize
*/

function check_license(){
	if(isset($_POST["client_key"]) == TRUE){
		$client_key = mysql_real_escape_string($_POST["client_key"]);
		$sql_select = "
				SELECT license_date FROM  m_active
				WHERE server_key = MD5('$client_key') 
					AND client_key = '$client_key'
					AND license_date > NOW() 
					AND active_flg = 1
					AND del_flg = 0;
		";
		$res = command_select($sql);
		
		return $res;
	}
	else{
		return "Missing paramater";
	}
}

function active_license(){
	if(
		isset($_POST["client_key"]) == TRUE
	){
		$client_key = mysql_real_escape_string($_POST["client_key"]);
		
		$sql_insert = "
			UPDATE m_active
			SET active_flg = 1,
				server_key = MD5('$client_key'),
				upd_datetime = NOW()
			WHERE del_flg = 0
				AND client_key = '$client_key';
		";
		
		$res = command_query($sql_insert);
		
		return $res;
	}
	else{
		return "Missing paramater";
	}
}

function request_license(){
	if(
		isset($_POST["client_key"]) == TRUE &&
		isset($_POST["client_info"]) == TRUE
	){
		$client_key = mysql_real_escape_string($_POST["client_key"]);
		$client_info = mysql_real_escape_string($_POST["client_info"]);
		
		$sql_insert = "
			INSERT INTO m_active 
			( 	
				client_key,
				client_info,
				active_flg,
				del_flg,
				add_datetime,
				upd_datetime 
			)
			VALUES
			(
				'$client_key' ,
				'$client_info' ,
				0 ,
				0 ,
				NOW(),
				NOW()
			);
		";
		
		$res = command_query($sql_insert);
		
		return $res;
	}
	else{
		return "Missing paramater";
	}
}

function insert_account_autoreg()
{
	if(
		isset($_POST["m_active_id"]) == TRUE && 
		isset($_POST["username"]) == TRUE && 
		isset($_POST["password"]) == TRUE && 
		isset($_POST["cookie"]) == TRUE && 
		isset($_POST["access_token"]) == TRUE && 
		isset($_POST["reg_status"]) == TRUE
	){
		$m_active_id = mysql_real_escape_string($_POST["m_active_id"]);
		$username = mysql_real_escape_string($_POST["username"]);
		$password = mysql_real_escape_string($_POST["password"]);
		$cookie = mysql_real_escape_string($_POST["cookie"]);
		$access_token = mysql_real_escape_string($_POST["access_token"]);
		$reg_status = mysql_real_escape_string($_POST["reg_status"]);
		
		$sql_insert = "
			INSERT INTO m_result 
			( 	
				m_active_id,
				username,
				password,
				cookie,
				access_token,
				reg_status,
				del_flg,
				add_datetime,
				upd_datetime 
			)
			VALUES
			(
				$m_active_id ,
				'$username' ,
				'$password' ,
				'$cookie' ,
				'$access_token' ,
				$reg_status ,
				0 ,
				NOW(),
				NOW()
			);
		";
		
		$res = command_query($sql_insert);
		
		return $res;
	}
	else{
		return "Missing paramater";
	}
}
?>