<template>
    <div class="container">
        <div v-if="this.identity" class="d-flex flex-column justify-content-around">
            {{interpretPlayerRole(this.identity)}}
            <img :src="RoleImage" alt="Rolle{{this.identity}}">
        </div>
    </div>
</template>

<script>
export default {
    props: ['identity'],
    methods:{
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
                return "Undefined: "+$seRole;
            }
        }
    },
    data: function(){
        return{
            RoleImage: 'img/duude.png',
        }
    }
}
</script>