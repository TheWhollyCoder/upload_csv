<?php 

    class File{
        public $connection;
        public $File_array;
// *** Class Constructor ***
        public function __construct($connection, $file_array)
        {
            $this->connection = $connection;
            $this->File_array = $file_array;
        }
// *** Check if file is a CSV FIle ***
        public function check_for_csv()
        {
            if($this->get_file_type() == 'csv')
            {
                return true;
            }else
            {
                return false;
            }
        }
// *** Create Contacts Table If it does NOT exist ***
        public function create_table()
        {
            $sql = "CREATE TABLE IF NOT EXISTS `whollycoders`.`table_contacts_171004` (
                `contact_ID` INT NOT NULL AUTO_INCREMENT , 
                `contact_firstname` VARCHAR(50) NOT NULL , 
                `contact_lastname` VARCHAR(50) NOT NULL , 
                `contact_phone` VARCHAR(20) NOT NULL , 
                `contact_email` VARCHAR(100) NOT NULL , 
                `contact_date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
                PRIMARY KEY (`contact_ID`)
                ) ENGINE = InnoDB;";
            $result = $this->process_query($sql);
        }
// *** Get File Name ***
        public function get_file_name()
        {
            return $this->File_array['file']['name'];
        }
// *** Get File Type ***
        public function get_file_type()
        {
            $filename = $this->get_file_name();
            $filename = explode(".", $filename);
            if($filename[1])
            {
                return $filename[1];
            }else
            {
                return false;
            }
        }
// *** Get Temporary File ***
        public function get_tmp_file()
        {
            return $this->File_array['file']['tmp_name'];
        }
// *** Import CSV Data ***
        public function import_csv()
        {
            if($this->check_for_csv())
            {
                
                $filename = $this->get_tmp_file();
                $handle = fopen($filename, 'r');
                $this->create_table();
                
                while($data = fgetcsv($handle))
                {
                    $firstname  = mysqli_real_escape_string($this->connection, $data[0]);
                    $lastname   = mysqli_real_escape_string($this->connection, $data[1]);
                    $phone      = mysqli_real_escape_string($this->connection, $data[2]);
                    $email      = mysqli_real_escape_string($this->connection, $data[3]);
                    if($firstname == 'firstname'){
                        $this->header = $data;
                        continue;
                    }
                    $sql = "INSERT INTO table_contacts_171004(
                        contact_ID, 
                        contact_firstname, 
                        contact_lastname, 
                        contact_phone, 
                        contact_email,
                        contact_date_added
                    ) values(
                        NULL,
                        '$firstname',
                        '$lastname',
                        '$phone',
                        '$email',
                        CURRENT_TIMESTAMP
                    );";
                    $result = $this->process_query($sql);
                }
                echo('Import Complete...<br>');
                // prewrap($this->header);
            }else
            {
                echo('Unable to upload file...<br>');
            }
        }
// *** Process Query Method ***
        public function process_query($sql)
        {
            return $result = mysqli_query($this->connection, $sql);
        }
    }

?>