<?php
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = "Jane Doe\n";
fwrite($myfile, $txt);
fclose($myfile);

$myfile2 = fopen("newfile.txt", "r") or die("Unable to open file!");
echo fread($myfile2,filesize("newfile.txt"));
fclose($myfile2);

?>