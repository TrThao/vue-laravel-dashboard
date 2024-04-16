import { createStore } from "vuex";

const store = createStore({
  state: {
    token: localStorage.getItem('token') || null ,
    user: JSON.parse(localStorage.getItem('user')) || null,
  },
  mutations: {
    UPDATE_TOKEN(state, payload) {
      state.token = payload;
    },
     UPDATE_USER(state, payload) {
      state.user = payload;
  },
  },
  actions: {
    setToken(context, payload) {
      localStorage.setItem('token', payload); 
      context.commit('UPDATE_TOKEN', payload);
    },
    setUser(context,payload){
      localStorage.setItem('user', JSON.stringify(payload));
       context.commit('UPDATE_USER',payload);
    },
    removeToken(context) {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      context.commit('UPDATE_TOKEN', null);
      context.commit('UPDATE_USER', null);
    },
  },
  getters: {
    getToken(state) {
      return state.token;
    },
    getUser(state){
      return state.user
    },
  }
});

export default store;
