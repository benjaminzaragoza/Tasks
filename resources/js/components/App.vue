<script>
export default
{
  el: '#app',
  name: 'App',
  data: () => ({
    drawer: null,
    drawerRight: false,
    photos: [
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
    ],
    items: [
      { icon: 'home', text: 'Tasques', url: '/tasks' },
      {
        icon: 'keyboard_arrow_up',
        'icon-alt': 'keyboard_arrow_down',
        text: 'Tasques segons tipus',
        model: true,
        children: [
          { icon: 'assignment_turned_in', text: 'Tasques amb PHP', url: '/tasks' },
          { icon: 'assignment', text: 'Tasques tamb Tailwind', url: '/tasks_vue' },
          { icon: 'insert_chart', text: 'Tasques amb Vue', url: '/tasques' }
        ]
      },
      { icon: 'local_offer', text: 'Tags', url: '/tags' },
      { icon: 'help', text: 'Sabem mes', url: '/about' },
      { icon: 'photo', text: 'Imatges', url: '/contact' }
    ]
  }),
  methods: {
    impersonate(user) {
      console.log(user)
      if (user) {
        window.location.href = '/impersonate/take/' + user
      } else {
        console.log('sadsfa')
      }
    }
  },
  props: {
    source: String
  }
}
</script>
