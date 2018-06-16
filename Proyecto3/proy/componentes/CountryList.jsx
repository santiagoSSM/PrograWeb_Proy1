var Table = Reactstrap.Table;
var ListGroup = Reactstrap.ListGroup;
var ListGroupItem = Reactstrap.ListGroupItem;
var ListGroupItemHeading = Reactstrap.ListGroupItemHeading;
var ListGroupItemText = Reactstrap.ListGroupItemText;

class CountryList extends React.Component {
    constructor(props) {
        super(props)
        this.state = {index:-1}
        this.handleDetails = this.handleDetails.bind(this);
    }
    handleDetails(e) {
        const index = e.currentTarget.getAttribute('data-item');
        this.setState({index:index});
        this.props.handleChangeCountry(this.props.proys[index]);
    }
    render() {
        if (this.props.proys.length > 0) {
            const rows = this.props.proys.map((proy,index) =>
                <ListGroupItem active={index==this.state.index?true:false} tag="button" action key={index} data-item={index} onClick={this.handleDetails}>
                <ListGroupItemHeading>{proy.nombre}</ListGroupItemHeading>
                <ListGroupItemText>Area: {proy.fecha} Poblac: {proy.tamano}</ListGroupItemText>
                </ListGroupItem>);
        return (
            <ListGroup>
                {rows}
                <Button>Agregar</Button>
            </ListGroup>);
    }
    return (<p></p>)
    }
}