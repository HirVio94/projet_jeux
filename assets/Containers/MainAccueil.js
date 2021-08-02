import React from 'react';
import ReactDOM from 'react-dom';
import ListeJeux from './ListeJeux';
import axios from 'axios';
import NavBar from './NavBar';

class Accueil extends React.Component{

    constructor(props){
        super(props);
        this.state = {
            jeuxListe : [],
        }
    }

    componentDidMount(){
        axios.get('http://localhost:8001/GetJeux.php?sortBy=note').then(function(res){
            console.log('result', res);
            this.setState({jeuxListe: res.data});
        }.bind(this));
        
    }

    

    verifState(){
        if(this.state.jeuxListe.length > 0){
            return(
                <div>
                    <ListeJeux jeux={this.state.jeuxListe}/>
                </div>
                
            );
            }
    }
    
    render(){
        // console.log(this.state.jeuxListe);
       return (
           <div>
               <NavBar />
               <h1>Jeux les mieux notés</h1>
               {this.verifState()}
           </div>
       )
    }
}



export default Accueil;