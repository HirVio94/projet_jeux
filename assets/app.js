/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import Accueil from './Containers/MainAccueil';
import JeuxFocus from './Containers/JeuxFocus';
import React from 'react';
import ReactDOM from 'react-dom';
import App from './Containers/App';


ReactDOM.render(React.createElement(App), document.querySelector('#app'));
// const e = React.createElement;
// const domContainer = document.querySelector('#like_button_container');
// ReactDOM.render(e(LikeButton), domContainer);