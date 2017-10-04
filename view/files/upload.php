<?php 
if(isset($_POST['upload_csv']))
{
    require('./config.php');
    if($file = $_FILES['file']['name'])
    {
        $files_array = $_FILES;
        $File = new File($connection, $files_array);
        $File->import_csv();
    }
}

?>