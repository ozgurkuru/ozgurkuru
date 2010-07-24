<?php
/*
Definations
*/
$host = $_SERVER["argv"][1];
$user = $_SERVER["argv"][2];
$pass = $_SERVER["argv"][3];
$db = $_SERVER["argv"][4];
$set = $_SERVER["argv"][5];
$collate = $_SERVER["argv"][6];

if($_SERVER["argv"][1] == "help" or $_SERVER["argv"][1] == "--help" or $_SERVER["argv"][1] == "-h" or $_SERVER["argv"][1] == ""){
	echo "
	Author Ozgur Kuru 2010 <ozgur@ozgurkuru.net>\n
	Report Bugs to ozgur@ozgurkuru.net\n
	\n
	usage:\n
	php cli.php arg1 arg2 arg3 arg4 arg5 arg6\n
	\n
	arg1: mysql host\n
	arg2: database name \n
	arg3: database user name \n
	arg4: database name \n
	arg5: character set\n
	arg6: character collate\n
	\n
	\n
	Others:\n
	--help, help, -h show this text
	";
}else{
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
        	echo ">>>>>> Processing $table's $result[Field] column...  <<<\n";		 
		}
    }
}
echo ">>> Operation Finished ...<<<\n";
}
?>

