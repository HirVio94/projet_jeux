import React from 'react';
import axios from 'axios';

class Jeu extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            jeu: {},
        }
    }
    componentDidMount(){
       this.setState({jeu: this.props.jeu}, ()=>{
        //    console.log('jeu', this.state.jeu);
        this.formatDate();
       });
       
    }
    componentDidUpdate(){
        if(this.state.jeu.id != this.props.jeu.id){
            this.setState({jeu: this.props.jeu}, ()=>{
                this.formatDate();
            });
        }
    }
    getGenres(){
        axios.get('http://localhost:8001/GetGenresByJeuxId.php?idJeux=' + this.state.jeu.id).then((res)=>{
            
            let genres = res.data;
            let jeu = this.state.jeu;
            jeu.genres = genres;
            this.setState({jeu: jeu});
            // console.log('jeu', this.state.jeu);
        })
    }
    getPlateformes(){
        axios.get('http://localhost:8001/GetPlateformeByJeuxId.php?idJeux=' + this.state.jeu.id).then((res) => {
            let plateformes = res.data;
            let jeu = this.state.jeu;
            jeu.plateformes = plateformes;
            this.setState({jeu: jeu});
            // console.log(this.state.jeu);
        })
    }
    getClassification(){
        axios.get('http://localhost:8001/GetClassificationByJeuxId.php?idJeux=' + this.state.jeu.id).then((res) => {
            let classification = res.data;
            let jeu = this.state.jeu;
            jeu.classification = classification;
            this.setState({jeu: jeu});
            // console.log(this.state.jeu);
        })
    }
    verifJeuGenres(){

        if(this.state.jeu.genres){
            return (
                this.state.jeu.genres.map(genre => {
                    return <span> {genre.libelle_genre} </span>;
                })
            )
        }
    }
    verifJeuPlateforme(){
        if(this.state.jeu.plateformes){
            return(

                this.state.jeu.plateformes.map(plateforme => {
                    return <span> {plateforme.libelle_plateforme} </span>
                })
            )
        }
    }
    verifJeuClassification(){
        if(this.state.jeu.classification){
            return <span>{this.state.jeu.classification.libelle_classification}</span>
        }
    }
    verifJeuNoteMoyenne(){
        if(this.state.jeu.noteMoyenne){
            return <span>{this.state.jeu.noteMoyenne} / 20</span>
        }else{
            return <span>Aucune note enregistrée</span>
        }
    }

    formatDate(){
        let date = this.state.jeu.date_sortie.split('-');
        date = date[2] +  '-' + date[1] + '-' + date[0];
        let jeu = this.state.jeu;
        jeu.date_sortie = date;
        this.setState({jeu: jeu});
    }
    redirect(event){
        // console.log('redirect-idjeu', this.state.jeu.id);
        window.location = '/jeux-' + this.state.jeu.id;
    }
    handleClick(){
        this.props.callback(this.state.jeu);
    }

    render() {
        return (
            <div className="container_jeux" onClick={this.handleClick.bind(this)}>
                <div className="image_jeux">
                    <img src={this.state.jeu.couverture_path} alt={'Couverture de ' + this.state.jeu.titre} />
                </div>
                <div className="container_info_jeux">
                    <div className="note_titre">
                        <h3>{this.state.jeu.titre}</h3>
                        <h4>Note des utilisateurs : {this.verifJeuNoteMoyenne()} </h4>
                    </div>
                    <div className="info_jeux">
                        <ul>
                            <li> <h4>Genre : {this.verifJeuGenres()}</h4></li>
                            <li> <h4>Plate-forme: {this.verifJeuPlateforme()}</h4></li>
                            <li> <h4>Classification : {this.verifJeuClassification()}</h4></li>
                            <li><h4> Date de sortie : { this.state.jeu.date_sortie }</h4></li>

                        </ul>
                    </div>

                </div>

            </div>
        )
    }
}

export default Jeu;