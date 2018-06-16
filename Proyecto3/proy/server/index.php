<?php
	require("Toro.php");
	require("dataCrtl.php");
	require("error.php");

	class DBHandler {
		function init() {
			$reg_signal = new RegSignal();
		}
		function get($user=null, $id=-1) {
			$dbh = $this->init();
			try {
				$regSignal = new RegSignal();

				if ($id!=-1) {
					echo json_encode($regSignal->get_reg_signal( $id ));
				} else {
					if ($user!=null) {
						echo json_encode($regSignal->get_reg_signals_by_user( $user ));
					} else {
						echo json_encode($regSignal->get_reg_signals());
					}
				}
			} catch (Exception $e) {
				error(101,"failed in get");
			}
		}
		function put($id=null) {
			$dbh = $this->init();
            try {
                $_PUT=json_decode(file_get_contents("php://input"), True);
                var_dump(file_get_contents('php://input'));
                $obj = new RegistroSenial();

				$obj->setUser($_PUT['user']);
                $obj->setNombre($_PUT['nombre']);
                $obj->setAutor($_PUT['autor']);
                $obj->setFecha($_PUT['fecha']);
                $obj->setTamano($_PUT['tamano']);
                $obj->setDescr($_PUT['descr']);
                $obj->setClasific($_PUT['clasific']);
                $obj->setRefSenial($_PUT['refSenial']);
                $obj->setTipoSenial($_PUT['tipoSenial']);
                $obj->setMatSenial($_PUT['matSenial']);
                $obj->setLatitud($_PUT['latitud']);
                $obj->setLongitud($_PUT['longitud']);
                $obj->setEstado($_PUT['estado']);
                $obj->setFechaConstr($_PUT['fechaConstr']);
				
				$regSignal = new RegSignal();

				$regSignal->save_reg_signal($obj);

            } catch (Exception $e) {
				$dbh->rollBack();
				error(101,"failed in put");
            }
		}
		function delete($id=null) {
			$dbh = $this->init();
			try {
				$regSignal = new RegSignal();

				$regSignal->delete_reg_signal($id);            

            } catch (Exception $e) {
				$dbh->rollBack();
				error(101,"failed in post");
            }
		}
		function post($id=null) {
			$dbh = $this->init();
            try {
				$_POST=json_decode(file_get_contents('php://input'), True);
                if ($_POST['method']=='put')
					return $this->put($id);
				if ($_POST['method']=='delete')
					return $this->delete($id);
					
				$obj = new RegistroSenial();

				$obj->setId($_POST['Id']);
				$obj->setUser($_POST['user']);
				$obj->setNombre($_POST['nombre']);
				$obj->setAutor($_POST['autor']);
				$obj->setFecha($_POST['fecha']);
				$obj->setTamano($_POST['tamano']);
				$obj->setDescr($_POST['descr']);
				$obj->setClasific($_POST['clasific']);
				$obj->setRefSenial($_POST['refSenial']);
				$obj->setTipoSenial($_POST['tipoSenial']);
				$obj->setMatSenial($_POST['matSenial']);
				$obj->setLatitud($_POST['latitud']);
				$obj->setLongitud($_POST['longitud']);
				$obj->setEstado($_POST['estado']);
				$obj->setFechaConstr($_POST['fechaConstr']);
				
				$regSignal = new RegSignal();

				$regSignal->update_reg_signal($obj);              

            } catch (Exception $e) {
				$dbh->rollBack();
				error(101,"failed in post");
            }
		}
	}

	class UserHandler{
		function init() {
			$reg_user = new RegUser();
		}
		function get($user=null) {
			$dbh = $this->init();
			try {
				$regUser = new RegUser();

				if ($user!=null) {
					echo json_encode($regUser->get_reg_user( $user ));
				} else {
					echo json_encode($regUser->get_reg_users());
				}
			} catch (Exception $e) {
				error(101,"failed in get");
			}
		}
		function put($user=null) {
			$dbh = $this->init();
            try {
                $_PUT=json_decode(file_get_contents("php://input"), True);
                var_dump(file_get_contents('php://input'));
                $obj = new Users();

				$obj->setUser($_PUT['user']);
				$obj->setPass($_PUT['pass']);
				
				$regUser = new RegUser();

				$regUser->save_reg_user($obj);

            } catch (Exception $e) {
				$dbh->rollBack();
				error(101,"failed in put");
            }
		}
		function delete($user=null) {
			$dbh = $this->init();
			error(001,"prueba delete");
		}
		function post($user=null) {
			$dbh = $this->init();
            try {
                $_POST=json_decode(file_get_contents('php://input'), True);
                if ($_POST['method']=='put')
					return $this->put($user);
					
				$regUser = new RegUser();

				echo json_encode($regUser->login( $_POST['user'], $_POST['pass'] ));               

            } catch (Exception $e) {
				$dbh->rollBack();
				error(101,"failed in post");
            }
		}
	}

	Toro::serve(array(
		"/proy" => "DBHandler",
		"/proy/:alpha" => "DBHandler",
		"/proy/:alpha/:alpha" => "DBHandler",
		"/user" => "UserHandler",
		"/user/:alpha" => "UserHandler",
	));
?>
