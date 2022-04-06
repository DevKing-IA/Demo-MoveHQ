import { createStore } from "vuex";
import auth from "./auth.module";

export function createApplicationStore() {
  const applicationStore = createStore({
    modules: {
      auth,
    },
  });

  function checkLoggedIn() {
    return applicationStore.state.auth.loggedIn;
  }

  return {
    applicationStore,
    checkLoggedIn,
  };
}

const store = createApplicationStore();

export default store;
