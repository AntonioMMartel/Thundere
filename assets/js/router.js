import Vue from 'vue';
import VueRouter from 'vue-router'


Vue.use(VueRouter)

import Bookmarks from './vue/views/Bookmarks'
import CountryViewer from './vue/views/CountryViewer'
import Home from './vue/views/Home'
import Login from './vue/views/Login'
import Registration from './vue/views/Registration'
import Logout from './vue/views/Logout'
import VueTest from './vue/views/VueTest'

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/bookmarks', component: Bookmarks },
        { path: '/', component: Home },
        { path: '/login', component: Login },
        { path: '/countries/:country', component: CountryViewer, props: true },
        { path: '/register', component: Registration },
        { path: '/logout', component: Logout },
        { path: '/test', component: VueTest },   
    ]
})

export default router;
