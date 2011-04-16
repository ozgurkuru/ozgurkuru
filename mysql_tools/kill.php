<?php
if($help==1 or $_SERVER["argv"][1] == "help" or $_SERVER["argv"][1] == "--help" or $_SERVER["argv"][1] == "-h" or $_SERVER["argv"][1] == ""){
    echo "
    Developers \n
	Ozgur Kuru	 <ozgur@ozgurkuru.net>\n
	Mustafa Sapcili <shapcy@gmail.com>\n
	Report Bugs to ozgur@ozgurkuru.net\n
    usage:\n
	php cli.php [options]\n
    Required Options: \n
	host=MYSQL_HOST
	user=MYSQL_USER
	pass=MYSQL_USER_PASS
	server=Connected Server
    
    Right Syntax:
	php cli.php hostname=localhost ....

    Wrong Syntax:
	php cli.php hostname = localhost ....
	Please dont use space after options and before values.

    Others:\n
	--help, help, -h show this text
    ";
}else{

	$parameters = $_SERVER["argv"];
	foreach($parameters as $parameter){
    	$param = explode("=",$parameter);
    	if($param[0]=="host"){
        	$host = $param[1];
    	}
    	if($param[0]=="user"){
    	    $user = $param[1];
    	}
    	if($param[0]=="pass"){
        	$pass = $param[1];
   		}
    	if($param[0]=="server"){
        	$content = $param[1];
    	}
	}		


	mysql_connect("$host","$user","$pass");
	$result = mysql_query("SHOW FULL PROCESSLIST");
	while ($row=mysql_fetch_array($result)) {
		$process_id=$row["Id"];
		if ($row["Time"] > 100 ) {
                     $sql="KILL $process_id";
                     mysql_query($sql);
                }
	}
}
?>
