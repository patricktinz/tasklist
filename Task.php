<?php	// UTF-8 marker äöüÄÖÜß€
require_once './Page.php';
class Task extends Page
{
    private $id, $desc, $due, $prio = array();
    private $count = 0;

    protected function __construct() {
        parent::__construct();
    }
    
    protected function __destruct() {
        parent::__destruct();
    }

    protected function getViewData(){
        $SQLAbfrage = "SELECT * FROM tbl_tasks";
        $Recordset = $this->database->query ($SQLAbfrage);

        if(!$Recordset)
            throw new Exception("Keine Einträge in der Datenbank");
            
        if($Recordset){
            $Record = $Recordset->fetch_assoc();
            $i = 0;
            while($Record){
                $this->id[$i] = $Record["id"];
                $this->desc[$i] = $Record["description"];
                $this->due[$i] = $Record["due"];
                $this->prio[$i] = $Record["prio"];
                $i++;
                $Record = $Recordset->fetch_assoc();
            }
            $Recordset->free();
            $this->count = $i;
        }
    }
    
    protected function generateView() {
        $this->getViewData();
        $this->generatePageHeader("Taskliste:");
        echo <<<EOT
        <h1>Taskliste:</h1>
        <form action="Task.php" method="post">
            <select size="{$this->count}" id="tasklist">
EOT;
        for($i = 0; $i < count($this->id); $i++){
            $html_id = htmlspecialchars($this->id[$i]);
            $html_desc = htmlspecialchars($this->desc[$i]);
            $html_due = htmlspecialchars($this->due[$i]);
            $html_prio = htmlspecialchars($this->prio[$i]);

            echo "<option id={$html_id} data-prio={$html_prio}>$html_due - $html_desc (Prio: $html_prio)</option>";
        }
        $this->count++;
        echo <<< EOT
            </select>
            <div id="buttons">
                <input type="button" value="Up" id="btnUp" class="btn" name="up" onclick="moveUp()"/>
                <input type="button" value="down" id="btnDown" class="btn" name="down" onclick="moveDown()"/>
            </div>
            <label> Beschreibung <br/>
                <textarea name="description" cols="50" rows="6" placeholder="Beschreibung"></textarea>
            </label>
            <br/>
            <label> Zu erledigen bis
                <input type="date" name="due" />
            </label>
            <label> Prio
                <input type="radio" name="prio" value="1" checked /> 1
                <input type="radio" name="prio" value="2" /> 2
                <input type="radio" name="prio" value="3" /> 3
            </label>
            <br/>
            <input type="submit" value="Hinzufügen"/>
        </form>
        <!-- Optional -->
        <div id="print">
                <input type="button" value="Print" id="btnPrint" name="print" onclick="print()"/>
        </div>
EOT;
        $this->generatePageFooter();
    }
    
    protected function processReceivedData() {
        parent::processReceivedData();
        if(isset($_POST["description"]) && isset($_POST["due"]) && isset($_POST["prio"])){
            $desc = $_POST["description"];
            $due = $_POST["due"];
            $prio = $_POST["prio"];

            if(strlen($desc)<=0 || strlen($due) <=0){
                throw new Exception("Bitte in beide Felder etwas eingeben!");
            }
            else{
                $sql_desc = $this->database->real_escape_string($desc);
                $sql_due = $this->database->real_escape_string($due);
                $sql_prio = $this->database->real_escape_string($prio);

                $SQLAbfrage = "SELECT * FROM tbl_tasks WHERE description = \"$sql_desc\" AND due = \"$sql_due\" AND prio = \"$sql_prio\"";
                $Recordset = $this->database->query ($SQLAbfrage);

                if($Recordset->num_rows > 0){
                    throw new Exception("Dieser Eintrag ist bereits vorhanden!");
                    $Recordset->free();
                }
                else{
                    $SQLAbfrage = "INSERT INTO tbl_tasks SET description = \"$sql_desc\", due = \"$sql_due\", prio = \"$sql_prio\"";
                    $Recordset = $this->database->query ($SQLAbfrage);
                    if (!$Recordset)
                        throw new Exception("Error in query: ".$this->_database->error);
                }
            }
        }
    }
  
    public static function main() 
    {
        try {
            $page = new Task();
            $page->processReceivedData();
            $page->generateView();
        }
        catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}
Task::main();
?>