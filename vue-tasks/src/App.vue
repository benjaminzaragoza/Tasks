<template>
  <div id="app">
    <!--Api
      backend, larqavel --lista de taskes

      Api rest no tornen html

      JSON
    -->
    <tasks :tasks="tasks"></tasks>
  </div>
</template>

<script>
    import Tasks from './components/Tasks.vue'
    import axios from 'axios'

    import EditableText from './components/EditableText'
    export default {
        name: 'app',
        data(){
            return{
                tasks:[],
                error:null
            }
        },
        components: {
            'tasks' : Tasks,
        },

        created(){
            console.log('Component ha estat creat ')
            //Ajax
            //XHR
            //api per defecte de javascript
            //jquery
            // llibreria especifica axios

            //javascript no blokeija

            // let result = axios.get('http://localhost:8050/api/v1/tasks')
            // axios.get('http://localhost:8050/api/v1/tasks')

            //callbacks -> funcions  anonimes
            // fileManager.open('/home/benjamin/.bashrc')
            // fileManager.open('/home/benjamin/.bashrc',(file) => {
            //     console.log(file);
            // })
            // promises then.catch
            axios.get('http://localhost:8050/api/v1/tasks').then((response) => {
                this.tasks = response.data
            }).catch((error) => {
                this.error = error
            })
            //ASYNC WAIT
            // async function f() {
            //     // let result= await axios.get('http://localhost:8050/api/v1/tasks')
            // }
        }

    }
</script>

<style>
</style>

