import React from 'react';

class JeuDetail extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            jeu: {},
        }
    }

    componentDidMount() {
        this.setState({ jeu: this.props.jeu }, () => {
            this.formatDate();
        });
        // console.log('didmount', this.state.jeu);
    }

    componentDidUpdate() {
        if (this.props.jeu.titre != this.state.jeu.titre) {
            this.setState({ jeu: this.props.jeu }, () => {
                this.formatDate();
            });
        }
    }
    verifJeux() {
        if (this.state.jeu.titre) {
            return (
                <div >
                    <h2>{this.state.jeu.titre}</h2>
                    <div id="jeux_detail_header">
                        <div id="couverture">
                            <img src={this.state.jeu.couverture_path} alt={"couverture de " + this.state.jeu.titre} />
                        </div>
                        <div id="description">
                            <div id="note">
                                <h3><span>Description</span></h3>
                                <h3><span>{this.state.jeu.noteMoyenne} / 20</span></h3>
                            </div>
                            <p>
                                {this.state.jeu.description}
                            </p>

                        </div>

                    </div>
                    <div id="video">
                        <iframe src={this.state.jeu.video_path}></iframe>
                    </div>
                    <div id="jeux_detail_footer">
                        <ul>
                            <li>
                                Développeur : {this.state.jeu.developpeur.libelle_developpeur}
                            </li>
                            <li>
                                Genres : {this.state.jeu.genres.map(genre => {
                                    return <span> {genre.libelle_genre} </span>
                                })}
                            </li>
                            <li>
                                Classification : {this.state.jeu.classification.libelle_classification}
                            </li>
                            <li>
                                Plateformes : {this.state.jeu.plateformes.map(plateforme => {
                                    return <span> {plateforme.libelle_plateforme} </span>
                                })}
                            </li>
                            <li>
                                Date de sortie : {this.state.jeu.date_sortie}
                            </li>
                        </ul>
                    </div>
                </div>
            )
        }
    }
    formatDate() {
        let reg = new RegExp(/^[0-9]{2}[-][0-9]{2}[-][0-9]{4}$/);
        let date = this.state.jeu.date_sortie;
        console.log('date',date);
        console.log('reg', reg.test(date));
        if (reg.test(date) == false) { 
            console.log('reg', reg.test(date));
            date = date.split('-');
            date = date[2] + '-' + date[1] + '-' + date[0];
            let jeu = this.state.jeu;
            jeu.date_sortie = date;
            this.setState({ jeu: jeu });
        }

       
    }
    render() {
        // console.log('jeuDetailProps', this.props.jeu);
        // console.log('jeuState', this.state.jeu);
        return (
            <div id="jeux_detail">
                {this.verifJeux()}
            </div>
        )
    }
}

export default JeuDetail;