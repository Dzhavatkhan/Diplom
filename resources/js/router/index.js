import {createRouter, createWebHistory} from 'vue-router'
import Home from "../components/Home/Home.vue"
import Registration from "../components//Account/Registration.vue"

let routes = [{
    path: "/",
    component: Home,
    name: 'home'
},
{
    path: "/registration",
    component: Registration,
    name: 'Registration'
}]


let router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
