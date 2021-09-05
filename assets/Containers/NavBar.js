import React from 'react';
import ListeItem from '../Components/ListeItem';

class NavBar extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            liste: [
                {'libelle': 'Accueil', 'page' : 'accueil'},
                {'libelle': 'Tous les jeux', 'page' : 'listeJeux'},
                {'libelle': 'PS4', 'page' : 'listeJeux'},
                {'libelle': 'PS3', 'page' : 'listeJeux'},
                {'libelle': 'PS2', 'page' : 'listeJeux'},
                {'libelle': 'PS', 'page' : 'listeJeux'},
                {'libelle': 'PC', 'page' : 'listeJeux'}
            ], 
        }
    }

    handleCallback(item){
        console.log('callback Item', item);
        this.props.callback(item);
    }
    render(){
        return(
            <nav>
                <ul>
                    {this.state.liste.map(item => {
                        return <ListeItem item={item} callback={this.handleCallback.bind(this)}/>
                    })}
                </ul>
            </nav>
            
        )
    }
}

export default NavBar;