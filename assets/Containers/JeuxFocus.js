import React from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import NavBar from './NavBar';
import JeuDetail from '../Components/JeuDetail';
import ListeJeuxRecommende from './ListeJeuxRecommende';
import ListeAvis from './ListeAvis';

class JeuxFocus extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            jeu: {},
            jeuFromSearch: {},
            jeuxRecommendes: [],
            avis: [],
            user: {}
        }
    }
    componentDidMount() {
        this.setState({ jeu: this.props.jeu, user: this.props.user });
    }

    componentDidUpdate() {
        // console.log('jeu', this.state.jeu);
        // console.log('props', this.props);
        // console.log('jeuFromSearch', this.state.jeuFromSearch);
        if (this.props.jeuSearch.id != this.state.jeuFromSearch.id && this.props.jeuSearch != '') {
            this.setState({ jeuFromSearch: this.props.jeuSearch, jeu: this.props.jeuSearch, jeuxRecommendes: [], avis: [] });
        }
        if (this.state.jeuxRecommendes.length < 1) {
            this.getJeuxRecommende();
        }
        if (this.state.avis.length < 1) {
            this.getAvis();
        }


        // console.log('this.state.jeuxRecommendes', this.state.jeuxRecommendes);
    }

    // getJeu() {
    //     axios.get('http://localhost:8001/GetJeuxById.php?idJeux=' + this.props.idJeu).then((res) => {
    //         // console.log(res.data);
    //         this.setState({ jeu: res.data });
    //         // console.log('stateJeu', this.state.jeu); 

    //     });

    // }


    getJeuxRecommende() {
        console.log('jeu recommende', this.state.jeu);
        if (this.state.jeu.id) {
            let jeuxRecommendes = this.state.jeuxRecommendes;
            this.state.jeu.genres.map(genre => {
                axios.get('http://localhost:8001/GetJeux.php?idGenre=' + genre.id).then((res) => {
                    // console.log('jeuxRecommende', res.data);
                    res.data.map(data => {

                        let found = jeuxRecommendes.find(jeu => jeu.id == data.id);
                        if (!found && this.state.jeu.id != data.id) {
                            jeuxRecommendes.push(data);
                            this.setState({ jeuxRecommendes: jeuxRecommendes });
                        }
                    });


                })
            });
        }
        console.log('jeux recommendes', this.state.jeuxRecommendes);

    }

    getAvis() {
        axios.get('http://localhost:8001/GetAvis.php?idJeux=' + this.state.jeu.id).then((res) => {
            console.log('avis res', res.data);
            if (res.data.length > 0) {
                let avis = [];
                res.data.map(data => {
                    avis.push(data);
                    this.setState({ avis: avis });
                });
                // console.log('avis state', this.state.avis);
            }
        })
    }
    verifJeu() {
        // console.log(this.state.jeu);
        if (this.state.jeu.titre) {
            // console.log('state jeu', this.state.jeu);
            return <JeuDetail jeu={this.state.jeu} />
        }
    }

    verifJeuxRecommende() {
        // console.log('jeuxRecommende verif avant if', this.state.jeuxRecommendes);
        if (this.state.jeuxRecommendes.length > 0) {
            // console.log(this.state.jeuxRecommendes.length);
            return <ListeJeuxRecommende listeJeux={this.state.jeuxRecommendes} callback={this.handleCallback.bind(this)} />;
        }
    }

    verifAvis() {
        if (this.state.avis.length > 0) {
            return <ListeAvis listeAvis={this.state.avis} />
        } else {
            return <h3>Aucun avis postés</h3>
        }
    }

    verifUser() {
        if (this.state.user.username) {
            let notes = [''];
            let i = 0;
            for (i = 0; i <= 20; i++) {
                notes.push(i);
            }
            return (
                <div>
                    <button onClick={this.displayForm} id="button_donner_avis">Donner son avis</button>
                    <form action="#" id="avis_client_form" method="POST">
                        {/* <input type="hidden" name="id_user" value={this.state.user.id} />
                        <input type="hidden" name="id_jeux" value={this.state.jeu.id} /> */}

                        <div id="textarea_message">
                            <label htmlFor="id_message">Message</label>
                            <textarea id="id_message" name="message"></textarea>
                        </div>
                        <div id="select_note">
                            <label>Note</label>
                            <select name="note" id="id_note">
                                {notes.map(note => {
                                    return <option value={note}>{note}</option>
                                })}
                            </select>
                        </div>



                        <button type="button" onClick={this.addUser.bind(this)}>Ajouter</button>
                    </form>
                </div>
            )
        }
    }

    handleCallback(jeu) {
        // console.log('handleCallBack jeuxFocus', jeu);
        // window.history.replaceState(null, '', '/jeuxFocus-' + jeu.id);
        this.props.callback('');
        this.setState({ jeu: jeu, jeuxRecommendes: [], avis: [], jeuFromSearch: {} });
    }
    displayForm(event) {
        let form = document.getElementById('avis_client_form');
        let displayForm = getComputedStyle(form).display;
        let button = event.target;
        button.innerHTML = 'Annuler';
        // console.log(button);
        // console.log('form_avis_client style', getComputedStyle(form).display);
        if (displayForm == 'none') {
            form.style.display = 'flex';
        } else {
            form.style.display = 'none';
            button.innerHTML = 'Donner son avis';
        }

    }
    addUser() {
        let message = $('#id_message')[0].value;
        let note = $('#id_note')[0].value;
        if (message.length > 0 && note != '') {
            let data = {
                jeuxId: this.state.jeu.id,
                userId: this.state.user.id,
                message: message,
                note: note
            }
            // console.log('data', data);
            axios.post('http://localhost:8001/AddAvis.php', data).then(res => {
                // console.log('res', res);
                this.getAvis();
                let form = document.getElementById('avis_client_form');
                form.style.display = 'none';
            })
        }

    }
    render() {
        return (


            <div id="main_jeux_focus">
                <div id="jeux_avis">
                    {this.verifJeu()}
                    <div id="avis_user">
                        <h1>Avis des utilisateurs</h1>
                        <div id="avis">
                            {this.verifUser()}
                            {this.verifAvis()}

                        </div>

                    </div>


                </div>


                {this.verifJeuxRecommende()}
            </div>

        )
    }


}



export default JeuxFocus;