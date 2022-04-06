import { createWebHistory, createRouter } from "vue-router";
import Login from "../components/Login.vue";
import Home from "../components/Home.vue";
import RouterMiddleware from "./middleware";
import middlewareCheckGuest from "./middleware/auth.middleware";

// lazy-loaded
const Profile = () => import("../components/Profile.vue");
const Product = () => import("../components/Product.vue");

const routerMiddleware = new RouterMiddleware();

routerMiddleware.group(
  'Guest',
  [],
  [
    {
      path: "/login",
      component: Login,
    },
  ],
);

routerMiddleware.group(
  'AuthenticatedUsersOnly',
  [middlewareCheckGuest],
  [
    {
      path: "/",
      name: "home",
      component: Home,
    },
    {
      path: "/profile",
      name: "profile",
      component: Profile,
    },
    {
      path: "/product",
      name: "product",
      component: Product,
    },
  ],
);

let routes = [];
routes = routes.concat(...routerMiddleware.buildRoutes());

const router = createRouter({
  history: createWebHistory(),
  routes,
});

routerMiddleware.addRouter(router);

export default router;