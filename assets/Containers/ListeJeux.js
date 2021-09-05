import React from 'react';
import Jeu from '../Components/Jeu';

class ListeJeux extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            jeuxListe: [],
        }
    }
    componentDidMount() {
        this.setState({ jeuxListe: this.props.jeux });
    }
    componentDidUpdate() {

        if (!this.compareJeuxListe()) {
            this.setState({ jeuxListe: this.props.jeux });
        }
    }
    handleCallback(jeu) {
        this.props.callback(jeu);
    }

    compareJeuxListe() {
        if (this.state.jeuxListe.length != this.props.jeux.length) {
            return false;
        } else {
            for (let i = 0; i < this.state.jeuxListe.length; i++) {
                if (this.state.jeuxListe[i].id != this.props.jeux[i].id) {
                    return false;
                }
            }
        }

        return true;
    }
    render() {
        console.log('jeuxListe listejeux', this.state.jeuxListe);
        return (
            <div id="list_jeux">
                {this.state.jeuxListe.map(jeu => {
                    return <Jeu jeu={jeu} callback={this.handleCallback.bind(this)} />
                })}
            </div>
        )

    }
}

export default ListeJeux;