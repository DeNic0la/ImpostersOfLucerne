<template>
    <div class="d-flex flex-row justify-content-around">
        <button @click="collectPlayers()" type="button" :class="{'btn-secondary' : stage , 'btn-success' : stage==0}" class="btn btn-lg mt-5 mx-5">Lock Room</button>
        <button :disabled="stage==0 ? true : false" @click="startGame()" type="button" :class="{'btn-success' : stage , 'btn-warning' : stage==0}" class="btn btn-lg mt-5 mx-5">Start Game</button>
        <button @click="refreshRows()" type="button"  class="btn btn-lg mt-5 mx-5 btn-info">Refresh Rows</button>
        <button @click="resetRoom()" type="button"  class="btn btn-lg mt-5 mx-5 btn-danger">Reset Room</button>
    </div>
    <div class="d-flex flex-row justify-content-around mt-5">
        <div class="form-group">
            <label for="impoCount">Imposter Count</label>
            <input type="number" v-model="imposter" class="form-control" id="impoCount" placeholder="3">
        </div>
        <div>
            <button type="button" @click="this.security = !this.security" :class="{'btn-success' :security , 'btn-danger' : !security }"  class="btn ">Security</button>
        </div>
        <div>
            <button type="button" @click="this.vitals = !this.vitals" :class="{'btn-success' :vitals , 'btn-danger' : !vitals }"  class="btn ">Vitals</button>
        </div>
        <div>
            <button type="button" @click="this.admin = !this.admin" :class="{'btn-success' :admin , 'btn-danger' : !admin }"  class="btn ">Admin</button>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['room'],
        data: function() {
            return {
                stage: 0,
                imposter: 3,
                security: true,
                vitals: true,
                admin: true,
            }
        },
        methods:{
            collectPlayers(){
                axios.post('/host/room/'+ this.room.id+'/collectPlayers');
                this.stage = 1;
                let vm = this;
                vm.refreshRows();
                setTimeout(function () {
                    vm.refreshRows();
                }, 5000);
            },
            refreshRows(){
                this.$emit('refresh');
            },
            startGame(){
                this.stage = 2;
                axios.post('/host/room/'+ this.room.id+'/startGame',{
                    imposter: this.imposter,
                    security: this.security,
                    vitals: this.vitals,
                    admin: this.admin,
                });
                let vm = this;
                setTimeout(function () {
                    vm.refreshRows();
                }, 3000);
            },
            resetRoom(){
                this.stage = 0;
                 axios.post('/host/room/'+ this.room.id+'/resetRoom');
                let vm = this;
                setTimeout(function () {
                    vm.refreshRows();
                }, 3000);
            }
        }
    }

</script>
