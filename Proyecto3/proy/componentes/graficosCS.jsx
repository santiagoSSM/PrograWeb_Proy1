var Navbar = Reactstrap.Navbar;
var NavbarBrand = Reactstrap.NavbarBrand;
var NavbarToggler = Reactstrap.NavbarToggler;
var Collapse = Reactstrap.Collapse;
var Nav = Reactstrap.Nav;
var NavItem = Reactstrap.NavItem;
var NavLink = Reactstrap.NavLink;
var Container = Reactstrap.Container;
var Row = Reactstrap.Row;
var Col = Reactstrap.Col;
var ColumnChart = ReactChartkick.ColumnChart;
var PieChart = ReactChartkick.PieChart;
var Modal = Reactstrap.Modal;
var ModalHeader = Reactstrap.ModalHeader;
var ModalBody = Reactstrap.ModalBody;
var ModalFooter = Reactstrap.ModalFooter;

class App extends React.Component {
    constructor(props) {
        super(props)
        this.state = { user:this.getQueryVariable("user"), signals: [], signal: [], data: {},
        urlTipo: 'graficoCS.html?user='+this.getQueryVariable("user")+'&select=Tipo',
        urlMaterial: 'graficoCS.html?user='+this.getQueryVariable("user")+'&select=Material',
        urlEstCons: 'graficoCS.html?user='+this.getQueryVariable("user")+'&select=Estado_de_Conservacion',
        urlFechInst: 'graficoCS.html?user='+this.getQueryVariable("user")+'&select=Fecha_de_Instalacion',
        urlReturn: 'principal.html?user='+this.getQueryVariable("user")+'&select=-1' }
        this.handleReload = this.handleReload.bind(this);
    }

    setChartData(filtro) {
        var convert = [];

        switch (filtro) {
            case "Material":
                this.state.signals.forEach(element => {
                    var tmp;
        
                    convert.forEach(element2 => {
                        if(element2.dato == element.matSenial){
                            tmp = element2;
                        }
                    });
        
                    if(tmp == null){
                        convert.push({dato: element.matSenial, cant: 1});
                    }
                    else{
                        tmp.cant++;
                    }
                });
                break;

            case "Estado_de_Conservacion":
                this.state.signals.forEach(element => {
                    var tmp;
        
                    convert.forEach(element2 => {
                        if(element2.dato == element.estado){
                            tmp = element2;
                        }
                    });
        
                    if(tmp == null){
                        convert.push({dato: element.estado, cant: 1});
                    }
                    else{
                        tmp.cant++;
                    }
                });
                break;

            case "Fecha_de_Instalacion":
                this.state.signals.forEach(element => {
                    var tmp;
        
                    convert.forEach(element2 => {
                        if(element2.dato == element.fechaConstr){
                            tmp = element2;
                        }
                    });
        
                    if(tmp == null){
                        convert.push({dato: element.fechaConstr, cant: 1});
                    }
                    else{
                        tmp.cant++;
                    }
                });
                break;
        
            default:
                this.state.signals.forEach(element => {
                    var tmp;
        
                    convert.forEach(element2 => {
                        if(element2.dato == element.tipoSenial){
                            tmp = element2;
                        }
                    });
        
                    if(tmp == null){
                        convert.push({dato: element.tipoSenial, cant: 1});
                    }
                    else{
                        tmp.cant++;
                    }
                    
                });
                break;
        }

        const data = convert.map((data,index) => [data.dato,data.cant]);        
        this.setState({ data: data });
    }
    handleReload() {
        fetch('server/index.php/proy/'+this.state.user)
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            this.setState({ signals: data });
            this.setChartData(this.getQueryVariable("select"));
            this.forceUpdate();
        })
    }
    componentWillMount() {
        this.handleReload();
    }
    render() {
        return (<div><Navbar color="light" light expand="md">
        <NavbarBrand>Datos de Cantidad de Señales ({this.getQueryVariable("select")})</NavbarBrand>
        <Nav className="ml-auto" navbar>
        <NavItem>
            <NavLink href={this.state.urlTipo}>Tipo</NavLink>
        </NavItem>
        <NavItem>
            <NavLink href={this.state.urlMaterial}>Material</NavLink>
        </NavItem>
        <NavItem>
            <NavLink href={this.state.urlEstCons}>Estado de Conservación</NavLink>
        </NavItem>
        <NavItem>
            <NavLink href={this.state.urlFechInst}>Fecha de instalación</NavLink>
        </NavItem>
        <NavItem>
            <NavLink href={this.state.urlReturn}>Regresar</NavLink>
        </NavItem>
        </Nav>
        </Navbar><p></p><Container><Row>
        <Col xs="12"><ColumnChart data={this.state.data}/></Col>
        </Row>
        </Container>
        </div>)
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