import _ from 'lodash';

class RouterMiddleware {
  constructor() {
    this.groups = {};
    this.router = null;
  }

  addRouter(router) {
    this.router = router;

    this.router.beforeEach((to, from, next) => {
      this.beforeEach(to, from, next);
    });
  }

  group(groupName, middleware, routes) {
    for (const route of routes) {
      if (route.children) {
        for (const childRoute of route.children) {
          if (!childRoute.meta) {
            childRoute.meta = {};
          }
          childRoute.meta.groupName = groupName;
        }
      }
      if (!route.meta) {
        route.meta = {};
      }
      route.meta.groupName = groupName;
    }

    this.groups[groupName] = {
      middleware: middleware,
      routes: routes,
    };
  }

  buildRoutes() {
    const routes = [];
    for (const groupName of Object.keys(this.groups)) {
      routes.push(this.groups[groupName].routes);
    }

    return routes;
  }

  async beforeEach(to, from, next) {
    let result = null;

    if (to.meta && to.meta.groupName) {
      const groupName = to.meta.groupName;
      const group = this.groups[groupName];
      const middleware = _.cloneDeep(group.middleware);

      while (middleware.length > 0) {
        const middlewareFn = middleware.shift();

        result = await middlewareFn(this.router, to, from);

        if (typeof result === 'string') {
          // Redirect
          next(result);
          break;
        } else if (!result) {
          break;
        }
      }
    } else {
      console.log('NO ROUTE META');
    }

    next();

    return result;
  }
}

export default RouterMiddleware;
