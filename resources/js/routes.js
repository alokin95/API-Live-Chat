import VueRouter from "vue-router";


let routes = [
  {
    path: '/',
    component: require('./components/Register').default
  }
 ];

export default new VueRouter({
  routes
});