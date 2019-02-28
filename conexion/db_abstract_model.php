<?php

class DBAbstractModel
{
    /*DATOS PRUEBAS:
        private static $db_host = 'SIHOWINSRVP';
        private static $db_user = 'jgomez';
        private static $db_pass = '12qwaszX';

      DATOS PRODUCCION:
        private static $db_host = 'SIHOWINSRV';
        private static $db_user = 'jgomez';
        private static $db_pass = '12qwaszX';
    */
    private static $db_host = 'SIHOWINSRV';
    private static $db_user = 'jgomez';
    private static $db_pass = '12qwaszX';
    protected $db_name = '';
    protected $query;
    protected $rows = array();
    public $conn;
    public $res;
    
    #Los metodos
    
    //Conectarse a la BD
    public function open_connection(){
        $srv=self::$db_host;
        $opc=array("Database"=>$this->db_name, "CharacterSet"=>"UTF-8", "UID"=>self::$db_user, "PWD"=>self::$db_pass);
        $this->conn = sqlsrv_connect($srv,$opc) or die (print_r('Error al conectar con la Base de Datos SQLSRV !!! Favor de Informar a Sistemas!!!'));
        #(print_r(sqlsrv_errors(), true));
    }
    
    //Desconectar la BD
    public function close_connection(){
        sqlsrv_close($this->conn);
    }
}
?>
