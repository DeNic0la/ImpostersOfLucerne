<template>
    <div class="container-md">
        <div class="card mt-5" v-if="this.identity">
            <img :src="'img/rolePictures'+RoleImage" class="card-img-top" :alt="'Rolle'+this.identity">
            <div class="card-body">
                <h5 class="card-title">{{interpretPlayerRole(this.identity)}}</h5>
                <p class="card-text" v-if="this.identity == 1" >Du bist Crewmate. Crewmate ist die Standartrolle, du hast keine besonderen Fähigkeiten. Dein Ziel ist es alle Imposter Auszuschalten.</p>
                <p class="card-text" v-if="this.identity == 2" >Du bist Imposter. Imposter sind die "Bösen", du kannst jede nacht zusammen mit den anderen Imposter jemanden Ausschalten. Dein Ziel ist es alle Crewmates auszuschalten.</p>
                <p class="card-text" v-if="this.identity == 3" >Du bist Security, du bist ein Crewmate mit besonderen Fähigkeiten. Du kannst jede Nacht die Identität eines Mitspielers ermitteln.</p>
                <p class="card-text" v-if="this.identity == 4" >Du bist Vitals, du bist ein Crewmate mit besonderen Fähigkeiten. Du kannst 1 mal pro Spiel einen Spieler vor dem Tot durch Imposter bewahren und 1 mal pro Spiel einen Spieler Ausschalten.</p>
                <p class="card-text" v-if="this.identity == 5" >Du bist Admin, du bist ein Crewmate mit besonderen Fähigkeiten. Du kannst zu beginn des Spieles 2 Spieler verlinken, wenn einer dieser Spieler sirbt, stirbt der ander auch.</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['identity'],
    methods:{
        interpretPlayerRole($seRole){
            if ($seRole == 1){
                this.RoleImage = '/crewmate.png';
                return "Crewmate";
            }else if($seRole == 2){
                this.RoleImage = '/imposter.png';
                return "Imposter";
            }else if($seRole == 3){
                this.RoleImage = '/security.png';
                return "Security";
            }else if($seRole == 4){
                this.RoleImage = '/vitals.png';
                return "Vitals";
            }else if($seRole == 5){
                this.RoleImage = '/admin.png';
                return "Admin";  
            }
            else{
                return "Undefined: "+$seRole;
            }
        }
    },
    data: function(){
        return{
            RoleImage: '/crewmate.png',
        }
    }
}
</script>