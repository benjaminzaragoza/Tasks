<template>
    <div class="flex justify-center">
        <div class="flex flex-col">
        <h1 class="text-center text-red-light">Tasques({{total}}) </h1>
            <div class="flex-row"  >

        <input type="text" placeholder="Nova Tasca"
               v-model="newTask" @keyup.enter="add"
               class="m-3 mt-5 p-2 pl-5 shadow border rounded focus:outline-none focus:shadow-outline text-grey-darker">
        <button @click="add" class="text-center text-red"  >Afegir</button>
        </div>
            <!-- -->
        <ul>
            <li v-for="task in filteredTasks" :key="task.id">
                <span :class="{ strike: task.completed == '1'}">
                    <editable-text
                            :text="task.name" @edited="editName(task, $event)"
                    ></editable-text>
                </span>
                <span @click="remove(task)">&#215;</span>
            </li>
        </ul>
<!-- -->
<br>
            <h3>Filtros:</h3>
            <br>
            Filtre emprat -> {{ filter }}

            <ul>
                <br>
                <li><button @click="setFilter('all')">Totes</button></li>
                <li><button @click="setFilter('completed')">Completades</button></li>
                <li><button @click="setFilter('active')">Pendents</button></li>
            </ul>
        </div>
    </div>
</template>
<script>
    // <!--Rquire en php -->
    import EditableText from './EditableText'
    var filters = {
        all: function(tasks) {
            return tasks
        },
        completed: function(tasks) {
            return tasks.filter(function (task) {
                return task.completed
                // NO CAL
                // if (task.completed) return true
                // else return false
            })
        },
        active: function(tasks) {
            return tasks.filter(function (task) {
                return !task.completed
            })
        },
    }
    export default {

        name:'Tasks',
        components: {
            'editable-text': EditableText
        },
        data() {
            return {
                filter: 'all', // All Completed Active
                newTask: '',
                dataTasks: this.tasks
            }
        },
        props: {
            'tasks': {
                type: Array,
                default: function () {
                    return []
                }
            }
        },
        computed: {
            total() {
                return this.dataTasks.length
            },
            filteredTasks() {
                // Segons el filtre actiu
                // Alternativa switch/case -> array associatiu
                return filters[this.filter](this.dataTasks)
            }
        },
        watch:{
            tasks(newTasks){
                this.dataTasks=newTasks;
            }
        },
        methods: {
            editName(task,text){
                task.name=text
            },
            setFilter(newFilter) {
                this.filter = newFilter
            },
            add() {
                this.dataTasks.splice(0,0,{ name: this.newTask, completed: false } )
                this.newTask=''
            },
            remove(task) {
                this.dataTasks.splice(this.dataTasks.indexOf(task),1)
            }
            // edit(task){
            //
            // }
        }
    }
</script>

<style>
    .strike {
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
