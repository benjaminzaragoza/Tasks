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
import Impersonate from './components/Impersonate'
import GitInfo from './components/git/GitInfoComponent'
import Color from './components/Color'
import Profile from './components/Profile'
import Changelog from './components/changelog/ChangelogComponent.vue'
import VueTimeago from 'vue-timeago'
import TreeView from 'vue-json-tree-view'
import TasksTags from './components/TasksTags'
import ServiceWorker from './components/ServiceWorker'
import Navigation from './components/Navigation'

window.Vue = Vue
window.Vue.use(permissions)
window.Vue.use(snackbar)
window.Vue.use(confirm)

window.Vuetify = Vuetify

const PRIMARY_COLOR_KEY = 'PRIMARY_COLOR_KEY'
const SECONDARY_COLOR_KEY = 'SECONDARY_COLOR_KEY'

const primaryColor = window.localStorage.getItem(PRIMARY_COLOR_KEY) || '#4828d7'

const secondaryColor = window.localStorage.getItem(SECONDARY_COLOR_KEY) || '#2CB1BC'
window.Vue.use(TreeView)
window.Vue.use(VueTimeago, {
  locale: 'ca', // Default locale
  locales: {
    'ca': require('date-fns/locale/ca')
  }
})
window.Vue.use(window.Vuetify, {
  theme: {
    primary: {
      base: primaryColor,
      lighten1: '#6c53df',
      lighten2: '#917ee7',
      lighten3: '#b6a9ef',
      lighten4: '#c8bef3',
      lighten5: '#dad4f7',
      darken1: '#3920ac',
      darken2: '#311b92',
      darken3: '#24146c',
      darken4: '#1d1056'
    },
    secondary: {
      base: secondaryColor,
      lighten1: '#38BEC9',
      lighten2: '#54D1DB',
      lighten3: '#87EAF2',
      lighten4: '#BEF8FD',
      lighten5: '#E0FCFF',
      darken1: '#14919B',
      darken2: '#0E7C86',
      darken3: '#0A6C74',
      darken4: '#044E54'
    },
    accent: {
      base: '#F0B429',
      lighten1: '#F7C948',
      lighten2: '#FADB5F',
      lighten3: '#FCE588',
      lighten4: '#FFF3C4',
      lighten5: '#FFFBEA',
      darken1: '#DE911D',
      darken2: '#CB6E17',
      darken3: '#B44D12',
      darken4: '#8D2B0B'
    },
    error: {
      base: '#ff0000',
      lighten1: '#ff3333',
      lighten2: '#ff4d4d',
      lighten3: '#ff8080',
      lighten4: '#ffb3b3',
      lighten5: '#ffe6e6',
      darken1: '#e60000',
      darken2: '#cc0000',
      darken3: '#b30000',
      darken4: '#800000'
    },
    // Taken from palete 3
    success: {
      base: '#27AB83',
      lighten1: '#3EBD93',
      lighten2: '#65D6AD',
      lighten3: '#8EEDC7',
      lighten4: '#C6F7E2',
      lighten5: '#EFFCF6',
      darken1: '#199473',
      darken2: '#147D64',
      darken3: '#0C6B58',
      darken4: '#014D40'
    },
    grey: {
      base: '#627D98',
      lighten1: '#829AB1',
      lighten2: '#9FB3C8',
      lighten3: '#BCCCDC',
      lighten4: '#D9E2EC',
      lighten5: '#F0F4F8',
      darken1: '#486581',
      darken2: '#334E68',
      darken3: '#243B53',
      darken4: '#102A43'
    }
  }
})

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
window.Vue.component('impersonate', Impersonate)
window.Vue.component('git-info', GitInfo)
window.Vue.component('profile', Profile)
window.Vue.component('color', Color)
window.Vue.component('changelog', Changelog)
Vue.component('tasks-tags', TasksTags)
Vue.component('service-worker', ServiceWorker)
window.Vue.component('navigation', Navigation)

window.Vue.component('login-form', LoginForm)
Vue.component('tags', require('./components/Tags'))
const app = new window.Vue(AppComponent)
