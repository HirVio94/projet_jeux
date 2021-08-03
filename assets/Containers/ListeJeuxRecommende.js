import React from 'react';
import ListJeuxItem from '../Components/ListeJeuxItem';

class ListeJeuxRecommende extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            listeJeux: props.listeJeux,
        }
    }

    renderJeuxItem() {
        this.state.listeJeux.map(jeuxItem => {
            return <ListJeuxItem jeuxItem={jeuxItem} />
        })
    }
    render() {
        console.log('listeJeux', this.state.listeJeux);
        return (
            <div>
                <h1>Liste Jeux recommendés</h1>
                {this.renderJeuxItem()}
            </div>

        )
    }
}

export default ListeJeuxRecommende;