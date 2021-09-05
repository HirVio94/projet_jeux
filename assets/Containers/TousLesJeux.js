import React from 'react';
import axios from 'axios';
import ListeJeux from './ListeJeux';
import Filtres from '../Components/Filtres';

class TousLesJeux extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            listeJeux: [],
            urlPlateforme: '',
            filtrePlateform: ''
        }
    }
    componentDidMount() {
        this.getJeux();
    }
    getJeux() {
        console.log('props.plateforme', this.props.plateforme);
        if (this.props.plateforme != '') {
            axios.get('http://localhost:8001/GetJeux.php?sortBy=recent&plateforme=' + this.props.plateforme).then(res => {
                console.log('res', res);
                let listeJeux = [];
                listeJeux = res.data;
                this.setState({ listeJeux: listeJeux, urlPlateforme: res.config.url.split('=')[2] });
            });
        }

    }
    componentDidUpdate() {
        // let recupPlateforme = this.recupPlateformeUrl();
        // console.log('this.state.url', this.state.urlPlateforme);
        // console.log('this.props update', this.props.plateforme);
        // console.log('this.url update', this.state.urlPlateforme);
        // console.log('recuplatforme', recupPlateforme);
        if (this.props.plateforme != this.state.urlPlateforme) {
            // console.log('this.props update 2', this.props.plateforme);
            // console.log('this.url update 2', this.state.urlPlateforme);
            // this.setState({listeJeux: []});
            this.getJeux();
        }
        // console.log('props', this.props);
    }

    recupPlateformeUrl() {
        let plateforme = this.state.url.split('=');
        plateforme = plateforme[2];
        // console.log('recup plateforme', plateforme);
    }
    handleCallback(jeu) {
        this.props.callback(jeu);
    }
    verifListeJeux() {
        // console.log('listeJeux touslesjeux', this.state.listeJeux);
        if (this.state.listeJeux.length > 0) {
            return <ListeJeux jeux={this.state.listeJeux} callback={this.handleCallback.bind(this)} />
        } else {
            return <h3>Aucun jeux {this.props.plateforme} enregistré</h3>
        }
    }
    handleCallbackFiltreGenre(genreId) {
        console.log('props plateforme', this.props.plateforme);
        if (this.state.filtrePlateform != this.props.plateforme && this.props.plateforme != '') {
            this.setState({ filtrePlateform: this.props.plateforme }, () => {
                this.getJeuxByPlateformeAndGenre(genreId);
            });
        } else {
            this.getJeuxByPlateformeAndGenre(genreId);
        }

    }
    handleCallbackFiltreDeveloppeur(developpeurId){
        if(this.state.filtrePlateform != this.props.plateforme && this.props.plateforme != ''){
            this.setState({filtrePlateform: this.props.plateforme}, ()=>{
                this.getJeuxByPlateformeAndDeveloppeur(developpeurId);
            })
        }else{
            this.getJeuxByPlateformeAndDeveloppeur(developpeurId);
        }
    }
    handleCallbackFiltreJeux(){
        axios.get('http://localhost:8001/GetJeux.php?sortBy=recent&plateforme=' + this.state.urlPlateforme).then(res=>{
            this.setState({listeJeux: res.data});
        })
    }
    getJeuxByPlateformeAndDeveloppeur(developpeurId){
        axios.get('http://localhost:8001/GetJeux.php?sortBy=recent&plateforme=' + this.state.filtrePlateform).then(res => {
            console.log('res filtre', res);
            let listeJeux = [];
            res.data.map(jeu => {
                if(jeu.developpeur_id == developpeurId){
                    listeJeux.push(jeu)
                }
            })
            this.props.callbackPlateforme();
            this.setState({ listeJeux: listeJeux});

        });
    }
    getJeuxByPlateformeAndGenre(genreId){
        axios.get('http://localhost:8001/GetJeux.php?sortBy=recent&plateforme=' + this.state.filtrePlateform).then(res => {
            console.log('res filtre', res);
            let listeJeux = [];
            res.data.map(jeu => {
                jeu.genres.map(genre => {
                    if (genre.id == genreId) {
                        listeJeux.push(jeu);
                    }
                })
            })
            this.props.callbackPlateforme();
            this.setState({ listeJeux: listeJeux});

        });
    }
    render() {

        return (
            <div id="main_tous_jeux">
                <h1 id="titre_page">{this.state.urlPlateforme}</h1>
                <Filtres callbackFiltre={this.handleCallbackFiltreGenre.bind(this)} callbackFiltreDeveloppeur={this.handleCallbackFiltreDeveloppeur.bind(this)} callbackFiltreJeux={this.handleCallbackFiltreJeux.bind(this)} page={this.state.urlPlateforme}/>
                {this.verifListeJeux()}
            </div>

        )
    }
}

export default TousLesJeux;