/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

console.log("Hola soy apsita.js");

const imagesContext = require.context('./images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

import Vue from 'vue';

// Header
import VueHeader from './components/VueHeader.vue';

new Vue({
    el: '#app_header',
    components: {VueHeader}
});

// Article
import VueArticle from './components/VueArticle.vue';

new Vue({
    el: '#app_article',
    components: {VueArticle}
});

// Footer
import VueFooter from './components/VueFooter.vue';

new Vue({
    el: '#app_footer',
    components: {VueFooter}
});

// ----

import Prueba from './components/Prueba.vue';

// Pruebas
new Vue({
    el: '#app_prueba',
    components: {Prueba}
});