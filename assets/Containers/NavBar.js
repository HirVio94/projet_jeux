import React from 'react';
import ListeItem from '../Components/ListeItem';

class NavBar extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            liste: ['Accueil', 'PS4', 'PS3', 'PS2', 'PS', 'PC'], 
        }
    }

    render(){
        return(
            <nav>
                <ul>
                    {this.state.liste.map(item => {
                        return <ListeItem item={item} />
                    })}
                </ul>
            </nav>
            
        )
    }
}

export default NavBar;