var Table = Reactstrap.Table;
var Navbar = Reactstrap.Navbar;
var NavbarBrand = Reactstrap.NavbarBrand;
var NavbarToggler = Reactstrap.NavbarToggler;
var Collapse = Reactstrap.Collapse;
var Nav = Reactstrap.Nav;
var NavItem = Reactstrap.NavItem;
var NavLink = Reactstrap.NavLink;
var UncontrolledDropdown = Reactstrap.UncontrolledDropdown;
var DropdownToggle =  Reactstrap.DropdownToggle;
var DropdownMenu = Reactstrap.DropdownMenu;
var DropdownItem = Reactstrap.DropdownItem;
var Row = Reactstrap.Row;
var Col = Reactstrap.Col;
var Form = Reactstrap.Form;
var Button = Reactstrap.Button;
var FormGroup = Reactstrap.FormGroup;
var Label = Reactstrap.Label;
var Input = Reactstrap.Input;
var FormText = Reactstrap.FormText;

class SignalList extends React.Component {
  render() {
    return this.props.signals.map((signal) =>
    <tr>
      <td><Button onClick={this.props.handleClick(signal.Id)}>{signal.Id}</Button></td>
      <td>{signal.user}</td>
      <td>{signal.nombre}</td>
      <td>{signal.autor}</td>
      <td>{signal.fecha}</td>
      <td>{signal.tamano}</td>
      <td>{signal.descr}</td>
      <td>{signal.clasific}</td>
      <td>{signal.refSenial}</td>
      <td>{signal.tipoSenial}</td>
      <td>{signal.matSenial}</td>
      <td>{signal.latitud}</td>
      <td>{signal.longitud}</td>
      <td>{signal.estado}</td>
      <td>{signal.fechaConstr}</td>
    </tr>
  );
  }
}

class App extends React.Component {
  
    constructor(props) {
        super(props)
        this.state = { id:this.getQueryVariable("select"), user:this.getQueryVariable("user"), nombre:"", autor:"", fecha:"",
         tamano:0, descr:"", clasific:"", refSenial:"", tipoSenial:"", matSenial:"", latitud:"",
          longitud:"", estado:"", fechaConstr:"", signals:[] }
        this.handleInsert = this.handleInsert.bind(this);
        this.handleUpdate = this.handleUpdate.bind(this);
        this.handleDelete = this.handleDelete.bind(this);
        this.handleFields = this.handleFields.bind(this);
    }
    componentWillMount() {
      fetch('server/index.php/proy/'+this.state.user)
        .then((response) => {
            return response.json()
        })
        .then((signals) => {
            this.setState({ signals: signals })
        })
      if(this.state.id != -1){
        fetch('server/index.php/proy/x/'+this.state.id)
        .then((response) => {
            return response.json()
        })
        .then((elem) => {
            console.log(elem.Id);
            this.state.id=elem.Id;
            this.state.user=elem.user;
            this.state.nombre=elem.nombre;
            
        })
      }
    }
    componentWillReceiveProps(nextProps) {
      this.setState({id:nextProps.proy.id});
      this.setState({user:nextProps.proy.user});
      this.setState({nombre:nextProps.proy.nombre});
      this.setState({autor:nextProps.proy.autor});
      this.setState({fecha:nextProps.proy.fecha});
      this.setState({tamano:nextProps.proy.tamano});
      this.setState({descr:nextProps.proy.descr});
      this.setState({clasific:nextProps.proy.clasific});
      this.setState({refSenial:nextProps.proy.refSenial});
      this.setState({tipoSenial:nextProps.proy.tipoSenial});
      this.setState({matSenial:nextProps.proy.matSenial});
      this.setState({latitud:nextProps.proy.latitud});
      this.setState({longitud:nextProps.proy.longitud});
      this.setState({estado:nextProps.proy.estado});
      this.setState({fechaConstr:nextProps.proy.fechaConstr});
    }
    handleClick = (param) => (e) => { 
      location.href='principal.html?user='+this.state.user+'&select='+param;
    }
    handleInsert() {
        fetch("server/index.php/proy/"+this.state.id,{
            method: "post",
            headers: {'Content-Type': 'application/json',
                              'Content-Length': 20},
            body: JSON.stringify({
                method: 'put',
                user: this.state.user,
                nombre: this.state.nombre,
                autor: this.state.autor,
                fecha: this.state.fecha,
                tamano: this.state.tamano,
                descr: this.state.descr,
                clasific: this.state.clasific,
                refSenial: this.state.refSenial,
                tipoSenial: this.state.tipoSenial,
                matSenial: this.state.matSenial,
                latitud: this.state.latitud,
                longitud: this.state.longitud,
                estado: this.state.estado,
                fechaConstr: this.state.fechaConstr
            })
    }).then((response) => {
          location.href='principal.html?user='+this.state.user+'&select=-1';
        }
    );
    }
    handleUpdate() {
        fetch("server/index.php/proy/"+this.state.id,{
            method: "post",
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
              method: 'post',
              Id: this.state.id,
              user: this.state.user,
              nombre: this.state.nombre,
              autor: this.state.autor,
              fecha: this.state.fecha,
              tamano: this.state.tamano,
              descr: this.state.descr,
              clasific: this.state.clasific,
              refSenial: this.state.refSenial,
              tipoSenial: this.state.tipoSenial,
              matSenial: this.state.matSenial,
              latitud: this.state.latitud,
              longitud: this.state.longitud,
              estado: this.state.estado,
              fechaConstr: this.state.fechaConstr
            })
    }).then((response) => {
          location.href='principal.html?user='+this.state.user+'&select=-1';
        }
    );
    }
    handleDelete() {
        fetch("server/index.php/proy/"+this.state.id,{
            method: "post",
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ method: 'delete'})
        }).then((response) => {
          location.href='principal.html?user='+this.state.user+'&select=-1';
        }
    );
    }
    handleFields(event) {
    const target = event.target;
    const value = target.value;
    const name = target.name;
    this.setState({[name]: value});
  }
    render() {
      return (
          <div class="container">
          
          <Row>
          <Col xs="12">
          <Navbar color="light" light expand="xs">
          <NavbarBrand href="">Ingeniería de tránsito</NavbarBrand>
          <NavbarToggler  />
          <Collapse navbar>
            <Nav className="ml-auto" navbar>
              
              <UncontrolledDropdown nav inNavbar>
                <DropdownToggle nav caret>
                  Gráficos
                </DropdownToggle>
                <DropdownMenu right>
                  <DropdownItem>
                    O
                  </DropdownItem>
                  <DropdownItem>
                    O
                  </DropdownItem>
                  
                  <DropdownItem>
                    R
                  </DropdownItem>
                </DropdownMenu>
              </UncontrolledDropdown>
              
              <NavItem>
                <NavLink href="index.html">Cerrar sesión</NavLink>
              </NavItem>
            </Nav>
          </Collapse>
        </Navbar>
        
        </Col>  
        </Row>
        
        <br />
          
        <Row>
         <Col xs="8">
            <div class="table-responsive">
            <Table hover>
                <thead><tr>
                <th>Id</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Autor</th>
                <th>Fecha</th>
                <th>Tamaño</th>
                <th>Descripción</th>
                <th>Clasificación</th>
                <th>Referencia</th>
                <th>Tipo</th>
                <th>Material</th>
                <th>Latitud</th>
                <th>Longitud</th>
                <th>Estado</th>
                <th>Fecha_constr.</th>
                </tr></thead>
                <tbody>
                <SignalList signals={this.state.signals} handleClick={this.handleClick}/>
                </tbody>
            </Table>
            </div>
         </Col>
        <Col xs="4">
        
        <Form>
            <FormGroup><Label>Nombre:</Label>
                <Input type="text" name="nombre" value={this.state.nombre} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Autor:</Label>
                <Input type="text" name="autor" value={this.state.autor} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Fecha:</Label>
                <Input type="text" name="fecha" value={this.state.fecha} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Tamaño:</Label>
                <Input type="text" name="tamano" value={this.state.tamano} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Descripción:</Label>
                <Input type="text" name="descr" value={this.state.descr} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Clasificación:</Label>
                <Input type="text" name="clasific" value={this.state.clasific} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Referencia:</Label>
                <Input type="text" name="refSenial" value={this.state.refSenial} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Tipo:</Label>
                <Input type="text" name="tipoSenial" value={this.state.tipoSenial} onChange={this.handleFields}/></FormGroup>
             <FormGroup><Label>Material:</Label>
                <Input type="text" name="matSenial" value={this.state.matSenial} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Latitud:</Label>
                <Input type="text" name="latitud" value={this.state.latitud} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Logngitud:</Label>
                <Input type="text" name="longitud" value={this.state.longitud} onChange={this.handleFields}/></FormGroup>
			      <FormGroup><Label>Estado:</Label>
                <Input type="text" name="estado" value={this.state.estado} onChange={this.handleFields}/></FormGroup>
			      <FormGroup><Label>Fecha:</Label>
                <Input type="text" name="fechaConstr" value={this.state.fechaConstr} onChange={this.handleFields}/></FormGroup>
            
            <div>
                <Button onClick={this.handleInsert}>Agregar</Button>{' '}
                <Button onClick={this.handleUpdate}>Modificar</Button>{' '}
                <Button onClick={this.handleDelete}>Eliminar</Button>{' '}
                <br /> <br /> <br />
            </div></Form>
        
        </Col>
        </Row>
         </div>
          
          )
    }

    getQueryVariable(variable) {
      var query = window.location.search.substring(1);
      var vars = query.split("&");
      for (var i=0; i < vars.length; i++) {
          var pair = vars[i].split("=");
          if(pair[0] == variable) {
              return pair[1];
          }
      }
      return false;
    }
}
ReactDOM.render(<App/>, document.getElementById('root'));