import { createApp } from "vue";
import App from "./App.vue";
import router from "./route";
import store from "./store";
import "bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import { FontAwesomeIcon } from "./plugins/font-awesome";

createApp(App)
  .use(router)
  .use(store.applicationStore)
  .component("font-awesome-icon", FontAwesomeIcon)
  .mount("#app");
