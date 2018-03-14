<?php	// UTF-8 marker äöüÄÖÜß€
abstract class Page
{
    protected $database = null;
        
    protected function __construct() {
        $this->database = new MySQLi("xxx", "xxx", "", "tasks_db");
        if (mysqli_connect_errno()) 
            throw new Exception(mysqli_connect_error());
        if (!$this->database->set_charset("utf8")) 
            throw new Exception($this->database->error);
    }
    
    protected function __destruct() {
        $this->database->close(); 
    }
    
    protected function generatePageHeader($title = '') {
        $title = htmlspecialchars($title); 
        header("Content-type: text/html; charset=UTF-8");
        echo <<<EOT
        <!DOCTYPE html> 
        <html lang="de"> 
        <head> 
            <meta charset="UTF-8"/>
            <title>$title</title> 
            <link rel="stylesheet" type="text/css" href="style-sheet.css" />
            <script src="sort.js"></script> 
            <script src="data.js"></script> 
        </head> 
        <body>
EOT;
    }

    protected function generatePageFooter() {
        echo <<<EOT
        </body> 
        </html>
EOT;
    }

    protected function processReceivedData() {
        if (get_magic_quotes_gpc()){ 
            throw new Exception("Bitte schalten Sie magic_quotes_gpc in php.ini aus!");
        }
    }
}
?>