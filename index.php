<html>
<head>
<title> Test </title>

</head>
<body>



<?php
//print phpinfo();
echo "hello world";
?>



<?php
require_once "connection.php";
echo "<br />". $db;



ini_set('display_errors','On');
$stid = oci_parse($conn, 'SELECT * FROM Sites');
$err=oci_execute($stid);
echo $err;

echo "<table border='1'>\n";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    echo "</tr>\n";
}
echo "</table>\n";





oci_close($conn);
?>


</body>
</html>
