<?php 
    class Contact{
        public $connection;
        public $db_name;
        public $table_name;
        public $firstname;
        public $lastname;
        public $phone;
        public $email;


        public function __construct($connection)
        {
            $this->connection = $connection;
            $this->create_table();
        }
// *** Create Contacts Table If it does NOT exist ***
        public function create_table()
        {
            $sql = "CREATE TABLE IF NOT EXISTS `whollycoders`.`table_contacts_171005_1207` (
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

        public function insert_contact()
        {
            $sql = "INSERT INTO table_contacts_171005_1207(
                contact_ID, 
                contact_firstname, 
                contact_lastname, 
                contact_phone, 
                contact_email,
                contact_date_added
            ) values(
                NULL,
                '$this->firstname',
                '$this->lastname',
                '$this->phone',
                '$this->email',
                CURRENT_TIMESTAMP
            );";
            $result = $this->process_query($sql);
        }
// *** Process Query Method ***
        public function process_query($sql)
        {
            return $result = mysqli_query($this->connection, $sql);
        }
    }

?>