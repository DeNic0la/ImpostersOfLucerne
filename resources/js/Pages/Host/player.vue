<template>
    <th scope="row">{{Player.user.name}}</th>
    <td>{{interpretPlayerRole(Player.role)}}</td>
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
            },
            interpretPlayerRole($seRole){
                if ($seRole == 1){
                    return "Crewmate";
                }else if($seRole == 2){
                    return "Imposter";
                }else if($seRole == 3){
                    return "Security";
                }else if($seRole == 4){
                    return "Vitals";
                }else if($seRole == 5){
                    return "Admin";  
                }
                else{
                    return $seRole;
                }
            }
        }
    }
    
</script>
