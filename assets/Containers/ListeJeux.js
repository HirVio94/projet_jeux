import React from 'react';
import Jeu from '../Components/Jeu';

class ListeJeux extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            jeuxListe: props.jeux,
        }
    }
    
    render() {
        console.log('jeuxListe listejeux', this.state.jeuxListe);
        return (
            <div>
                {this.state.jeuxListe.map(jeu => {
                    return <Jeu jeu={jeu} />
                })}
            </div>
        )

    }
}

export default ListeJeux;