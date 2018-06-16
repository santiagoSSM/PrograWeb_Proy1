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
        this.state = {user:"",pass:""}
        this.handleInsert = this.handleInsert.bind(this);
        this.handleFields = this.handleFields.bind(this);
    }
    componentWillReceiveProps(nextProps) {
        this.setState({user:nextProps.user.user});
        this.setState({pass:nextProps.user.pass});
    }
    handleInsert() {
        fetch("server/index.php/user/"+this.state.user,{
            method: "post",
            headers: {'Content-Type': 'application/json',
                                'Content-Length': 20},
            body: JSON.stringify({
                method: 'put',
                user: this.state.user,
                pass: this.state.pass
                        })
    }).then((response) => {
            location.href='index.html'
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
        <Row>
        <Col xs="2" sm="4" md="3" lg="5"></Col>
        
        <Col xs="8" sm="4" md="5" lg="2">
        <Form>
            <br />
            <h1>Crear</h1>
            <br />
            <p>Usuario</p>
            <Input type="text" name="user"
                      value={this.state.user} onChange={this.handleFields} placeholder="Usuario" />
            <br />
       
            <p>Contraseña</p>
            <Input type="password" name="pass"
                      value={this.state.pass} onChange={this.handleFields} placeholder="Contraseña" />
            <br />
            
            <Button onClick={this.handleInsert}>Registrar usuario</Button>
            
      </Form>
      </Col>
      
      <Col xs="2" sm="4" md="3" lg="5"></Col>
      </Row>
        
        )
    }
}
ReactDOM.render(<App/>, document.getElementById('root'));