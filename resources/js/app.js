import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader
import 'material-design-icons-iconfont/dist/material-design-icons.css' // Ensure you are using css-loader
import './bootstrap'
import 'typeface-montserrat/index.css'
import 'typeface-roboto/index.css'

// import '../../resources/img/tenants/iesebre/iesebre_cellular-education-classroom-159844.jpeg'
// import '../../resources/img/tenants/iesebre/iesebre_cellular-education-classroom-159844.webp'
import '../../resources/img/task.png'
import '../../resources/img/task.webp'
import '../../resources/img/github.png'
import '../../resources/img/github.webp'
import '../../resources/img/image.webp'
import '../../resources/img/image.jpg'
import '../../resources/img/task2.jpg'
import '../../resources/img/task2.webp'
// import 'material-design-icons-iconfont/node_modules/material-design-icons.css'
import '@fortawesome/fontawesome-free/css/all.css'
// import 'font-awesome/css/font-awesome.min.css'
import ImgWebp from './components/ImgWebp.vue'
import VParallaxWebp from './components/VParallaxWebp.vue'
import AppComponent from './components/App.vue'
import ExempleComponent from './components/ExampleComponent.vue'
import tasks from './components/Tasks.vue'
import Tasques from './components/Tasques.vue'
import LoginForm from './components/LoginForm.vue'
import RegisterForm from './components/RegisterForm.vue'
import UserList from './components/UserList'
import UserSelect from './components/UserSelect'
import NewsLetterSubscriptionCard from './components/newsletter/NewsLetterSubscriptionCard.vue'
import Newsletters from './components/newsletter/Newsletters'
import Tags from './components/Tags.vue'
import permissions from './plugins/permissions'
import snackbar from './plugins/snackbar'
import confirm from './plugins/confirm'
import UsersList from './components/users/UsersList.vue'
import Impersonate from './components/Impersonate'
import GitInfo from './components/git/GitInfoComponent'
import Color from './components/Color'
import Profile from './components/Profile'
import Changelog from './components/changelog/ChangelogComponent.vue'
import VueTimeago from 'vue-timeago'
import TreeView from 'vue-json-tree-view'
import TasksTags from './components/TasksTags'
import vFooter from './components/vFooter'
import ServiceWorker from './components/ServiceWorker'
import Navigation from './components/Navigation'
import NavigationRight from './components/NavigationRight'
import NotificationsWidget from './components/notifications/NotificationsWidget'
import UsersOnlineWidget from './components/users/UsersOnlineWidget'
import Notifications from './components/notifications/Notifications'
import ShareFab from './components/ShareFab'
import Vibrate from './components/Vibrate'
import Geolocation from './components/Geolocation'
import Battery from './components/Battery'
import Memory from './components/Memory'
import Network from './components/Network'
import OnlineStatus from './components/OnlineStatus'
import Orientation from './components/Orientation'
import SpeedTest from './components/SpeedTest'
import MainToolbar from './components/MainToolbar'
import Clock from './components/ui/Clock.vue'
import ShowOneTask from './components/ShowOneTask.vue'
import Chat from './components/chat/Chat'
import Game from './components/game/Game'

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

window.axios.interceptors.response.use((response) => {
  return response
}, function (error) {
  if (window.disableInterceptor) return Promise.reject(error)
  if (error && error.response) {
    // Refresh CSRF TOKEN
    // dAMpDXBRrjVJ2TKewouYHgOeozZmW72EiAt5K1jY
    console.log('PROVA ###############')
    if (error.response.status === 419) {
      console.log('419 error intercepted!!!!!')
      return window.helpers.getCsrfToken().then((token) => {
        console.log('TOKEN OBTAINED:')
        console.log(token)
        window.helpers.updateCsrfToken(token)
        console.log('csrf token updated!')
        error.config.headers['X-CSRF-TOKEN'] = token
        console.log('resend request!!!')
        return window.axios.request(error.config)
      }).catch(e => {
        console.log("NO s'ha pogut obtenir el CSRFTOKEN")
        console.log(e)
      })
    }
    console.log('1')
    if (error.response.status === 401) {
      window.Vue.prototype.$snackbar.showError("No heu entrat al sistema o ha caducat la sessió. Renviant-vos a l'entrada del sistema")
      const loginUrl = location.pathname ? '/login?back=' + location.pathname : '/login'
      console.log('Waiting to redirect to:')
      console.log(loginUrl)
      setTimeout(function () { window.location = loginUrl }, 3000)
      // Break the promise chain -> https://github.com/axios/axios/issues/715
      return new Promise(() => {})
    }
    if (error.response.status === 403) {
      window.Vue.prototype.$snackbar.showSnackBar(
        'Error 403!',
        'error',
        'No teniu permisos per realitzar aquesta acció.',
        'center'
      )
    }
    console.log('2')
    if (error.response.status === 422) {
      console.log('%%%%%%%%%%%%%%%%% ERROR DE VALIDACIó %%%%%%%%%%%%%%%')
      console.log(error.response)
      console.log(error.response.data)
      console.log(error.response.data.message)
      console.log(error.response.data.errors)
      window.Vue.prototype.$snackbar.showSnackBar(
        error.response.data.message,
        'error',
        window.helpers.printObject(error.response.data.errors),
        'center'
      )
    }
    console.log('3')
    if (error.response.status === 404) {
      console.log('%%%%%%%%%%%%%%%%% NOT FOUND ERROR %%%%%%%%%%%%%%%')
      console.log(error.response)
      console.log(error.response.data)
      console.log(error.response.data.message)
      console.log(error.response.data.errors)
      window.Vue.prototype.$snackbar.showSnackBar(
        'Error 404!',
        'error',
        "No s'ha pogut trobar al servidor el recurs que demaneu.",
        'center'
      )
    }
    if (error.response.status === 405) {
      console.log('%%%%%%%%%%%%%%%%% METHOD NOT ALLOWED FOUND ERROR %%%%%%%%%%%%%%%')
      console.log(error.response)
      console.log(error.response.data)
      console.log(error.response.data.message)
      console.log(error.response.data.errors)
      window.Vue.prototype.$snackbar.showSnackBar(
        'Error 405!',
        'error',
        'Tipus de petició HTTP incorrecte.',
        'center'
      )
    }
    if (error.response.status === 500) {
      console.log('%%%%%%%%%%%%%%%%% SERVER ERROR %%%%%%%%%%%%%%%')
      console.log(error.response)
      console.log(error.response.data)
      console.log(error.response.data.message)
      console.log(error.response.data.errors)
      window.Vue.prototype.$snackbar.showSnackBar(
        'Error 500!',
        'error',
        'Error inesperat al servidor',
        'center'
      )
    }
    return Promise.reject(error)
  }
  if (error.request) {
    window.Vue.prototype.$snackbar.showError("Error de xarxa! No s'ha obtingut cap resposta a la vostra petició. Consulteu l'estat de la xarxa.")
    window.Vue.prototype.$snackbar.showSnackBar('Error de xarxa!', 'error', "No s'ha obtingut cap resposta a la vostra petició. Consulteu l'estat de la xarxa.")
    return Promise.reject(error)
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
Vue.component('navigation-right', NavigationRight)
Vue.component('notifications-widget', NotificationsWidget)
Vue.component('users-online-widget', UsersOnlineWidget)
window.Vue.component('notifications', Notifications)
window.Vue.component('share-fab', ShareFab)
window.Vue.component('fo', vFooter)
window.Vue.component('img-webp', ImgWebp)
window.Vue.component('v-parallax-webp', VParallaxWebp)
window.Vue.component('vibrate', Vibrate)
window.Vue.component('geolocation', Geolocation)
window.Vue.component('battery', Battery)
window.Vue.component('orientation', Orientation)
window.Vue.component('network', Network)
window.Vue.component('memory', Memory)
window.Vue.component('onlinestatus', OnlineStatus)
window.Vue.component('memory', Memory)
window.Vue.component('speed', SpeedTest)
window.Vue.component('main-toolbar', MainToolbar)
window.Vue.component('newsletter-subscription-card', NewsLetterSubscriptionCard)
window.Vue.component('newsletters', Newsletters)
window.Vue.component('clock', Clock)
window.Vue.component('show-one-task', ShowOneTask)
window.Vue.component('chat', Chat)
window.Vue.component('users-list', UsersList)
window.Vue.component('game', Game)

window.Vue.component('login-form', LoginForm)
// Vue.component('tags', require('./components/Tags'))
const app = new window.Vue(AppComponent)
