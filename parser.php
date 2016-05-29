<?php 

$myfile = fopen("log.php", "r") or die("Unable to open file!");
$errstr= fread($myfile,filesize("log.php"));
fclose($myfile);
//echo strlen($errstr);

$errarr = explode("\n", $errstr);

//echo count($errarr);

//echo strlen('ERROR - 2015-02-21 04:35:42 -->'); 
global $unique_err;
$unique_err = array();
foreach ($errarr as $key => $eacherr) {
	//echo $value;

	$err = substr($eacherr, 31);
	$datetime = substr($eacherr, 8,19);
	//echo $err;
	add_err($err,$datetime);
	//echo '<br />';
	//echo '<br />';
}

///print_r($unique_err);
echo '<html>
<head>
<title>Parsed error file</title>
</head>
<body>
<table>
<thead>
<tr>
<td>#</td>
<td>Count of error</td>
<td>First-Occurance-Date-Time-----</td>
<td>Last-Ocurance-Date-Time-----</td>
<td>Error message</td>
</tr></thead><tbody>';
$number = 1;
foreach ($unique_err as $key => $value) {
	echo "<tr>
	<td>$number</td>
	<td>".$value['count']."</td>
	<td>".$value['fdatetime']."</td>
	<td>".$value['ldatetime']."</td>
	<td>".$value['error']."</td></tr>";
	$number++;
}

echo '</tbody></table></body></html>';

function add_err($err,$datetime)
{
	//echo 'in function';
	global $unique_err;
	// if(!in_array($err,$unique_err))
	// {
	 	//array_push( $unique_err, $err);
	//}
	$found = false;
	foreach ($unique_err as $key => $value) {
		if($err==$value['error'])
		{
			//echo 'in if';
			$found = true;
			$unique_err[$key]['count'] = $unique_err[$key]['count']+1;
			$unique_err[$key]['ldatetime'] = $datetime;

		}else{
				
				//echo 'in else';		
		}


	}
	if(!$found)
	{
		array_push( $unique_err, array('error' => $err,'count'=>1,'fdatetime'=>$datetime,'ldatetime'=>$datetime));
	}
	
}


?>