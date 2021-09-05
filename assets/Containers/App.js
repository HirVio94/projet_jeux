import React from 'react';
import ReactDOM from 'react-dom';
import Accueil from './MainAccueil';
import JeuxFocus from './JeuxFocus';
import Header from '../Components/Header';
import NavBar from './NavBar';
import TousLesJeux from './TousLesJeux';
import axios from 'axios';

class App extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            page: '',
            jeu: {},
            jeuSearch: {},
            libelle_plateforme: '',
            user: {},
            filtreGenre: ''
        }
    }

    componentDidMount() {
        if ($('#page')[0]) {
            let page = $('#page')[0].value;
            console.log(page);
            this.setState({ page: page });
        }

    }

    recupJeu() {
        let jeu = $('#jeu')[0].value;
        console.log(jeu);
        return jeu;
    }
    recupUser() {
        let userId = $('#user')[0].value;
        console.log('userId', userId);
        return userId;
    }
    verifPage() {
        let page = this.state.page;
        let divContent = document.getElementsByTagName('nav')[0];
        console.log('page', page);
        if (document.getElementsByTagName('main')[0]) {
            if (page == 'login/' || page == 'newUser/' || page == 'profil/' || page =='modifProfil/') {
                document.getElementsByTagName('main')[0].style.display = 'flex';
            } else {
                if (page != 'login/' && page != 'newUser/' && page != 'profil/' && page != 'modifProfil/') {
                    document.getElementsByTagName('main')[0].style.display = 'none';
                }
            }

        }

        switch (page) {
            case 'accueil':
                // window.history.replaceState(null, '', '/home');
                return <Accueil callback={this.handleCallbackMainAccueil.bind(this)} />
                break;
            case 'jeuxFocus':
                // window.history.replaceState(null, '', '/jeuxFocus/' + this.state.jeu.id);
                return <JeuxFocus jeu={this.state.jeu} jeuSearch={this.state.jeuSearch} callback={this.handleJeuxFocusCallback.bind(this)} user={this.state.user} />
                break;
            case 'listeJeux':
                // window.history.replaceState(null,'','/tous-les-jeux');
                return <TousLesJeux callback={this.handleCallbackMainAccueil.bind(this)} plateforme={this.state.libelle_plateforme} callbackPlateforme={this.handleCallbackPlateforme.bind(this)}/>
                break;
            default:
                // window.history.replaceState(null, '', '/home');
                return <Accueil callback={this.handleCallbackMainAccueil.bind(this)} />
                break;
            case 'login/':
                // if (divContent) {
                //     console.log('divContent', divContent.nextSibling);
                //     divContent = divContent.nextSibling;
                //     console.log('page login', page);
                //     if (page == 'login/') {

                //         divContent.style.display = 'none';

                //     } else {
                //         divContent.style.display = 'block';
                //     }
                // }
                break;
            case 'newUser/':
                // if (divContent) {
                //     console.log('divContent', divContent.nextSibling);
                //     divContent = divContent.nextSibling;
                //     console.log('page newUser', page);
                //     if (page == 'newUser/') {

                //         divContent.style.display = 'none';

                //     } else {
                //         divContent.style.display = 'block';
                //     }
                // }
                // break;
            case 'profil/':
                // if (divContent) {
                //     console.log('divContent', divContent.nextSibling);
                //     divContent = divContent.nextSibling;
                //     console.log('page profil', page);
                //     // if (page == 'profil/') {

                //     //     divContent.style.display = 'none';

                //     // } else {
                //     //     divContent.style.display = 'block';
                //     // }
                // }
                break;
            case 'modifProfil/':

                break;


        }
    }

    handleCallbackNavBar(item) {
        // console.log('app handlecallback item', item);
        let page = item.page;
        this.setState({ page: page, libelle_plateforme: item.libelle, jeuSearch: {} });
    }

    handleCallbackMainAccueil(jeu) {
        // console.log('jeu app callback', jeu);
        this.setState({ jeu: jeu });
        this.setState({ page: 'jeuxFocus' });
    }
    handleCallbackHeader(idJeu) {
        axios.get('http://localhost:8001/GetJeuxById.php?idJeux=' + idJeu).then(res => {
            // console.log('res.data', res.data);
            this.setState({ jeuSearch: res.data, page: 'jeuxFocus' });
        })
    }
    handleJeuxFocusCallback(jeuSearch) {
        this.setState({ jeuSearch: jeuSearch });
    }
    handleUserCallback(user){
        if(!this.state.user.username){
            // console.log('props user', this.state.user);
            this.setState({user: user});
        }
        
    }
    handleCallbackPlateforme(){
        this.setState({libelle_plateforme: ''});
    }
    
    render() {
        // console.log('plateforme', this.state.libelle_plateforme);
        return (
            <div>
                <Header idUser={this.recupUser()} callback={this.handleCallbackHeader.bind(this)} userCallback={this.handleUserCallback.bind(this)} />
                <NavBar callback={this.handleCallbackNavBar.bind(this)} />
                {this.verifPage()}
            </div>
        )
    }
}

export default App;