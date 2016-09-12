<?php
$servername = "(local)";
$conn = new PDO('sqlsvr:server=$servername;dbname=BEATMYDJ', 'Administrateur', 'Etnagpe2017');
     
if ($conn) {
	echo "Connection OK!!!<br/><br/>";
}
else {
	echo "KO";
	die(print_r(sqlsvr_errors(), true));
}
$sql = "SELECT * FROM login";
  
foreach ($sql->query($sql) as $row) {
    print $row['mail'];
}
?>