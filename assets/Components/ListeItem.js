import React from 'react';

class ListeItem extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            item: props.item,
        }
    }

    render(){
        return(
            <li><a href="">{this.state.item}</a></li>
        )
    }
}

export default ListeItem;