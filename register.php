<?php
/**
 * Description of register
 *
 * @author root
 */
require_once 'database/database.php';
class register {
    //put your code here
    private $databaseObj,$rowCount;
    function __construct() {
        $this->databaseObj=new Database();
    }
    public function registeration($regno,$name,$course,$sem){
        $this->databaseObj->query = "call register(?,?,?,?)";
        $this->databaseObj->stmt = $this->databaseObj->prepare($this->databaseObj->query);
        $this->databaseObj->stmt->bind_param('sssi',$regno,$name,$course,$sem ); //i for integer , s for string
        $this->databaseObj->stmt->execute();
        $this->rowCount= $this->databaseObj->getResultantRow();
    }
    public function successMessage(){
        if ($this-> rowCount > 0){
           return array("msg"=>"Registration complete");
        }
        else {
            return array("msg"=>"some error occured");
        }
    }
}
$Obj=new register();
$json = json_decode(file_get_contents("php://input"));
if(!is_null($json->regno) && !is_null($json->name) && !is_null($json->course) 
        && !is_null($json->semester)){
    $Obj->registeration($json->regno, $json->name, $json->course, $json->sem);
    echo json_encode($Obj->successMessage());
}else {
    echo json_encode(array("error"=>"name not set"));
}