cd<script>
export default
{
  el: '#app',
  name: 'App',
  data: () => ({
    drawer: true,
    drawerRight: false,
    mini: false,
    right: null,
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
    ]
  }),
  props: {
    source: String
  }
}
</script>
