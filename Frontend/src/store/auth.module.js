import AuthService from "../services/auth.service";

const AuthStore = {
  namespaced: true,

  state: {
    token: "",
    user: null,
    loggedIn: false,
  },

  mutations: {
    LOGGED_IN(state, { user, token }) {
      state.loggedIn = true;
      state.user = user;
      state.token = token;

      localStorage.setItem("loggedIn", "true");
      localStorage.setItem("token", token);
      localStorage.setItem("userName", user.name);
    },

    LOGGED_OUT(state) {
      state.loggedIn = false;
      state.user = null;
      state.token = "";

      localStorage.removeItem("loggedIn");
      localStorage.removeItem("token");
      localStorage.removeItem("userName");
    },

    LOGIN_FAILURE(state) {
      state.loggedIn = false;
      state.user = null;
      state.token = "";

      localStorage.removeItem("loggedIn");
      localStorage.removeItem("token");
      localStorage.removeItem("userName");
    },
  },

  actions: {
    login({ commit }, data) {
      return AuthService.login(data).then(
        (res) => {
          if (res.data.error) {
            return Promise.reject(res.data.error);
          }
          commit("LOGGED_IN", {
            token: res.data.token,
            user: res.data.user,
          });
          return Promise.resolve();
        },
        (error) => {
          commit("loginFailure");
          return Promise.reject(error);
        }
      );
    },

    logout({ commit, state }) {
      AuthService.logout(state.token);
      commit("LOGGED_OUT");
    },

    setUser({ commit }, data) {
      commit("LOGGED_IN", {
        token: data.token,
        user: data.user,
      });
    },
  },
};

export default AuthStore;
