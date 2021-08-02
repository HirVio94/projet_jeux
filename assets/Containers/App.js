import React from 'react';
import ReactDOM from 'react-dom';
import Accueil from './MainAccueil';
import JeuxFocus from './JeuxFocus';

class App extends React.Component{
    constructor(props){
        super(props);
        this.state = {
        }
    }
    
    recupJeu(){
        let jeu = $('#jeu')[0].value;
        console.log(jeu);
        this.setState({idJeu: jeu});
    }
    verifPage(){
        let page = $('#page')[0].value;
        console.log(page);
        switch(page){
            case 'home/':
                return <Accueil />
                break;
            case 'jeuxFocus/':
                return <JeuxFocus/>
                break; 
        }
    }
    render(){
        return(
            <div>
                {this.verifPage()}
            </div>
        )
    }
}

export default App;