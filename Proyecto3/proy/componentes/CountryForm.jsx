var Form = Reactstrap.Form;
var Button = Reactstrap.Button;
var FormGroup = Reactstrap.FormGroup;
var Label = Reactstrap.Label;
var Input = Reactstrap.Input;
var ButtonGroup = Reactstrap.ButtonGroup;

class CountryForm extends React.Component {
    constructor(props) {
        super(props)
        this.state = {id:"",nombre:"",autor:"",fecha:"",tamano:0}
        this.handleInsert = this.handleInsert.bind(this);
        this.handleUpdate = this.handleUpdate.bind(this);
        this.handleDelete = this.handleDelete.bind(this);
        this.handleFields = this.handleFields.bind(this);
    }
    componentWillReceiveProps(nextProps) {
        this.setState({id:nextProps.proy.id});
        this.setState({nombre:nextProps.proy.nombre});
        this.setState({autor:nextProps.proy.autor});
        this.setState({fecha:nextProps.proy.fecha});
        this.setState({tamano:nextProps.proy.tamano});
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
         return(<Modal isOpen={this.props.modal} toggle={this.props.handleEditData} className={this.props.className}>
          <ModalHeader toggle={this.handleEditData}>Información de país</ModalHeader>
          <ModalBody>
          <Form color="primary">
            <FormGroup><Label>Nombre:</Label>
                <Input type="text" name="name"
                    value={this.state.nombre} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Area:</Label>
                <Input type="text" name="area"
                    value={this.state.autor} onChange={this.handleFields}/></FormGroup>
             <FormGroup><Label>Population:</Label>
                <Input type="text" name="population"
                    value={this.state.fecha} onChange={this.handleFields}/></FormGroup>
            <FormGroup><Label>Density:</Label>
                <Input type="text" name="density"
                    value={this.state.tamano} onChange={this.handleFields}/></FormGroup>
            <Input type="hidden" name="id" value={this.state.id}/>
            </Form></ModalBody>
            <ModalFooter>
            <Button color="primary" onClick={this.props.handleUpdate}>Modificar</Button>{' '}
            <Button color="secondary" onClick={this.props.handleEditData}>Cancelar</Button>
          </ModalFooter>
            </Modal>)
     }
 }