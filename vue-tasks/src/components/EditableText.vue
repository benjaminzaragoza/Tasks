<template>
    <span>
        <span v-if="!editing" @dblclick="editing=true">
            {{currentText}}
            <svg class="h-3 w-3" @click="editing=true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.3 3.7l4 4L4 20H0v-4L12.3 3.7zm1.4-1.4L16 0l4 4-2.3 2.3-4-4z"/></svg>

        </span>
        <span v-if="editing" @keyup.esc="editing=false"
              @keyup.enter="edit">
            <input type="text" v-model="currentText">

        </span>
    </span>
</template>

<script>
    export default {
        name: 'EditableText',
        data() {
            return {
                editing: false,
                currentText:this.text
            }
        },
        props:{
            'text':{
                type:String,
                require:true
            }
        },
        // props: ['text'],
        methods: {
            edit() {
                this.editing = false
                //informat al pare
                this.$emit('edited',this.currentText)
            }
        }
    }
</script>
