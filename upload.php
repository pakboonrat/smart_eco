<?php
echo $_FILES["file"]["tmp_name"]."<br />";

if($_POST['submit'])
{
	$ftp_server = 'ftp.smartecosis.com';                  // Your Ftp server
	$ftp_user_name = 'smarteco';        // Your Ftp user name
	$ftp_user_pass = 'Qs0GI0F.ie9z#7';         // Your Ftp password
	 
	// file to move:
	$local_file = $_FILES["file"]["tmp_name"];
	 
	// connect to FTP server (port 21)
	$conn_id = ftp_connect($ftp_server, 2002) or die ("Cannot connect to host");
	 
	// send access parameters
	ftp_login($conn_id, $ftp_user_name, $ftp_user_pass) or die("Cannot login");
	 
	// turn on passive mode transfers (some servers need this)
	ftp_pasv($conn_id, true);
	 
	// perform file upload
	
	 if ($ftp_path = ftp_chdir($conn_id, "data")) {
			echo "Current directory is now: " . ftp_pwd($conn_id) . "\n";
	}
	
	$ftp_path = $_FILES["file"]["name"];
	$upload = ftp_put($conn_id, $ftp_path, $local_file, FTP_BINARY);
	// check upload status:
	print (!$upload) ? 'Cannot upload' : '<br />Upload complete';
	print "\n";
	 
	// close the FTP stream
	ftp_close($conn_id);
}
?>


<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="">
  <label>File:
    <input type="file" name="file" id="file" />
  </label>
  <input type="submit" name="submit" value="submit" />
</form>