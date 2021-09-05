import React from 'react';

class ListeItem extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            item: '',
        }
    }
    componentDidMount(){
        this.setState({item: this.props.item});
    }

    handleClick(){
        window.history.replaceState(null, '', '/');
        this.props.callback(this.state.item);

    }

    render(){
        return(
            <li onClick={this.handleClick.bind(this)}>{this.state.item.libelle}</li>
        )
    }
}

export default ListeItem;