<?php
$statusMsg = '';

if(isset($_POST["krijoFOTO"])){
    krijoFoto();
}

function krijoFoto() {
    global $conn;
    // File upload path
    $targetDir = "./images/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
   


    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (!empty($_FILES["file"]["name"])) {
        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','gif','pdf');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                // Insert image file Foto_prod into database
               
                echo $targetFilePath;
                $insert = $conn->query("INSERT into galeria (Foto) VALUES ('$targetFilePath')");
          
                if ($insert) {
                    $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
                } else {
                    $statusMsg = "File upload failed, please try again.";
                }
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            } 
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }
    } else {
        $statusMsg = 'Please select a file to upload.';
    }
}
// Display status message
echo $statusMsg;