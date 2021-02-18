<template>
    <th scope="row">{{Player.user.name}}</th>
    <td>{{Player.role}}</td>
    <td>{{getIsReady()}}</td>
    <td class=""><button @click="deletePlayer()" class="btn btn-danger text-white">Delete</button></td>
</template>

<script>
    export default {
        props: ['Player','room'],
        methods:{
            getIsReady(){
                if (this.Player.ready == 1){
                    return "Ready"
                }
                else{
                    return "Not"
                }
            },
            deletePlayer(){    
                this.$emit('playerDeleted');
            }
        }
    }
    
</script>
