/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/main.scss';
import Vue from 'vue';
import axios from "axios";


// Header
import VueHeader from './components/VueHeader.vue';

new Vue({
    el: '#app_header',
    components: {VueHeader}
});

// Article
import VueArticleSearch from './components/VueArticleSearch.vue';
import VueLogin from './components/VueLogin.vue';
import VueRegister from './components/VueRegister.vue';
new Vue({
    el: '#app_article',
    components: {VueArticleSearch, VueLogin, VueRegister}
});

// Footer
import VueFooter from './components/VueFooter.vue';

new Vue({
    el: '#app_footer',
    components: {VueFooter}
});

// Test
import VueTest from './components/VueTest.vue';

new Vue({
    el: '#app_test',
    components: {VueTest}
});