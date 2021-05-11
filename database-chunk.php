<?php
// FORMULATE Standart server response
function verbose($ok=1,$info=""){
    if($ok==0){ http_response_code(400);}
    die(json_encode([
        "ok" => $ok,
        "info" => $info
    ]));
}

// INVALID UPLOAD
if(empty($_FILES) || $_FILES['file']['error']){
    verbose(0, "Failed to move uploaded file");
}


// UPLOAD DESTINATION
$filePath = __DIR__ . DIRECTORY_SEPARATOR . "databasefile";
if(!file_exists($filePath)){
    if(!mkdir($filePath, 0777, true)){
        verbose(0, "Failed to create ".$filePath);
    }
}



$fileName = isset($_REQUEST['name'])?$_REQUEST['name'] : $_FILES["file"]["name"];
// change file name 
$fileNameCmps = explode(".", $fileName);
$fileName = $_FILES['file']['name'];
$fileExtension = strtolower(end($fileNameCmps));
$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
//  allow file extension
$allowedfileExtensions = array('jpg', 'gif', 'png', 'txt', 'xls', 'doc', 'xlsx', 'docx');
if (!in_array($fileExtension, $allowedfileExtensions))
			{ 
				verbose(0, "file not in : ");
				 echo "<script>alert('ลบมูลเรียบร้อย !');</script>";
			} else {



					$filePath = $filePath. DIRECTORY_SEPARATOR . $newFileName;




					// DEAL WITH CHUNKS
					$chunk = isset($_REQUEST["chunk"])?$_REQUEST["chunk"]:0;
					$chunks = isset($_REQUEST["chunks"])?$_REQUEST["chunks"]:0;
					$out = @fopen("{$filePath}.part",$chunk==0?"wb":"ab");
					if($out){
						$in = @fopen($_FILES["file"]["tmp_name"],"rb");
						if($in){
							while($buff=fread($in, 4096)){ fwrite($out, $buff);}
						}else{
							verbose(o,"Failed to open input stream");
						}
						@fclose($in);
						@fclose($out);
						@unlink($_FILES["file"]["tmp_name"]);
					}else{
						verbose(0,"Failed to open output stream");
					}

					// CHECK FULL FILE UPLOADED
					if(!$chunks || $chunk == $chunks - 1){
						rename("{$filePath}.part", $filePath);
					}
					verbose(1,"Upload OK");
			}