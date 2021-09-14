import axios from 'axios';
import React from 'react';


class Header extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			user: {},
			listeJeux: []
		}
	}
	componentDidMount() {
		axios.get('http://localhost:8001/GetUser.php?idUser=' + this.props.idUser).then(res => {
			// console.log('user', res.data);
			if (res.data) {
				this.setState({ user: res.data });
			}

		})
	}
	handleClickI() {
		console.log('user', this.state.user);
		location.replace('/user/profil-' + this.state.user.id);
	}
	verifUser() {

		if (this.state.user.username) {
			// console.log('roles', this.state.user.roles);
			this.props.userCallback(this.state.user);
			return (
				<div id="div_authentification">
					<div onClick={this.handleClickI.bind(this)} id="icone_profil">
						<i className="fas fa-user-circle" ></i>
					</div>

					{this.verifRole()}
					<div id="div_deconnexion">
						<a href='/logout'>Se deconnecter</a>
					</div>
				</div>
			);
		} else {
			return (
				<div id="div_authentification">
					<div id="div_connexion">
						<a href="/login">Se connecter</a>
					</div>
					<div id="div_creer_compte">
						<a href="/user/newUser">Créer un compte</a>
					</div>
				</div>
			)

		}
	}

	verifRole() {
		if (this.state.user.roles == '["ROLE_ADMIN"]') {

			return (
				<div>
					<a href="/admin">Accès backoffice</a>
				</div>
			);
		}
	}

	handleOnChange(event) {
		let input = event.target;
		// console.log('input', input.value);
		// if (input.value != '') {
		// 	axios.get('http://localhost:8001/GetJeux.php?titre=' + input.value + '&sortBy=note').then(res => {
		// 		this.setState({ listeJeux: res.data }, () => {
		// 			// console.log('listeJeux', this.state.listeJeux);
		// 		});
		// 	});
		// }else{
		// 	this.setState({listeJeux: []});
		// }
		if (input.value != '') {
			axios.get('http://localhost:8001/GetJeux.php?titre=' + input.value + '&sortBy=note').then(res => {
				this.setState({ listeJeux: res.data });
			});
		} else {
			this.setState({ listeJeux: [] });
		}


	}
	handleClick(event) {
		// console.log('click event.target', event);
		let idJeu = event.target.nextSibling.innerHTML;
		let inputSearch = document.getElementById('input_search');
		let divTitre = $('#div_titre')[0];
		let divRecherche = $('#div_recherche')[0];
		let divHeaderContainer = $('#div_header_container')[0];
		let divSvgSearch = $('#svg_recherche')[0];

		if (divTitre.style.display == 'none') {
			divRecherche.style.display = 'none';
			divTitre.style.display = 'flex';
			divTitre.style.width = '100%';
			divHeaderContainer.style.width = '0%';
			divSvgSearch.style.display = 'block';
		}
		inputSearch.value = '';
		this.setState({ listeJeux: [] }, () => {
			this.props.callback(idJeu);
		})

	}

	verifListeJeux() {
		// console.log('liste jeux verif liste', this.state.listeJeux);
		if (this.state.listeJeux.length > 0) {
			return this.state.listeJeux.map(jeu => {
				return <li><span onClick={this.handleClick.bind(this)}>{jeu.titre}</span><span style={{ display: 'none' }}>{jeu.id}</span></li>
			})
		}
	}
	menuBurger(event) {
		let svg = $('#menu')[0];
		console.log('menu', svg);
		let nav = $('nav')[0];
		if (window.getComputedStyle(nav).display == 'none') {
			nav.style.display = 'flex';
			svg.style.color = 'black';
		} else {
			nav.style.display = 'none';
			svg.style.color = 'white';
		}

	}
	displaySearch() {
		let divSearch = $('#div_recherche')[0];
		let divTitre = $('#div_titre')[0];
		let divHeaderContainer = $('#div_header_container')[0];
		let divSvgSearch = $('#svg_recherche')[0];
		let svgRetour = $('svg.svg-inline--fa.fa-angle-right.fa-w-8')[0];


		svgRetour.style.display = 'block';
		divHeaderContainer.style.width = '100%'
		divHeaderContainer.style.justifyContent = 'center'
		divTitre.style.display = 'none';
		divSearch.style.display = 'flex';
		divSvgSearch.style.display = 'none';
	}

	retourClick() {
		let divSearch = $('#div_recherche')[0];
		let divTitre = $('#div_titre')[0];
		let divHeaderContainer = $('#div_header_container')[0];

		divHeaderContainer.style.width = '0%';
		divTitre.style.display = 'flex';

		divSearch.style.display = 'none';

	}

	displayMenuAuthentification(){
		let divAuthentification = document.querySelector('#div_authentification');
		console.log(typeof(divAuthentification), divAuthentification);
		if(divAuthentification.style.display == 'flex'){
			divAuthentification.style.display = 'none';
		}else{
			divAuthentification.style.display = 'flex';
		}
	}
	render() {
		return (
			<header>


				<div id="menu_burger" onClick={this.menuBurger}>
					<i className="fas fa-bars" id="menu"></i>
				</div>

				<div id="div_container">
					<div id="div_titre">
						<h1>JeuxProject</h1>
					</div>

					<div id="div_header_container">
						<div id="div_recherche">
							<div>


								<input type="text" placeholder="rechercher un jeu" onChange={this.handleOnChange.bind(this)} id="input_search" />
								<i className="fas fa-search"></i>
								<i className="fas fa-angle-right"></i>

							</div>
						</div>
						<div id="div_result_search">
							<ul>
								{this.verifListeJeux()}
							</ul>
						</div>
						{this.verifUser()}

						{/* <div id="div_authentification"> */}


						{/* {% if app.user %}
								<i class="fas fa-user-circle"></i>
								{% if is_granted('ROLE_ADMIN') %}
									<div>
										<a href={{ path('admin') }}>Accès backoffice</a>
									</div>
								{% endif %}
								<div id="div_deconnexion">
									<a href={{ path('logout')}}>Se deconnecter</a>
								</div>
							{% else %}
								<div id="div_connexion">
									<a href={{ path('login') }}>Se connecter</a>
								</div>
								<div id="div_creer_compte">
									<a href="">Créer un compte</a>
								</div>

							{% endif %} */}


						{/* </div> */}
					</div>

				</div>
				<div id="svg_recherche" onClick={this.displaySearch}>
					<i className="fas fa-search" ></i>
				</div>
				<div id="menu_authentification" onClick={this.displayMenuAuthentification}>
					<i className="fas fa-ellipsis-v"></i>
				</div>
			</header>

		)
	}
}

export default Header;