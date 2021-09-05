import React from 'react';
import ReactDOM from 'react-dom';
import ListeJeux from './ListeJeux';
import axios from 'axios';
import NavBar from './NavBar';

class Accueil extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            jeuxListe: [],
        }
    }

    componentDidMount() {
        axios.get('http://localhost:8001/GetJeux.php?sortBy=note&limit=5').then(function (res) {
            console.log('result', res);
            this.setState({ jeuxListe: res.data });
        }.bind(this));

    }

    handleCallback(jeu) {
        this.props.callback(jeu);
    }

    verifState() {
        if (this.state.jeuxListe.length > 0) {
            return (
                <ListeJeux jeux={this.state.jeuxListe} callback={this.handleCallback.bind(this)} />


            );
        }
    }

    render() {
        // console.log(this.state.jeuxListe);
        return (
            <div id="main_accueil">
                <h1 id="titre_page">Jeux les mieux notés</h1>
                {this.verifState()}
            </div>
        )
    }
}



export default Accueil;