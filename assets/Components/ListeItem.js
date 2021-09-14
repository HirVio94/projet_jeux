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
        let nav = $('nav')[0];
        let svg = $('#menu')[0];
        if( window.getComputedStyle(nav.firstChild).flexDirection == 'column' && window.getComputedStyle(nav).display == 'flex'){
            nav.style.display = 'none';
            svg.style.color = 'white';
        }
        this.props.callback(this.state.item);

    }

    render(){
        return(
            <li onClick={this.handleClick.bind(this)}>{this.state.item.libelle}</li>
        )
    }
}

export default ListeItem;