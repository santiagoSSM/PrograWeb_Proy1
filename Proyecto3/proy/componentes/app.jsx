var Container = Reactstrap.Container;
var Row = Reactstrap.Row;
var Col = Reactstrap.Col;
var Button = Reactstrap.Button;
var Form = Reactstrap.Form;
var Input = Reactstrap.Input;
var Row = Reactstrap.Row;
var Col = Reactstrap.Col;

class App extends React.Component {
    constructor(props) {
        super(props)
        this.state = { user:"", pass:"" }
        this.handleLogin = this.handleLogin.bind(this);
        this.handleFields = this.handleFields.bind(this);
    }
    componentWillReceiveProps(nextProps) {
        this.setState({user:nextProps.user.user});
        this.setState({pass:nextProps.user.pass});
    }
    handleLogin() {
        fetch("server/index.php/user/"+this.state.user,{
            method: "post",
            headers: {'Content-Type': 'application/json',
                                'Content-Length': 20},
            body: JSON.stringify({
                method: 'post',
                user: this.state.user,
                pass: this.state.pass
                        })
        }).then((response) => {
            return response.json()
        })
        .then((value) => {
            if(value){
                location.href='principal.html?user='+this.state.user+'&select=-1';
            }else{
                alert("Usuario o contraseña incorrectos");
            }            
        })
    }
    handleFields(event) {
        const target = event.target;
        const value = target.value;
        const name = target.name;
        this.setState({[name]: value});
    }

    render() {
        return (
        <Row>
        <Col xs="2" sm="4" md="3" lg="5"></Col>
        
        <Col xs="8" sm="4" md="5" lg="2">
        <Form action="principal.html">
            <br />
            <h1>Ingresar</h1>
            <br />
            <p>Usuario</p>
            <Input type="text" name="user"
                      value={this.state.user} onChange={this.handleFields} placeholder="Usuario" />
            <br />
       
            <p>Contraseña</p>
            <Input type="password" name="pass"
                      value={this.state.pass} onChange={this.handleFields} placeholder="Contraseña" />
            <br />
            <Button onClick={this.handleLogin}>Iniciar sesion</Button>
            <hr />
            <a href="crearUsuario.html">Crear usuario</a> 
      </Form>
      </Col>
      
      <Col xs="2" sm="4" md="3" lg="5"></Col>
      </Row>
        
        )
    }
}
ReactDOM.render(<App/>, document.getElementById('root'));