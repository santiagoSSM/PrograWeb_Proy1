var Navbar = Reactstrap.Navbar;
var NavbarBrand = Reactstrap.NavbarBrand;
var NavbarToggler = Reactstrap.NavbarToggler;
var Collapse = Reactstrap.Collapse;
var Nav = Reactstrap.Nav;
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
        this.state = { proys: [], proy: [], options: [], modal: false, data: {} }
        this.handleReload = this.handleReload.bind(this);
        this.handleEditData = this.handleEditData.bind(this);
        this.handleChangeData = this.handleChangeData.bind(this);
        this.handleChangeCountry = this.handleChangeCountry.bind(this);
    }
    setChartData() {
        const data = this.state.proys.map((proy,index) => [proy.nombre,proy.tamano]);
        this.setState({ data: data });
    }
    handleReload() {
        fetch('server/index.php/proy')
        .then((response) => {
            return response.json()
        })
        .then((data) => {
            this.setState({ proys: data });
            this.setChartData();
            this.forceUpdate();
        })
    }
    componentWillMount() {
        this.handleReload();
    }
    handleChangeData() {
        this.handleReload();
    }
    handleChangeCountry(data) {
        this.setState({proy: data})
    }
    handleEditData() {
        this.setState({
      modal: !this.state.modal
    });
    }
    handleClick() {
      console.log("OK")
    }
    render() {
        const optionsX = {onClick:this.handleClick, events:['click']};
        return (<div><Navbar color="light" light expand="md">
          <NavbarBrand href="/">Datos de Países</NavbarBrand>
          <NavbarToggler onClick={this.toggle} />
        </Navbar><p></p><Container><Row>
        <Col xs="8"><CountryList proys={this.state.proys}
            handleChangeCountry={this.handleChangeCountry}/></Col>
        <Col xs="4"><ColumnChart data={this.state.data}/>
        <PieChart data={this.state.data} onClick={this.handleClick}/></Col>
        </Row>
        </Container>
        <CountryForm proy={this.state.proy} modal={this.state.modal}
            handleEditData={this.handleEditData}
            handleChangeData={this.handleChangeData}/>
        </div>)
    }
}
ReactDOM.render(<App/>, document.getElementById('root'));