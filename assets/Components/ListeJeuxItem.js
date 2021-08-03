import React from 'react';

class ListeJeuxItem extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            jeuxItem: props.jeuxItem,
        }
    }

    render(){
        console.log('jeuxItem', this.state.jeuxItem);
        return(
            <div>
                <h3>{this.state.jeuxItem.titre}</h3>
            </div>
            
        )
    }
}

export default ListeJeuxItem;