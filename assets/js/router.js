import Vue from 'vue';
import VueRouter from 'vue-router'


Vue.use(VueRouter)

import Bookmarks from './vue/views/Bookmarks'
import CountryViewer from './vue/views/CountryViewer'
import Home from './vue/views/Home'
import Login from './vue/views/Login'
import Registration from './vue/views/Registration'
import VueTest from './vue/views/VueTest'

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/bookmarks', component: Bookmarks },
        { path: '/', component: Home },
        { path: '/login', component: Login },
        { path: '/countries', component: CountryViewer },
        { path: '/register', component: Registration },
        { path: '/test', component: VueTest },   
    ]
})

export default router;