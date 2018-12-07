import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader
import 'material-design-icons-iconfont/dist/material-design-icons.css' // Ensure you are using css-loader
import './bootstrap'
import AppComponent from './components/App.vue'
import ExempleComponent from './components/ExampleComponent.vue'
import tasks from './components/Tasks.vue'
import Tasques from './components/Tasques.vue'
import LoginForm from './components/LoginForm.vue'
import RegisterForm from './components/RegisterForm.vue'
import UserList from './components/UserList'
import UserSelect from './components/UserSelect'
import Tags from './components/Tags.vue'
import permissions from './plugins/permissions'
import snackbar from './plugins/snackbar'
import confirm from './plugins/confirm'

window.Vue = Vue
window.Vue.use(Vuetify)
window.Vue.use(permissions)
window.Vue.use(snackbar)
window.Vue.use(confirm)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.Vue.component('example-component', ExempleComponent)
window.Vue.component('tasks', tasks)
window.Vue.component('tasques', Tasques)
window.Vue.component('register-form', RegisterForm)
window.Vue.component('user-list', UserList)
window.Vue.component('user-select', UserSelect)
window.Vue.component('tags', Tags)

window.Vue.component('login-form', LoginForm)
Vue.component('tags', require('./components/Tags'))
const app = new window.Vue(AppComponent)
