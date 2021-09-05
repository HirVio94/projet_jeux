import React from 'react';
import ListeJeuxItem from '../Components/ListeJeuxItem';

class ListeJeuxRecommende extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            listeJeux: [],
        }
    }
    componentDidMount() {
        this.setState({ listeJeux: this.props.listeJeux });
    }

    renderJeuxItem() {
        // console.log('this.list.jeuxList.length', this.state.listeJeux.length);
        if (this.state.listeJeux.length > 0) {
            this.state.listeJeux.map(jeuxItem => {
                // console.log('jeuxItem-renderJeuxItem', jeuxItem);
                return <ListeJeuxItem jeuxItem={jeuxItem} />;
            })
        }

    }

    handleCallback(jeu){
        // console.log('handleCallback', jeu);
        this.props.callback(jeu);
    }
    render() {
        console.log('renderJeuxItem', this.renderJeuxItem());
        return (
            <div id="list_jeux_recommende">
                <h1>Liste Jeux recommendés</h1>
                {this.state.listeJeux.map(jeuxItem => {
                // console.log('jeuxItem-renderJeuxItem', jeuxItem);
                return <ListeJeuxItem jeuxItem={jeuxItem} callback={this.handleCallback.bind(this)}/>;
            })}
            </div>

        )
    }
}

export default ListeJeuxRecommende;