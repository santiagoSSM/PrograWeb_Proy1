var Form = Reactstrap.Form;
var Button = Reactstrap.Button;
var FormGroup = Reactstrap.FormGroup;
var Label = Reactstrap.Label;
var Input = Reactstrap.Input;
var ButtonGroup = Reactstrap.ButtonGroup;

class CountryDisplay extends React.Component {
    constructor(props) {
        super(props)
        this.state = {id:"",nombre:"",autor:"",fecha:"",tamano:0}
        this.handleEdit = this.handleEdit.bind(this);
    }
    componentWillReceiveProps(nextProps) {
        this.setState({id:nextProps.proy.id});
        this.setState({nombre:nextProps.proy.nombre});
        this.setState({autor:nextProps.proy.autor});
        this.setState({fecha:nextProps.proy.fecha});
        this.setState({tamano:nextProps.proy.tamano});
    }
    handleEdit() {
            this.props.handleEditData();
    }
    render() {
         return(<Form color="primary">
            <FormGroup><Label>Nombre:</Label>
                <Input type="text" name="name" readonly="readonly"
                    value={this.state.nombre}/></FormGroup>
            <FormGroup><Label>Area:</Label>
                <Input type="text" name="area" readonly="readonly"
                    value={this.state.autor}/></FormGroup>
             <FormGroup><Label>Population:</Label>
                <Input type="text" name="population" readonly="readonly"
                    value={this.state.fecha}/></FormGroup>
            <FormGroup><Label>Density:</Label>
                <Input type="text" name="density" readonly="readonly"
                    value={this.state.tamano}/></FormGroup>
            <Input type="hidden" name="id" value={this.state.id}/>
            <ButtonGroup>
                <Button onClick={this.handleEdit}>Editar</Button>
            </ButtonGroup>
            </Form>)
     }
 }