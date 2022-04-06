import AuthService from "../../services/auth.service";
import store from "../../store";

let firstLoad = true;

async function middlewareCheckGuest() {
  const loggedIn = await store.checkLoggedIn();

  if (firstLoad && !loggedIn) {
    const token = localStorage.getItem("token");

    if (token) {
      const { data } = await AuthService.ping(token);

      if (data.success) {
        store.applicationStore.dispatch("auth/setUser", data);
        return true;
      }
    }

    return "/login";
    //   return '/auth/login?redirectTo=' + to.path;
  }

  firstLoad = false;

  return true;
}

export default middlewareCheckGuest;
