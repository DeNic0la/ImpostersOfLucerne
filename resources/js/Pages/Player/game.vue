<template>
    <div class="container d-flex justify-content-around">
        <button v-if="this.confirmed == 0 && this.stage == 1" @click="confirmSelf()" type="button" class="btn btn-success mt-5">Ich bin Bereit</button>
    </div>
</template>

<script>
export default {
    props: ['room','stage'],
    data: function(){return{
        confirmed: 0,
        }
    },
    methods:{
        confirmSelf(){
            axios.post('/game/room/'+this.room.id+'/confirmSelf')
            .then(response => {
                if (response.data == 1){
                    this.confirmed = 1;
                }
            }).catch(error => {console.log(error);})
        },
    },
}
</script>