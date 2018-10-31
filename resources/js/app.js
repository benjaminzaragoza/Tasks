import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader
import 'material-design-icons-iconfont/dist/material-design-icons.css' // Ensure you are using css-loader
import './bootstrap'
import AppComponent from './components/App.vue'
import ExempleComponent from './components/ExampleComponent.vue'
import tasks from './components/Tasks.vue'
import LoginForm from './components/LoginForm.vue'
window.Vue = Vue
window.Vue.use(Vuetify)

// Window en browser (objecte global)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.Vue.component('example-component', ExempleComponent)
window.Vue.component('tasks', tasks)

window.Vue.component('login-form', LoginForm)
Vue.component('tags', require('./components/Tags'))

// const app = new Vue({
//     el: '#app'

const app = new window.Vue(AppComponent)
