<template>
    <div class="flex justify-center">
        <div class="flex flex-col">
        <h1 class="text-center text-red-light">Tasques</h1>
            <div class="flex-row"  >

        <input type="text" placeholder="Nova Tasca"
               v-model="newTask" @keyup.enter="add"
               class="m-3 mt-5 p-2 pl-5 shadow border rounded focus:outline-none focus:shadow-outline text-grey-darker">
        <button @click="add" class="text-center text-red"  >Afegir</button>
        </div>
        <ul>
            <li v-for="task in filteredTasks" :key="task.id">
                <span :class="{ strike: task.completed }">{{task.name}}</span>
                &nbsp;
                <span @click="remove(task)">&#215;</span>
            </li>
        </ul>

<br>
            <h3>FILTRES</h3>
            <br>
            <!--Activa filter:{{filter}}-->
            <ul>
                <li><button @click="setfilter=('all')">Totes</button></li>
                <li><button @click="setfilter=('completed')">Completades</button></li>
                <li><button @click="setfilter=('active')">Pendets</button></li>

            </ul>
        </div>
    </div>
</template>

<script>
    var filters = {
        all:function (tasks) {
            return tasks
        },
        completed:function (tasks) {
            return tasks.filter(function (task) {
                return task.completed
                // if (task.completed)return true
                // else return false
            })
        },
        active:function (tasks) {
            return tasks.filter(function (task) {
                return !task.completed
            })
        },
    }
    //document.getEkebementById
    export default {
        data(){
            return {
                filter:'all',
                newTask:'',
                tasks: [
                    {
                        id:1,
                        name:'Comprar pa ',
                        completed:false
                    },
                    {
                        id:2,
                        name:'Comprar llet ',
                        completed:true
                    },
                    {
                        id:3,
                        name:'Estudiar php ',
                        completed:false
                    },
                ]
            }
        },
        computed: {
            total(){
              return this.tasks.length
            },
            filteredTasks(){
                //Segons el filtre actiu
                return filters[this.filter](this.tasks)
            }
        },
        methods:{
            setfilter(newFilter){

                this.filter=newFilter

            },
            add(){
                // console.log('TODO ADD')
                this.tasks.splice(0,0,{name:this.newTask,completed:false})
                this.newTask=''
            },
            remove(task){
                window.console.log(task)

                this.tasks.splice(this.tasks.indexOf(task),1)
            }
        }
    }
    // {
    //     marca:'Renault',
    //     consum:'5l/100',
    //     start: function (){
    //         console.log('arraca');
    // }
    //
    // }
</script>

<style>
    .strike{
        text-decoration: line-through;
    }

</style>
    // {
    //     marca:'Renault',
    //     consum:'5l/100',
    //     start: function (){
    //         console.log('arraca');
    // }
    //
    // }
