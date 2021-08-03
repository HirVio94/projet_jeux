import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import NavBar from './NavBar';
import JeuDetail from '../Components/JeuDetail';
import ListeJeuxRecommende from './ListeJeuxRecommende';

class JeuxFocus extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            idJeu: this.recupJeu(),
            jeu: {},
            jeuxRecommende: [],
        }
    }
    componentDidMount() {
        console.log('idJeu', this.state.idJeu);
        this.getJeu();
        console.log('this.state.jeu', this.state.jeu);



    }

    recupJeu() {
        let jeu = $('#jeu')[0].value;
        // console.log('jeu', jeu);
        return jeu;
    }
    getJeu() {
        axios.get('http://localhost:8001/GetJeuxById.php?idJeux=' + this.state.idJeu).then((res) => {
            // console.log(res.data);
            this.setState({ jeu: res.data });
            console.log('stateJeu', this.state.jeu);
            this.getJeuxRecommende();
            console.log('jeuxrecommende', this.state.jeuxRecommende);

        });
    }
    

    getJeuxRecommende() {
        let jeuxRecommende = [];
        this.state.jeu.genres.map(genre => {
            axios.get('http://localhost:8001/GetJeux.php?idGenre=' + genre.id).then((res) => {
                res.data.map(data=>{
                    let found = jeuxRecommende.find(jeu => jeu.id == data.id);
                    if(!found && this.state.jeu.id != data.id){
                        jeuxRecommende.push(data);
                    }
                })


            });

        });
        this.setState({ jeuxRecommende: jeuxRecommende });
        console.log('jeuxRcommende', this.state.jeuxRecommende);


    }
    verifJeu() {
        // console.log(this.state.jeu);
        if (this.state.jeu.titre) {
            return <JeuDetail jeu={this.state.jeu} />
        }
    }

    verifJeuxRecommende(){
        console.log('jeuxRecommende verif avant if', this.state.jeuxRecommende);
        console.log('jeuxrecommende length', this.state.jeuxRecommende.length);
        if ( this.state.jeuxRecommende.length > 0){
            console.log('jeuxRecommende verif', this.state.jeuxRecommende);
            return <ListeJeuxRecommende listeJeux={this.state.jeuxRecommende}/>;
        }
    }
    render() {
        return (
            <div>
                <NavBar />
                <div>
                    {this.verifJeu()}
                    {this.verifJeuxRecommende()}
                </div>
                
            </div>
        )
    }


}



export default JeuxFocus;