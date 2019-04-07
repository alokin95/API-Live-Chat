import VueRouter from "vue-router";


let routes = [
  {
    path: '/',
    component: require('./components/Register').default
  },
  {
    name: 'home',
    path: '/home',
    component: require('./components/Chat').default
  }
 ];

export default new VueRouter({
  routes
});