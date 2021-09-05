import React, { createElement } from 'react';
import axios from 'axios';

class Filtres extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            genres: [],
            developpeurs: [],
            page: ''
        }
    }
    componentDidMount() {
        this.getGenres();
        this.getDeveloppeurs();
        this.setState({ page: this.props.page });
    }
    componentDidUpdate() {
        if (this.state.page != this.props.page) {
            let form = $('#form_filtre')[0];
            let button = $('#button_filtre')[0];
            button.innerHTML = 'Filtres';
            form.style.display = 'none';
            this.setState({ page: this.props.page });
        }
    }
    getGenres() {
        axios.get('http://localhost:8001/GetGenres.php').then(res => {
            this.setState({ genres: res.data });
        });
    }
    getDeveloppeurs() {
        axios.get('http://localhost:8001/GetDeveloppeurs.php').then(res => {
            this.setState({ developpeurs: res.data });
        })
    }
    affichageSelect(event) {
        let inputGenres = $('#genres')[0];
        let inputDeveloppeurs = $('#developpeurs')[0];
        let selectDeveloppeur = $('#select_filtre_developpeur')[0];
        let selectGenres = $('#select_filtre_genre')[0];
        if (inputGenres.checked) {
            if (window.getComputedStyle(selectGenres).display == 'none' || inputGenres.style.display == 'none') {
                selectGenres.style.display = 'block';
                selectDeveloppeur.style.display = 'none';
            }
        } else {
            if (inputDeveloppeurs.checked) {
                if (window.getComputedStyle(selectDeveloppeur).display == 'none' || inputDeveloppeurs.style.display == 'none') {
                    selectDeveloppeur.style.display = 'block';
                    selectGenres.style.display = 'none';
                }
            }
        }
        // event.preventDefault();

    }

    affichageFormFiltre(event) {
        let button = event.target;
        let form = $('#form_filtre')[0];
        if (window.getComputedStyle(form).display == 'none') {
            form.style.display = 'flex';
            button.innerHTML = 'annuler';
        } else {
            form.style.display = 'none';
            button.innerHTML = 'Filtres';
            this.props.callbackFiltreJeux();
        }

    }
    verifFormData(event) {
        event.preventDefault();
        // console.log('props', this.props);
        let inputGenres = $('#genres')[0];
        let inputDeveloppeurs = $('#developpeurs')[0];
        if (inputGenres.checked) {
            let options = document.getElementsByClassName('option_genre');
            // console.log('option', options);
            options.forEach(option => {
                // console.log('option', option);
                if (option.selected) {
                    // console.log('props', this.props);
                    this.props.callbackFiltre(option.value);
                }
            });
        } else {
            if (inputDeveloppeurs.checked) {
                let options = document.getElementsByClassName('option_developpeur');
                options.forEach(option => {
                    if (option.selected) {
                        this.props.callbackFiltreDeveloppeur(option.value);
                    }
                })
            }
        }

    }

    render() {
        return (
            <div id="filtre">
                <button id="button_filtre" onClick={this.affichageFormFiltre.bind(this)}>Filtres</button>
                <div id="div_form_filtre">
                    <form id="form_filtre">
                        <div>
                            <div>
                                <label htmlFor="genres">Genres</label>
                                <input type="radio" value="genres" name="filtres" id="genres" onClick={this.affichageSelect.bind(this)} />
                            </div>
                            <div>
                                <label htmlFor="developpeurs">Developpeurs</label>
                                <input type="radio" value="developpeurs" name="filtres" id="developpeurs" onClick={this.affichageSelect.bind(this)} />
                            </div>

                            <div>
                                <select id="select_filtre_genre" className="select_filtre">
                                    {this.state.genres.map(genre => {
                                        return <option value={genre.id} className="option_genre">{genre.libelle_genre}</option>
                                    })}
                                </select>
                                <select id="select_filtre_developpeur" className="select_filtre">
                                    {this.state.developpeurs.map(developpeur => {
                                        return <option value={developpeur.id} className="option_developpeur">{developpeur.libelle_developpeur}</option>
                                    })}
                                </select>
                            </div>
                        </div>

                        <button type="submit" onClick={this.verifFormData.bind(this)}>Appliquer filtres</button>
                    </form>

                </div>

            </div>
        )
    }
}

export default Filtres;