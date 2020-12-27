import VueRouter from "vue-router";

// routes 
let routes = [
    {
      path: "/",
      component: require("./components/frontend/layout/FrontendLayoutComponent.vue"),
      children: [
        {
          'path': "",
          'component' : require("./components/frontend/homepage/HomepageComponent.vue")
        },
        {
          'path': "/movie/:movieId",
          'component' : require("./components/frontend/movie/MovieDetailsComponent.vue")
        },
        {
          'path': "/my-bookings",
          'component' : require("./components/frontend/booking/MyBookingComponent.vue")
        },
        { path: '/login', 
          component: require("./components/login.vue"),
          meta: {
            forVisitors: true
          }
        },
        { path: '/register', 
          component: require("./components/register.vue"),
          meta: {
            forVisitors: true
          }
        },
        {
          path: "/admin-panel",
          meta: {
            forAuth: true
          },
          component: require("./components/admin/layout/AdminLayoutComponent.vue"),
          children: [     
            {
              path: '',
              redirect: '/admin-panel/dashboard'
            },       
            {
              path: '/admin-panel/dashboard',
              component: require("./components/admin/dashboard/AdminDashboardComponent.vue"),
            },
            {
              path: "/admin-panel/theatres",
              component: require("./components/admin/theatres/ListTheatreComponent.vue"),
            },
            {
              path: "/admin-panel/theatres/add",
              component: require("./components/admin/theatres/AddTheatreComponent.vue"),
            },
            {
              path: "/admin-panel/movies",
              component: require("./components/admin/movies/ListMovieComponent.vue"),
            },
            {
              path: "/admin-panel/movies/add",
              component: require("./components/admin/movies/AddMovieComponent.vue"),
            },
            {
              path: "/admin-panel/shows",
              component: require("./components/admin/shows/ListShowComponent.vue"),
            },
            {
              path: "/admin-panel/shows/add",
              component: require("./components/admin/shows/AddShowComponent.vue"),
            }
          ]
        },
        { path: '/404', 
          component: require("./components/404.vue") 
        },
      ]
    },
    
    { path: '*', redirect: '/404' },  
  ];

export default new VueRouter({
    routes,
    linkActiveClass: "active"
  });