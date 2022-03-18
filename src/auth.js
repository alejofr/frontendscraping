import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)

const auth =  new Vuex.Store({
    state: {
        loginStatus: false,
        token: ''
    },
    mutations: {
        authStateUpdate(state){
            state.loginStatus = true;
        },
        login(state, token){
            state.token = token;
            localStorage.setItem('token', token);
        },
        closeSession(state){
            state.loginStatus = false;
            state.token = "";
            localStorage.removeItem('token');
        }
    },
    actions: {
        inicio({commit}, token) {
            commit('authStateUpdate');
            commit('login', token);
        }
    }
})


if (localStorage.getItem('token')) {
    let token = localStorage.getItem('token');
    console.log(token);
    auth.commit('authStateUpdate');
    auth.commit('login', token);
}


export default auth
