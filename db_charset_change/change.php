<?php
include('config.php');
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
                if($type=="char" or $type=="varchar" or $type=="longtext" or $type="text"){
                        $query=mysql_query("ALTER TABLE `$table` CHANGE `$result[Field]` `$result[Field]` $result[Type] CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
                }
        }
}
echo ">>> Operation Finished ...<<<\n";
?>

