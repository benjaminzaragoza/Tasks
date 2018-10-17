
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')

window.Vue = require('vue')
window.Vue.use(require('vuetify'))

// Window en browser (objecte global)
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.Vue.component('example-component', require('./components/ExampleComponent.vue'))
window.Vue.component('tasks', require('./components/Tasks.vue'))

// const app = new Vue({
//     el: '#app'
// });

const app = new window.Vue({
  el: '#app',
  data: () => ({
    drawer: null,
    items: [
      {
        src: 'https://conceptodefinicion.de/wp-content/uploads/2016/10/Programaci%C3%B3n-Inform%C3%A1tica.jpg'
      },
      {
        src: 'https://http2.mlstatic.com/phpstorm-20182-jetbrains-winmaclinux-lancamento-D_NQ_NP_823880-MLB27128236374_042018-F.jpg'
      },
      {
        src: 'https://styde.net/wp-content/uploads/2018/04/Post_VuePaginate.png'
      },
      {
        src: 'http://flagshipstore.telefonica.es/WebRoot/acens/Shops/3591595/5AD2/94FF/DFA5/2870/822D/7F00/0001/C558/php_1920x1080.jpg'
      }
    ]
  }),
  props: {
    source: String
  }
})
