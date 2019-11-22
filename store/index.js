export const getters = {
  isAuth(state) {
    return state.auth.loggedIn;
  },
  getUser(state) {
    return state.auth.user;
  }
};
