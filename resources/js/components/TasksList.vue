<template>
    <span>
        <v-toolbar color="secondary" style="margin-top: -2.5%">
            <v-menu>
                <v-btn slot="activator" icon dark>
                    <v-icon>more_vert</v-icon>
                </v-btn>
                <v-list>
                    <v-list-tile>
                        <v-list-tile-title>Opció 1</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile href="http://google.com">
                        <v-list-tile-title>Google</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
            <v-icon class="white--text">assignment</v-icon>
            <v-toolbar-title class="white--text">Tasques</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon class="white--text">
                <v-icon>settings</v-icon>
            </v-btn>
            <v-btn icon class="white--text" @click="refresh" :loading="loading" :disabled="loading">
                <v-icon>refresh</v-icon>
            </v-btn>
        </v-toolbar>
        <v-card>
            <v-card-title>
                <v-layout row wrap>
                    <v-flex lg3 class="pr-2">
                        <v-select
                                label="Filtres"
                                :items="filters"
                                v-model="statusBy"
                                item-text="name"
                                :return-object="true"
                        ></v-select>
                    </v-flex>
                    <v-flex lg4 class="pr-2">
                        <user-select
                                url="/api/v1/users"
                                label="Usuari"
                                v-model="filterUser"
                                :users="dataUsers"
                        ></user-select>
                    </v-flex>
                    <v-flex lg5>
                        <v-text-field
                                append-icon="search"
                                label="Buscar"
                                v-model="search"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-card-title>
            <v-data-table
                    :headers="headers"
                    :items="getFilteredTasks"
                    :search="search"
                    no-results-text="No s'ha trobat cap registre coincident"
                    no-data-text="No hi han dades disponibles"
                    rows-per-page-text="Tasques per pàgina"
                    :rows-per-page-items="[5,10,25,50,100,200,{'text':'Tots','value':-1}]"
                    :loading="loading"
                    :pagination.sync="pagination"
                    class="hidden-md-and-down"
            >
                <v-progress-linear slot="progress" color="primary" indeterminate></v-progress-linear>
                <template slot="items" slot-scope="{item: task}">
                     <tr class="text-xs-left">
                        <td class="text-xs-left" >{{task.id}}</td>
                        <td class="text-xs-left">
                            <span  :title="task.description">{{ task.name }}</span>
                        </td>
                        <td class="text-xs-left">
                            <v-avatar :title="(task.user !== null) ? task.user_name + ' - ' + task.user_email : 'Usuari no assignat'">
                                <img :src="(task.user !== null) ? task.user_gravatar : 'http://icons.iconarchive.com/icons/hopstarter/halloween-avatar/256/Minion-Pig-icon.png'">
                            </v-avatar>
                        </td>
                        <td class="text-xs-left">
                                     <task-completed-toggle :status="task.completed" :task="task" :tags="tags"></task-completed-toggle>
                        </td>
                          <td>
                            <tasks-tags :task="task" :tags="tags"  @added="task.tags.push($event)" @removed="searchForTasks"
                            ></tasks-tags>
                        </td>
                        <td class="text-xs-left">
                            <span  :title="task.created_at_formatted">{{ task.created_at_human}}</span>
                        </td>
                        <td class="text-xs-left" >
                            <span :title="task.updated_at_formatted">{{ task.updated_at_human}}</span>
                        </td>
                        <td class="text-xs-left d-flex">
                            <task-show :task="task" :uri="uri" :users="users"></task-show>
                            <task-update :task="task" @updated="updateTask" :uri="uri" :users="users"></task-update>
                            <task-destroy :task="task" @deleted="removeTask" :uri="uri"></task-destroy>
                        </td>
                    </tr>
                </template>
            </v-data-table>
            <v-data-iterator class="hidden-lg-and-up"
                             :items="dataTasks"
                             :search="search"
                             no-results-text="No s'ha trobat cap registre coincident"
                             no-data-text="No hi han dades disponibles"
                             rows-per-page-text="Tasques per pàgina"
                             :rows-per-page-items="[5,10,25,50,100,200,{'text':'Tots','value':-1}]"
                             :loading="loading"
                             :pagination.sync="pagination"
            >
<v-flex
        slot="item"
        slot-scope="{item:task}"
        xs12
        sm6
        md4
        >
        <v-container
                fluid
                grid-list-lg
        >.
            <div class="flipper"  :class="flipperClass == true ? 'flip-class' : false">
                <v-card class="card xl front" >
                <section class="wrapper" :style="{backgroundColor: randomColor(task.user_id)}">
                  <v-flex xs5 color="primary darken-1 " >
                      <img style="margin-left: 53%;margin-top: 30%;width: 150px;height: 150px;border-radius: 160px;"
                           contain :src="(task.user !== null) ? task.user_gravatar : 'http://icons.iconarchive.com/icons/hopstarter/halloween-avatar/256/Minion-Pig-icon.png'">
                  </v-flex>
                    <footer class="card-footer" >
                        <h6>{{ task.user_name }}</h6>
                        <h4 class="headline text-capitalize" >{{ task.name }}</h4>
                        <p>{{ task.description }}</p>
                        <v-spacer></v-spacer>
                      <v-card-actions class="py-0">
                          <p style="margin-left: -4%;margin-top: 11%;">{{ task.updated_at_human}}</p>
                          <v-btn icon @click="clickFlip" >
                      <v-icon style="margin-left: 570%;margin-top: 37%;color: #0d47a1">sync</v-icon>
                    </v-btn>
                </v-card-actions>
                    </footer>
                </section>
                </v-card>
                <v-card class="card xl back">
                     <section class="wrapper" :style="{backgroundColor: randomColor(task.user_id)}">
                     <h3  class="headline text-capitalize" style="text-align:center;margin-top: 10%">{{ task.name }}</h3>
                  <v-chip style="height: 12%;margin-top: 10%;margin-left: 15%;margin-bottom: 10%;">
                    <v-avatar  :title="(task.user !== null) ? task.user_name + ' - ' + task.user_email : 'Usuari no assignat'">
                                        <img height="30%" :src="(task.user !== null) ? task.user_gravatar : 'http://icons.iconarchive.com/icons/hopstarter/halloween-avatar/256/Minion-Pig-icon.png'">
                     </v-avatar>
                     {{task.user_name}}
                  </v-chip>
                    <v-spacer light></v-spacer>
                    <v-card-actions class="justify-center">
                   <tasks-tags   :task="task" :tags="tags"  @added="task.tags.push($event)" @removed="searchForTasks"
                   ></tasks-tags></v-card-actions>
                  <footer class="card-footer" >
                  <v-spacer light></v-spacer>
                <v-card-actions  class="justify-center" >
                   <task-show :task="task" :uri="uri" :users="users"></task-show>
                    <task-update :task="task" @updated="updateTask" :uri="uri" :users="users"></task-update>
                    <task-destroy :task="task" @deleted="removeTask" :uri="uri"></task-destroy>
                </v-card-actions>
                      <v-card-actions  color="red">
                      <task-completed-toggle  :status="task.completed" :task="task" :tags="tags"></task-completed-toggle>
                      <v-btn  icon @click="clickFlip" >
                      <v-icon color="#0d47a1">sync</v-icon>
                    </v-btn>
                      </v-card-actions  >

                    </footer>
                </section>
                <div class="content">
                </div>
                    </v-card>

                 </div>
                </v-container>
            </v-flex>
            </v-data-iterator>
        </v-card>
    </span>
</template>

<script>
import TaskCompletedToggle from './TaskCompletedToggle'
import TaskDestroy from './TaskDestroy'
import TaskUpdate from './TaskUpdate'
import TaskShow from './TaskShow'
import TasksTags from './TasksTags'

export default {
  name: 'TasksList',
  data () {
    return {
      user: '',
      user_id: '',
      loading: false,
      dataTasks: this.tasks,
      dataUsers: this.users,
      filter: 'Totes',
      filterUser: null,
      flipperClass: false,
      filters: [
        { name: 'Totes', value: 'TotesF' },
        { name: 'Completades', value: true },
        { name: 'Pendents', value: false }
      ],
      statusBy: { name: 'Totes', value: 'Totes' },
      search: '',
      pagination: {
        rowsPerPage: 5
      },
      colorCache: {},
      headers: [
        { text: 'Id', value: 'id' },
        { text: 'Name', value: 'name' },
        { text: 'User', value: 'user_id' },
        { text: 'Completat', value: 'completed' },
        { text: 'Etiquetes', value: 'tags' },
        { text: 'Creat', value: 'created_at_timestamp' },
        { text: 'Modificat', value: 'updated_at_timestamp' },
        { text: 'Accions', sortable: false, value: 'full_search' }
      ]
    }
  },
  components: {
    'task-completed-toggle': TaskCompletedToggle,
    'task-destroy': TaskDestroy,
    'task-show': TaskShow,
    'task-update': TaskUpdate,
    'tasks-tags': TasksTags
  },
  props: {
    tasks: {
      type: Array,
      required: true
    },
    tags: {
      type: Array
    },
    users: {
      type: Array,
      required: true
    },
    uri: {
      type: String,
      required: true
    }
  },
  computed: {
    getFilteredTasks () {
      let filterUser = this.filterUser
      let statusBy = this.statusBy
      let tasks = this.dataTasks
      if (filterUser == null) {
        tasks = this.dataTasks
      } else if (filterUser !== null) {
        tasks = tasks.filter((task) => {
          if (task.user_id == filterUser.id) return true
          else return false
        })
      }
      if (statusBy.value != 'Totes') {
        tasks = tasks.filter((task) => {
          if (task.completed == statusBy.value) return true
          else return false
        })
      }
      return tasks
    }
  },
  watch: {
    tasks (newTasks) {
      this.dataTasks = newTasks
    }
  },
  methods: {
    clickFlip: function () {
      this.flipperClass = !this.flipperClass
    },
    searchForTasks () {
      this.loading = true
      window.axios.get(this.uri).then((response) => {
        this.loading = false
        this.dataTasks = response.data
      }).catch((error) => {
        this.$snackbar.showError(error.response.data.message)
      })
    },
    randomColor (id) {
      const r = () => Math.floor(256 * Math.random())
      return this.colorCache[id] || (this.colorCache[id] = `rgb(${r()}, ${r()}, ${r()})`)
    },
    removeTask (task) {
      this.dataTasks.splice(this.dataTasks.indexOf(task), 1)
    },
    updateTask (task) {
      this.refresh()
    },
    refresh () {
      this.loading = true
      window.axios.get(this.uri).then(response => {
        this.dataTasks = response.data
        this.loading = false
        this.$snackbar.showMessage('Tasques actualitzades correctament')
      }).catch(error => {
        console.log(error)
        this.loading = false
      })
    }
  }
}
</script>
<style>
    @font-face {
        src: url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/565097/Roboto-Regular.woff2")
        format("woff2"),
        url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/565097/Roboto-Regular.woff")
        format("woff"),
        url("https://s3-us-west-2.amazonaws.com/s.cdpn.io/565097/Roboto-Regular.ttf")
        format("ttf");
    }
    *, *:before, *:after {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    /* ================================= *
     * Cards outer Styling
     ==================================== */
    main.concord {
        margin: 20px 0;
        text-align: center;
    }
    .concord > header {
        width: 90%;
        padding: 0px 15px 0px 15px;
        margin: 0 auto;
        position: relative;
        display: block;
        overflow: auto;
        text-align: left;
    }
    .concord > header time {
        display: table-cell;
        float: left;
        color: black;
    }
    .concord > header time:first-child {
        color: #8f8f91;
    }
    .concord > header time h3 {
        color: black;
        font-weight: 700;
    }

    .concord > header avatar{
        display: table-cell;
        text-align: right;
        float: right;
        background-position: center;
        background-size: 120%;
        background-repeat: no-repeat;
        border-radius: 50%;
        height: 50px;
        width: 50px;
    }
    /* ================================= *
     * Card Styling + Default
     ==================================== */
    .card {
        z-index: 1;
        cursor: pointer;
        display: inline-block;
        position: static;
        text-align: left;
        width: 89%;
        height: 400px;
        max-height: 400px;
        border-radius: 10px;
        margin: 15px 8px;
        overflow: hidden;
        background: white;
        box-shadow: 0px 4px 5px 0px rgba(0, 0, 0, 0.10),
        0px 1px 20px 0px rgba(0, 0, 0, 0.10);
        transform-origin: center;
        transition: transform, width, height, border-radius, top, left;
        transition-duration: 500ms;
        transition-timing-function: ease-in-out;
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select:none;
        user-select:none;
        -o-user-select:none;
    }
    .card.gate_reserved{
        box-shadow: none;
    }
    .card .wrapper {
        height: 100%;
        width: 100%;
        position: relative;
        display: table;
    }
    .card h5,
    .card h6,
    .card p {
        margin: 4px 0;
    }
    .card h6,
    .card p {
        color: #8f8f91;
    }
    .card h6 {
        text-transform: uppercase;
    }
    .card video,
    .card img {
        display: table-cell;
        position: relative;
        width: 100%;
        height: 100%;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }
    .card > .wrapper > header,
    .card > .wrapper > footer{
        display: table-cell;
        width: 100%;
        height: auto;
        padding: 15px 20px;
        box-sizing: border-box;
    }
    .card > .wrapper > footer{
        background: white;
        position: absolute;
        bottom: 0;
        top:60%;
        left: 0;
    }
    .card:active {
        transform: scale(0.97);
    }

    /* Card Style: x */
    .card.x h4,
    .card.x p {
        color: white;
    }
    .card.x h6 {
        color: rgba(255, 255, 255, 0.65);
    }
    .card.x > .wrapper > header,
    .card.x > .wrapper > footer {
        position: absolute;
        left: 0;
        background: transparent;
        padding: 15px 20px;
    }
    .card.x > .wrapper > header {
        top: 0;
    }
    .card.x > .wrapper > footer {
        bottom: 0;
    }
    /* Card Style: v */
    .card.v .wrapper{display: block;}
    .card.v video{object-fit: cover;}
    .card.v video:before{
        position: absolute;
        right: 15px;
        top: 0;
        background: rgba(255,255,255,0.3);
        content: "mute";
    }
    .flip-container {
        perspective: 1000px;
    }
    /* flip the pane when hovered
    .flip-container:hover .flipper,
    .flip-container.hover .flipper {
      transform: rotateY(180deg);
    } */

    .flip-class {
        transform: rotateY(180deg);
    }
    .flip-container,
    .back {
        backface-visibility: hidden;
        top: 0;
        position: absolute;
        left: 0;
    }
    .flip-container,
    .front {
        backface-visibility: hidden;
        top: 0;
        position: center;
        left: 0;
    }
    .front {
        z-index: 2;
        /* for firefox 31 */
        transform: rotateY(0deg);
    }

    /* back, initially hidden pane */
    .back {
        transform: rotateY(180deg);
    }

    /* flip speed goes here */
    .flipper {
        transition: 0.6s;
        transform-style: preserve-3d;

        position: relative;
    }
    /* Card Style: i */
    .card.i h2,
    .card.i h6,
    .card.i p{
        color: white;
    }
    .card.i h2{
        width: 50%;
        text-transform: uppercase;
    }
    .card.i p{
        font-size: 0.7em;
    }
    .card.i > .wrapper > header,
    .card.i > .wrapper > footer {
        position: absolute;
        left: 0;
        padding: 15px 20px;
    }
    .card.i > .wrapper > header{
        top: 0;
    }
    .card.i > .wrapper > header img{
        width: 70px;
        height: 70px;
        border-radius: 18px;
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        background-color: white;
    }
    .card.i > .wrapper > footer {
        background: transparent;
        bottom: 0;
    }
    button.card{
        position: relative;
        height: auto;
        width: auto;
        border: 0;
        outline: 0;
        font-weight: 600;
        color: rgba(28, 111, 215, 0.88);
        text-align: left;
        background: rgba(255,255,255,0.95);
        border-radius: 20px;
        padding: 4.4px 13px;
    }
    /* Card Style~input styling*/
    input[type="button"].concord{
        cursor: pointer;
        position: absolute;
        height: auto;
        width: auto;
        border: 0;
        outline: 0;
        font-weight: 600;
        color: rgba(28, 80, 245, 0.98);
        text-align: left;
        background: rgba(255,255,255,0.95);
        border-radius: 20px;
        padding: 4.4px 13px;
        margin: 0;
        right: 20px;
        bottom: 19px;
        box-sizing: border-box;
    }
    input[type="button"].concord:active{
        color: rgba(28, 80, 245, 0.48);
    }
    input[type="button"].concord.exit{
        display: none;
        z-index: 99;
        top: 15px;
        right: 20px;
        bottom: initial;
        padding: 2px 6px;
        font-size: 1.2em;
        line-height: 1em;
        color: rgba(255,255,255,0.75);
        background: rgba(20,20,25,0.65);
    }
    input[type="button"].concord-exit:active{
        color: rgba(28, 80, 245, 0.48);
    }
    /* Card State: Content and Card active Styling*/
    .card > .content{
        margin-top: 60px;
        margin-bottom: 20px;
        opacity: 0;
        width: 100%;
        height: 0px;
        transition: height, opacity, margin;
        transition-duration: 900ms;
        transition-timing-function: ease-in-out;
    }
    .card > .content p{
        margin: 35px 20px;
        color: #8f8f91;
    }
    .card > .content p + p{
        margin-top: 0;
    }
    .card > .content p > b{
        color: black;
    }
    .card > .content img{
        position: relative;
        display: block;
        width: 100%;
        height: 300px;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .card > .content img:after{

    }
    .card.in-flight{
        cursor: default;
        z-index: 98;
        display: block;
        max-height: none;
        max-width: none;
        top: 40px!important;
        height: 95vh !important;
        width: 100vw !important;
        margin: 0;
        overflow-y: scroll;
        transform: none;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .card.active:hover{
        transform: none;
    }
    .card.in-flight > .wrapper{
        height: 55%;
    }
    .card.in-flight > input[type="button"].concord.exit{
        display: block;
    }
    .card.in-flight > .content{
        margin-top: 0px;
        height: 45%;
        background: white;
        opacity: 1;
    }

    @media screen and (min-width: 530px){
        .card{
            width: 75%;
        }
    }
    @media screen and (min-width: 600px){
        .card{
            max-width:340px;
            width: 65%;
        }
    }

    @media screen and (max-width: 599px){
        .card.in-flight{
            border-radius: 0;
            max-width: 100%;
            top: 0!important;
            left:0!important;
        }
    }
    @media screen and (min-width: 600px){
        .card.in-flight{
            left: calc((100vw - 460px) / 2)!important;
            max-width: 460px!important;
        }
    }
    @media screen and (min-width: 730px){
        .card{
            max-width:340px;
            width: 40%;
        }
        .card.in-flight{
            left: calc((100vw - 700px) / 2)!important;
            max-width: 700px!important;
        }
    }
    @media screen and (min-width: 1000px){
        .card{
            width: 340px;
        }
        .card.xl{
            width: 600px;
            max-width: 600px;
        }
        .card.xl.active{
            width: 100%;
            max-width: 700px;
        }
    }
</style>
