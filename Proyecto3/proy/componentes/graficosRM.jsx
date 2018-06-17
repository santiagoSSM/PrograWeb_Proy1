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
        urlFecha: 'graficoRM.html?user='+this.getQueryVariable("user")+'&select=Fecha',
        urlKilom: 'graficoRM.html?user='+this.getQueryVariable("user")+'&select=Kilometraje',
        urlCantHmbs: 'graficoRM.html?user='+this.getQueryVariable("user")+'&select=Cantidad_de_Hombres',
        urlReturn: 'principal.html?user='+this.getQueryVariable("user")+'&select=-1' }
        this.handleReload = this.handleReload.bind(this);
    }

    setChartData(filtro) {
        var convert = [];

        switch (filtro) {

            case "Kilometraje":
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

            case "Cantidad_de_Hombres":
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
                        if(element2.dato == element.fecha){
                            tmp = element2;
                        }
                    });
        
                    if(tmp == null){
                        convert.push({dato: element.fecha, cant: 1});
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
        <NavbarBrand>Datos de Rutas de Mantenimiento ({this.getQueryVariable("select")})</NavbarBrand>
        <Nav className="ml-auto" navbar>
        <NavItem>
            <NavLink href={this.state.urlFecha}>Fecha</NavLink>
        </NavItem>
        <NavItem>
            <NavLink href={this.state.urlKilom}>Kilometraje</NavLink>
        </NavItem>
        <NavItem>
            <NavLink href={this.state.urlCantHmbs}>Cantidad de Hombres</NavLink>
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