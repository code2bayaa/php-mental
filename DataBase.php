<?php
require "DataBaseConfig.php";

class DataBase
{
    public $connect;
    public $data;
    private $sql;
    private $user;
    protected $servername;
    protected $username;
    protected $password;
    protected $databasename;

    public function __construct()
    {
        $this->connect = null;
        $this->data = null;
        $this->sql = null;
        $this->user = null;
        $dbc = new DataBaseConfig();
        $this->servername = $dbc->servername;
        $this->username = $dbc->username;
        $this->password = $dbc->password;
        $this->databasename = $dbc->databasename;
    }

    function dbConnect()
    {
        $this->connect = mysqli_connect($this->servername, $this->username, $this->password, $this->databasename);
        return $this->connect;
    }

    function prepareData($data)
    {
        return mysqli_real_escape_string($this->connect, stripslashes(htmlspecialchars($data)));
    }

    function logIn($table, $username, $password)
    {
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $this->sql = "SELECT * from " . $table . " WHERE Email = '" . $username . "' AND Password = '$password'";
        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) == 1)
            $login = true;
        else
            $login = false;

        return $login;
    }

  /*  function signUp($table, $fullname, $email, $Identification, $address, $level, $password, $telephone)
    {
        $fullname = $this->prepareData($fullname);
        $username = $this->prepareData($username);
        $password = $this->prepareData($password);
        $Identification = $this->prepareData($Identification);
        $address = $this->prepareData($address);
        $level = $this->prepareData($level);
        $email = $this->prepareData($email);
        $telephone = $this->prepareData($telephone);
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->sql =
            "INSERT INTO " . $table . " (fullname, email, Identification, address, level, password, telephone) VALUES ('" . $fullname . "','" . $email . "','" . $Identification . "','" . $address . "','" . $level . "','" . $password . "','" . $telephone . "')";
        if (mysqli_query($this->connect, $this->sql)) {
            return true;
        } else return false;
    }*/
    function getData($statement)
    {
        $this->sql = $statement;

        $result = mysqli_query($this->connect, $this->sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0){
            if(mysqli_num_rows($result) == 1)
                return $row;
            else{
                $pot = [];
                while($row = mysqli_fetch_assoc($result)){
                    array_push($pot,$row);
                }
                return $pot;
            }
        }else
            return false;
    }
    function updateData($statement)
    {
	    $PartQuery = mysqli_query($this->connect, $statement);
        if($PartQuery)
            return true;
        else
            return false;
    }
    function insertData($table,$values)
    {

        $statementOne = "";
        $statementTwo = "";
        $r = -1;
        $fin = count($values);
        foreach($values as $k => $v){
            $r++;
            if($r == 0){
                $statementOne .= "(";
                $statementTwo .= "VALUES (";
            }
            $statementOne .= $k;
            $statementTwo .= "'".$this->prepareData($v)."'";
            if($r !== ($fin - 1)){
                $statementOne .= ",";
                $statementTwo .= ",";
            }else{
                $statementOne .= ")";
                $statementTwo .= ")";
            }

        }

        $statement = "INSERT INTO " .$table. "".$statementOne. "".$statementTwo;

	    $PartQuery = mysqli_query($this->connect, $statement);
        if($PartQuery)
            return true;
        else
            return false;
    }
}

?>
