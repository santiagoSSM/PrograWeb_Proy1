<?php
class RegistroSenial implements JsonSerializable
{
    private $id = 0;
    private $user = "";
    private $nombre = "";
    private $autor = "";
    private $fecha = "";
    private $tamano = 0;
    private $descr = "";
    private $clasific = "";
    private $refSenial = "";
    private $tipoSenial = "";
    private $matSenial = "";
    private $kilometraje = "";
    private $cantHombres = "";
    private $estado = "";
    private $fechaConstr = "";

    function setId($value){
        $this->id = $value;
    }

    function getId(){
        return $this->id;
    }

    function setUser($value){
        $this->user = $value;
    }

    function getUser(){
        return $this->user;
    }

    function setNombre($value){
        $this->nombre = $value;
    }

    function getNombre(){
        return $this->nombre;
    }

    function setAutor($value){
        $this->autor = $value;
    }

    function getAutor(){
        return $this->autor;
    }

    function setFecha($value){
        $this->fecha = $value;
    }

    function getFecha(){
        return $this->fecha;
    }

    function setTamano($value){
        $this->tamano = $value;
    }

    function getTamano(){
        return $this->tamano;
    }

    function setDescr($value){
        $this->descr = $value;
    }

    function getDescr(){
        return $this->descr;
    }

    function setClasific($value){
        $this->clasific = $value;
    }

    function getClasific(){
        return $this->clasific;
    }

    function setRefSenial($value){
        $this->refSenial = $value;
    }

    function getRefSenial(){
        return $this->refSenial;
    }

    function setTipoSenial($value){
        $this->tipoSenial = $value;
    }

    function getTipoSenial(){
        return $this->tipoSenial;
    }

    function setMatSenial($value){
        $this->matSenial = $value;
    }

    function getMatSenial(){
        return $this->matSenial;
    }

    function setKilometraje($value){
        $this->kilometraje = $value;
    }

    function getKilometraje(){
        return $this->kilometraje;
    }

    function setCantHombres($value){
        $this->cantHombres = $value;
    }

    function getCantHombres(){
        return $this->cantHombres;
    }

    function setEstado($value){
        $this->estado = $value;
    }

    function getEstado(){
        return $this->estado;
    }

    function setFechaConstr($value){
        $this->fechaConstr = $value;
    }

    function getFechaConstr(){
        return $this->fechaConstr;
    }

    public function jsonSerialize()
    {
        return 
        [
            'Id'   => $this->getId(),
            'user'   => $this->getUser(),
            'nombre' => $this->getNombre(),
            'autor' => $this->getAutor(),
            'fecha'   => $this->getFecha(),
            'tamano'   => $this->getTamano(),
            'descr' => $this->getDescr(),
            'clasific'   => $this->getClasific(),
            'refSenial' => $this->getRefSenial(),
            'tipoSenial'   => $this->getTipoSenial(),
            'matSenial' => $this->getMatSenial(),
            'kilometraje'   => $this->getKilometraje(),
            'cantHombres' => $this->getCantHombres(),
            'estado'   => $this->getEstado(),
            'fechaConstr' => $this->getFechaConstr()
        ];
    }
}

class Users implements JsonSerializable
{
    private $user;
    private $pass;

    function setUser($value){
        $this->user = $value;
    }

    function getUser(){
        return $this->user;
    }

    function setPass($value){
        $this->pass = $value;
    }

    function getPass(){
        return $this->pass;
    }

    public function jsonSerialize()
    {
        return 
        [
            'user'   => $this->getUser(),
            'pass' => $this->getPass()
        ];
    }
}
 
class ConnectionSqlite
{
    /**
     * @var PDO
     */
    private $connection;
 
    /**
     * Connection constructor.
     */
    public function __construct()
    {
        $this->connection = new PDO('sqlite:regSignals.sqlite3') or die('Unable to open database');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->_createRegSignalTable();
    }
 
    /**
     * @return PDO
     */
    public function get_connection()
    {
        return $this->connection;
    }
 
    /**
     * Crea la tabla si no existe
     */
    private function _createRegSignalTable()
    {
        //crea la tabla reg_signal si no existe
        $this->connection->exec("
            CREATE TABLE IF NOT EXISTS reg_user (
                user TEXT PRIMARY KEY,
                pass TEXT
            )
        ");

 
        //crea la tabla reg_signal si no existe
        $this->connection->exec("
            CREATE TABLE IF NOT EXISTS reg_signal (
                Id INTEGER PRIMARY KEY,
                user TEXT,
                nombre TEXT,
                autor TEXT,
                fecha TEXT,
                tamano INTEGER,
                descr TEXT,
                clasific TEXT,
                refSenial TEXT,
                tipoSenial TEXT,
                matSenial TEXT,
                kilometraje TEXT,
                cantHombres TEXT,
                estado TEXT,
                fechaConstr TEXT
            )
        ");
    }
}

class RegSignal
{
    /**
     * @var PDO
     */
    private $connection;
 
    /**
     * reg_signal constructor.
     */
    public function __construct()
    {
        $connection = new ConnectionSqlite();
        $this->connection = $connection->get_connection();
    }
 
    /**
     * @return array|mixed
     */
    public function get_reg_signals_by_user( $user )
    {
        $arrayTemp = array();

        //get all reg_signal by user
        $reg_signal = $this->connection->query('SELECT * FROM reg_signal WHERE user = ?');
        $reg_signal->bindParam(1, $user);
        $reg_signal->execute();

        if( ! empty( $reg_signal ) )
        {
            $temp = $reg_signal->fetchAll();

            foreach ($temp as $key => $value) {
                $obj = new RegistroSenial();

                $obj->setId($value->Id);
                $obj->setUser($value->user);
                $obj->setNombre($value->nombre);
                $obj->setAutor($value->autor);
                $obj->setFecha($value->fecha);
                $obj->setTamano($value->tamano);
                $obj->setDescr($value->descr);
                $obj->setClasific($value->clasific);
                $obj->setRefSenial($value->refSenial);
                $obj->setTipoSenial($value->tipoSenial);
                $obj->setMatSenial($value->matSenial);
                $obj->setKilometraje($value->kilometraje);
                $obj->setCantHombres($value->cantHombres);
                $obj->setEstado($value->estado);
                $obj->setFechaConstr($value->fechaConstr);

                array_push($arrayTemp, $obj);
            }

        }
        return $arrayTemp;
    }

    public function get_reg_signals()
    {
        $arrayTemp = array();

        //get all reg_signal
        $reg_signal = $this->connection->query('SELECT * FROM reg_signal');
        if( ! empty( $reg_signal ) )
        {
            $temp = $reg_signal->fetchAll();

            foreach ($temp as $key => $value) {
                $obj = new RegistroSenial();

                $obj->setId($value->Id);
                $obj->setUser($value->user);
                $obj->setNombre($value->nombre);
                $obj->setAutor($value->autor);
                $obj->setFecha($value->fecha);
                $obj->setTamano($value->tamano);
                $obj->setDescr($value->descr);
                $obj->setClasific($value->clasific);
                $obj->setRefSenial($value->refSenial);
                $obj->setTipoSenial($value->tipoSenial);
                $obj->setMatSenial($value->matSenial);
                $obj->setKilometraje($value->kilometraje);
                $obj->setCantHombres($value->cantHombres);
                $obj->setEstado($value->estado);
                $obj->setFechaConstr($value->fechaConstr);

                array_push($arrayTemp, $obj);
            }

        }
        return $arrayTemp;
    }
 
    /**
     * @param $id
     * @return array|mixed
     */
    public function get_reg_signal( $id )
    {
        //get one reg_signal
        $stmt = $this->connection->query('SELECT * FROM reg_signal WHERE id = ?');
        $stmt->bindParam(1, $id);
        $stmt->execute();
 
        if( ! empty( $stmt ) )
        {
            $temp = $stmt->fetchObject();

            if( $temp )
            {
                $obj = new RegistroSenial();

                $obj->setId($temp->Id);
                $obj->setUser($temp->user);
                $obj->setNombre($temp->nombre);
                $obj->setAutor($temp->autor);
                $obj->setFecha($temp->fecha);
                $obj->setTamano($temp->tamano);
                $obj->setDescr($temp->descr);
                $obj->setClasific($temp->clasific);
                $obj->setRefSenial($temp->refSenial);
                $obj->setTipoSenial($temp->tipoSenial);
                $obj->setMatSenial($temp->matSenial);
                $obj->setKilometraje($temp->kilometraje);
                $obj->setCantHombres($temp->cantHombres);
                $obj->setEstado($temp->estado);
                $obj->setFechaConstr($temp->fechaConstr);

                return $obj;
            }
            return NULL;
        }
        return NULL;
    }
 
    /**
     * @param $reg_signal
     * @return bool
     */
    public function save_reg_signal( $reg_signal )
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO reg_signal (user, nombre, autor, fecha, tamano, descr, clasific, refSenial, tipoSenial,
            matSenial, kilometraje, cantHombres, estado, fechaConstr) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
        );

        $stmt->bindParam(1, $reg_signal->getUser());
        $stmt->bindParam(2, $reg_signal->getNombre());
        $stmt->bindParam(3, $reg_signal->getAutor());
        $stmt->bindParam(4, $reg_signal->getFecha());
        $stmt->bindParam(5, $reg_signal->getTamano(), PDO::PARAM_INT);
        $stmt->bindParam(6, $reg_signal->getDescr());
        $stmt->bindParam(7, $reg_signal->getClasific());
        $stmt->bindParam(8, $reg_signal->getRefSenial());
        $stmt->bindParam(9, $reg_signal->getTipoSenial());
        $stmt->bindParam(10, $reg_signal->getMatSenial());
        $stmt->bindParam(11, $reg_signal->getKilometraje());
        $stmt->bindParam(12, $reg_signal->getCantHombres());
        $stmt->bindParam(13, $reg_signal->getEstado());
        $stmt->bindParam(14, $reg_signal->getFechaConstr());

        return $stmt->execute();
    }
 
    /**
     * @param $reg_signal
     * @return bool
     */
    public function update_reg_signal( $reg_signal )
    {
        $stmt = $this->connection->prepare(
            'UPDATE reg_signal SET user = ?, nombre = ?, autor = ?, fecha = ?, tamano = ?, descr = ?, clasific = ?,
            refSenial = ?, tipoSenial = ?, matSenial = ?, kilometraje = ?, cantHombres = ?, estado = ?,
            fechaConstr = ? WHERE id = ?'
        );

        $stmt->bindParam(1, $reg_signal->getUser());
        $stmt->bindParam(2, $reg_signal->getNombre());
        $stmt->bindParam(3, $reg_signal->getAutor());
        $stmt->bindParam(4, $reg_signal->getFecha());
        $stmt->bindParam(5, $reg_signal->getTamano(), PDO::PARAM_INT);
        $stmt->bindParam(6, $reg_signal->getDescr());
        $stmt->bindParam(7, $reg_signal->getClasific());
        $stmt->bindParam(8, $reg_signal->getRefSenial());
        $stmt->bindParam(9, $reg_signal->getTipoSenial());
        $stmt->bindParam(10, $reg_signal->getMatSenial());
        $stmt->bindParam(11, $reg_signal->getKilometraje());
        $stmt->bindParam(12, $reg_signal->getCantHombres());
        $stmt->bindParam(13, $reg_signal->getEstado());
        $stmt->bindParam(14, $reg_signal->getFechaConstr());
        $stmt->bindParam(15, $reg_signal->getId(), PDO::PARAM_INT);

        return $stmt->execute();
    }
 
    /**
     * @param $id
     * @return bool
     */
    public function delete_reg_signal( $id )
    {
        $stmt = $this->connection->prepare('DELETE FROM reg_signal WHERE id = ?');
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
 
    /**
     * @desc Close connection
     */
    public function __destruct()
    {
        $this->connection = null;
    }
}
 
class RegUser
{
    /**
     * @var PDO
     */
    private $connection;
 
    /**
     * reg_User constructor.
     */
    public function __construct()
    {
        $connection = new ConnectionSqlite();
        $this->connection = $connection->get_connection();
    }

    public function login($user, $pass)
    {
        //get one reg_user
        $stmt = $this->connection->query('SELECT * FROM reg_user WHERE user = ? AND pass = ?');
        $stmt->bindParam(1, $user);
        $stmt->bindParam(2, $pass);
        $stmt->execute();

        return (bool)$stmt->fetchObject();
    }
 
    /**
     * @return array|mixed
     */
    public function get_reg_users()
    {
        $arrayTemp = array();

        //get all reg_user
        $reg_user = $this->connection->query('SELECT * FROM reg_user');
        if( ! empty( $reg_user ) )
        {
            $temp = $reg_user->fetchAll();

            foreach ($temp as $key => $value) {
                $obj = new Users();

                $obj->setUser($value->user);
                $obj->setPass($value->pass);

                array_push($arrayTemp, $obj);
            }

        }
        return $arrayTemp;
    }
 
    /**
     * @param $id
     * @return array|mixed
     */
    public function get_reg_user( $user )
    {
        //get one reg_user
        $stmt = $this->connection->query('SELECT * FROM reg_user WHERE user = ?');
        $stmt->bindParam(1, $user);
        $stmt->execute();
 
        if( ! empty( $stmt ) )
        {
            $temp = $stmt->fetchObject();

            $obj = new Users();

            $obj->setUser($temp->user);
            $obj->setPass($temp->pass);

            return $obj;
        }
        return NULL;
    }
 
    /**
     * @param $reg_user
     * @return bool
     */
    public function save_reg_user( $reg_user )
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO reg_user (user, pass) values (?,?)'
        );

        $stmt->bindParam(1, $reg_user->getUser());
        $stmt->bindParam(2, $reg_user->getPass());

        return $stmt->execute();
    }
 
    /**
     * @param $reg_user
     * @return bool
     */
    public function update_reg_user( $reg_user, $user )
    {
        $stmt = $this->connection->prepare(
            'UPDATE reg_user SET user = ?, pass = ? WHERE user = ?'
        );

        $stmt->bindParam(1, $reg_user->getUser());
        $stmt->bindParam(2, $reg_user->getPass());
        $stmt->bindParam(3, $user);

        return $stmt->execute();
    }
 
    /**
     * @param $id
     * @return bool
     */
    public function delete_reg_user( $user )
    {
        $stmt = $this->connection->prepare('DELETE FROM reg_user WHERE user = ?');
        $stmt->bindParam(1, $user);
        return $stmt->execute();
    }
 
    /**
     * @desc Close connection
     */
    public function __destruct()
    {
        $this->connection = null;
    }
}

/**
 * @desc Get all reg_signal
 * print_r($reg_signal->get_reg_signals());
 */
 
/**
 * @desc Find a sigle reg_signal by id
 * $reg_signal->get_reg_signal(2);
 */
 
/*
  @desc Save a reg_signal

$obj = new RegistroSenial();

$obj->setUser("Santiago");
$obj->setNombre("nombre");
$obj->setAutor("autor");
$obj->setFecha("fecha");
$obj->setTamano(0);
$obj->setDescr("descr");
$obj->setClasific("clasific");
$obj->setRefSenial("refSenial");
$obj->setTipoSenial("tipoSenial");
$obj->setMatSenial("matSenial");
$obj->setKilometraje("kilometraje");
$obj->setCantHombres("cantHombres");
$obj->setEstado("rstado");
$obj->setFechaConstr("fechaCosntr");

$reg_signal = new RegSignal();

$reg_signal->save_reg_signal($obj);
  
*/
 
/**
 * @desc Update a reg_signal
 * $reg_signal->update_reg_signal((object)array("title" => "Nuevo reg_signal 2 actualizado", "content" => "Nuevo content 2", "id" => 2));
 */
 
/**
 * @desc Delete a reg_signal by id
 * $reg_signal->delete_reg_signal(2);
 */
?>