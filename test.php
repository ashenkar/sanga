<?php
$file = 'somefile.txt';
$remote_file = 'readme.txt';

$ftp_server = '67.227.166.244';
$ftp_user_name = 'lvp_web';
$ftp_user_pass = 'Integration.123';

// set up basic connection
$conn_id = ftp_connect($ftp_server);

// login with username and password
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

// upload a file
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
 echo "successfully uploaded $file\n";
} else {
 echo "There was a problem while uploading $file\n";
}

// close the connection
ftp_close($conn_id);
?>
