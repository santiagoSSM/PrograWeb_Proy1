<?php
class RegistroSenial
{
    private $nombre = "";
    private $autor = "";
    private $fecha = "";
    private $tamano = 0;
    private $descr = "";
    private $clasific = "";
    private $refSenial = "";
    private $tipoSenial = "";
    private $matSenial = "";
    private $latitud = "";
    private $longitud = "";
    private $estado = "";
    private $fechaConstr = "";

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

    function setLatitud($value){
        $this->latitud = $value;
    }

    function getLatitud(){
        return $this->latitud;
    }

    function setLongitud($value){
        $this->longitud = $value;
    }

    function getLongitud(){
        return $this->longitud;
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
 
        //crea la tabla si no existe
        $this->connection->exec("
            CREATE TABLE IF NOT EXISTS reg_signal (
                Id INTEGER PRIMARY KEY,
                nombre TEXT,
                autor TEXT,
                fecha TEXT,
                tamano INTEGER,
                descr TEXT,
                clasific TEXT,
                refSenial TEXT,
                tipoSenial TEXT,
                matSenial TEXT,
                latitud TEXT,
                longitud TEXT,
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

                $obj->setNombre($value->nombre);
                $obj->setAutor($value->autor);
                $obj->setFecha($value->fecha);
                $obj->setTamano($value->tamano);
                $obj->setDescr($value->descr);
                $obj->setClasific($value->clasific);
                $obj->setRefSenial($value->refSenial);
                $obj->setTipoSenial($value->tipoSenial);
                $obj->setMatSenial($value->matSenial);
                $obj->setLatitud($value->latitud);
                $obj->setLongitud($value->longitud);
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
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
 
        if( ! empty( $stmt ) )
        {
            $temp = $stmt->fetchObject();

            $obj = new RegistroSenial();

            $obj->setNombre($temp->nombre);
            $obj->setAutor($temp->autor);
            $obj->setFecha($temp->fecha);
            $obj->setTamano($temp->tamano);
            $obj->setDescr($temp->descr);
            $obj->setClasific($temp->clasific);
            $obj->setRefSenial($temp->refSenial);
            $obj->setTipoSenial($temp->tipoSenial);
            $obj->setMatSenial($temp->matSenial);
            $obj->setLatitud($temp->latitud);
            $obj->setLongitud($temp->longitud);
            $obj->setEstado($temp->estado);
            $obj->setFechaConstr($temp->fechaConstr);

            return $obj;
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
            'INSERT INTO reg_signal (nombre, autor, fecha, tamano, descr, clasific, refSenial, tipoSenial,
            matSenial, latitud, longitud, estado, fechaConstr) values (?,?,?,?,?,?,?,?,?,?,?,?,?)'
        );

        $stmt->bindParam(1, $reg_signal->getNombre());
        $stmt->bindParam(2, $reg_signal->getAutor());
        $stmt->bindParam(3, $reg_signal->getFecha());
        $stmt->bindParam(4, $reg_signal->getTamano(), PDO::PARAM_INT);
        $stmt->bindParam(5, $reg_signal->getDescr());
        $stmt->bindParam(6, $reg_signal->getClasific());
        $stmt->bindParam(7, $reg_signal->getRefSenial());
        $stmt->bindParam(8, $reg_signal->getTipoSenial());
        $stmt->bindParam(9, $reg_signal->getMatSenial());
        $stmt->bindParam(10, $reg_signal->getLatitud());
        $stmt->bindParam(11, $reg_signal->getLongitud());
        $stmt->bindParam(12, $reg_signal->getEstado());
        $stmt->bindParam(13, $reg_signal->getFechaConstr());

        return $stmt->execute();
    }
 
    /**
     * @param $reg_signal
     * @return bool
     */
    public function update_reg_signal( $reg_signal, $id )
    {
        $stmt = $this->connection->prepare(
            'UPDATE reg_signal SET nombre = ?, autor = ?, fecha = ?, tamano = ?, descr = ?, clasific = ?,
            refSenial = ?, tipoSenial = ?, matSenial = ?, latitud = ?, longitud = ?, estado = ?,
            fechaConstr = ? WHERE id = ?'
        );
 
        $stmt->bindParam(1, $reg_signal->getNombre());
        $stmt->bindParam(2, $reg_signal->getAutor());
        $stmt->bindParam(3, $reg_signal->getFecha());
        $stmt->bindParam(4, $reg_signal->getTamano(), PDO::PARAM_INT);
        $stmt->bindParam(5, $reg_signal->getDescr());
        $stmt->bindParam(6, $reg_signal->getClasific());
        $stmt->bindParam(7, $reg_signal->getRefSenial());
        $stmt->bindParam(8, $reg_signal->getTipoSenial());
        $stmt->bindParam(9, $reg_signal->getMatSenial());
        $stmt->bindParam(10, $reg_signal->getLatitud());
        $stmt->bindParam(11, $reg_signal->getLongitud());
        $stmt->bindParam(12, $reg_signal->getEstado());
        $stmt->bindParam(13, $reg_signal->getFechaConstr());
        $stmt->bindParam(14, $id, PDO::PARAM_INT);

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

$reg_signal = new RegSignal();
 
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

$obj->setNombre("nombre");
$obj->setAutor("autor");
$obj->setFecha("fecha");
$obj->setTamano(0);
$obj->setDescr("descr");
$obj->setClasific("clasific");
$obj->setRefSenial("refSenial");
$obj->setTipoSenial("tipoSenial");
$obj->setMatSenial("matSenial");
$obj->setLatitud("latitud");
$obj->setLongitud("longitud");
$obj->setEstado("rstado");
$obj->setFechaConstr("fechaCosntr");

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