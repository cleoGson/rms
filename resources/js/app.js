/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import { Form, HasError, AlertError } from 'vform';
import VueProgressBar from 'vue-progressbar';
import Highcharts from 'highcharts'
import { mapState } from 'vuex'
import Swal from 'sweetalert2';
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
window.Swal =Swal;

window.Form =Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.use(Highcharts)
Vue.component('mapState',mapState)

Vue.component()
Vue.use(VueRouter)
Vue.use({mapState})
const routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/projects', component: require('./components/Project.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/country', component: require('./components/settings/Country.vue').default },
    { path: '/region', component: require('./components/settings/Region.vue').default },
    { path: '/district', component: require('./components/settings/District.vue').default },
    { path: '/ward', component: require('./components/settings/Ward.vue').default },
    { path: '*', component: require('./components/Profile.vue').default },
  ];
  

  const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  })
  window.toast =toast;
  const router = new VueRouter({
    mode: 'history',
    routes 
  });

  window.Fire = new Vue();
Vue.filter('upperText', function(text){
return text.toUpperCase();
});
//Vue.use(DatatableFactory);

const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
      speed: '0.2s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'left',
    inverse: false
  }
  
  Vue.use(VueProgressBar, options)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue').default
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('coin-add-component', require('./components/charts/AddComponent.vue').default);
Vue.component('chart-component', require('./components/charts/ChartComponent.vue').default);
Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);

const app = new Vue({
    el: '#app',
    router
});
