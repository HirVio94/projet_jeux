import React from 'react';

class ListeJeuxItem extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            jeuxItem: {},
        }
    }
    componentDidMount() {
        this.setState({ jeuxItem: this.props.jeuxItem }, () => {
            this.formatDate();
        })
    }

    verifJeuNoteMoyenne() {
        if (this.state.jeuxItem.noteMoyenne) {
            return <span>{this.state.jeuxItem.noteMoyenne} / 20</span>
        } else {
            return <span>Aucune note enregistrée</span>
        }
    }

    verifJeuxItem() {
        if (this.state.jeuxItem.titre) {
            // console.log('jeuxItem verif', this.state.jeuxItem);
            return (
                <div className="jeux_vignette" onClick={this.handleClick.bind(this)}>
                    <div className="jeux_vignette_image">
                        <img src={this.state.jeuxItem.couverture_path} />
                    </div>
                    <div className="infos_jeux">
                        <h3><span className="span_jeu_titre">{this.state.jeuxItem.titre}</span> <span className="span_jeu_note"> Note : {this.verifJeuNoteMoyenne()}</span></h3>
                        <ul>
                            <li>Développeur : {this.state.jeuxItem.developpeur.libelle_developpeur}</li>
                            <li>Genres :  {this.state.jeuxItem.genres.map(genre => {
                                return <span> {genre.libelle_genre} </span>
                            })} </li>
                            <li>Date de sortie : {this.state.jeuxItem.date_sortie}</li>
                        </ul>
                    </div>

                </div>

            )
        }
    }
    formatDate() {
        let date = this.state.jeuxItem.date_sortie.split('-');
        date = date[2] + '-' + date[1] + '-' + date[0];
        let jeu = this.state.jeuxItem;
        jeu.date_sortie = date;
        this.setState({ jeuxItem: jeu });
    }

    handleClick() {
        let jeuxItem = this.state.jeuxItem;
        let jeuxRecommende = $('#list_jeux_recommende')[0];
        let button = $('#display_jeux_recommende')[0];
        let jeux = $('#jeux_avis')[0];
        jeuxRecommende.style.display = 'none';
        button.innerHTML = 'Jeux recommendés';
        jeux.style.display = 'flex';
        this.props.callback(jeuxItem);
    }
    render() {
        // console.log('jeuxItem', this.state.jeuxItem);
        return (
            <div>
                {this.verifJeuxItem()}
            </div>

        )
    }
}

export default ListeJeuxItem;