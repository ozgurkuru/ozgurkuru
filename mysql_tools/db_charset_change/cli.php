<?php
/*
Definations
*/

$parameters = $_SERVER["argv"];


if($_SERVER["argc"]>1 AND $_SERVER["argc"]<7 ){
	echo "Please control your syntax... Some parameters are missing...\n";
	$help = 1;
}
if($help==1 or $_SERVER["argv"][1] == "help" or $_SERVER["argv"][1] == "--help" or $_SERVER["argv"][1] == "-h" or $_SERVER["argv"][1] == ""){
	echo "
	Author Ozgur Kuru 2010 <ozgur@ozgurkuru.net>\n
	Report Bugs to ozgur@ozgurkuru.net\n
	\n
	usage:\n
	php cli.php [options]\n
	
	Required Options: \n
	
	host=MYSQL_HOST
	user=MYSQL_USER
	pass=MYSQL_USER_PASS
	db=MYSQL_DATABASE_NAME
	set=CHARACTER_SET
	collate=CHARACTER_COLLATE
	Right Syntax:
	php cli.php hostname=localhost ....
	
	Wrong Syntax:
	php cli.php hostname = localhost ....
	
	Please dont use space after options and before values.
	
	Others:\n
	--help, help, -h show this text
	";
}else{
	foreach($parameters as $parameter){
	$param = explode("=",$parameter);
	if($param[0]=="host"){
		$host = $param[1];
	}
	if($param[0]=="user"){
		$user = $param[1];
	}
	if($param[0]=="db"){
		$db = $param[1];
	}
	if($param[0]=="pass"){
		$pass = $param[1];
	}
	if($param[0]=="set"){
		$set = $param[1];
	}
	if($param[0]=="collate"){
		$collate = $param[1];
	}
	}
	mysql_connect("$host","$user","$pass");
	mysql_select_db("$db");
	echo ">>> Changing $db's Charset... <<<\n";
	$db_charset_change_query= mysql_query("ALTER DATABASE $db DEFAULT CHARACTER SET $set COLLATE $collate");
	$tables_query = mysql_query("SHOW TABLES");
	
	echo ">>> Scaning Tables... <<<\n";
	while($result=mysql_fetch_row($tables_query)){
	    $tables[]=$result[0];
	}
	
	echo ">>> Scaning Columns... <<<\n";
	$tables_len = count($tables);
	foreach($tables as $table){
	
	    echo ">>> Changing $table's charset...  <<<\n";
	    $table_change = mysql_query("ALTER TABLE $table DEFAULT CHARACTER SET $set COLLATE $collate");
	
	    echo ">>> Processing $table's columns...  <<<\n";
	    $columns_query=mysql_query("SHOW COLUMNS FROM $table");
	    while($result=mysql_fetch_assoc($columns_query)){
	        $types = explode('(',$result[Type]);
	        $type=$types[0];
	        if($type=="char" || $type=="varchar" || $type="longtext" || $type="mediumtext" || $type="text" || $type="tinytext"){
	        	$query=mysql_query("ALTER TABLE `$table` CHANGE `$result[Field]` `$result[Field]` $result[Type] CHARACTER SET $set COLLATE $collate NOT NULL");
	        	echo "	>>> Processing $table's $result[Field] column...  <<<\n";		 
			}
	    }
	}
	echo ">>> Operation Finished ...<<<\n";
}
?>
