<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <room-selection
                    v-if="currentRoom.id"
                    :rooms="Rooms"
                    :currentRoom="currentRoom"
                    v-on:roomchanged="setRoom($event)"
                    @click="getRooms"
                />


            </h2>



        </template>

            <identity-display
                :identity="identity"
            />
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import RoomSelection from './roomSelection.vue'
    import Game from './game.vue'
    import IdentityDisplay from './identityDisplay.vue'

    export default {
        components:{
            AppLayout,
            RoomSelection,
            Game,
            IdentityDisplay
        },
        data: function () {
            return{
                Rooms: [],
                currentRoom: [],
                identity: 0,
                gameStage: 0,
            }
        },
        watch:{
            currentRoom( val, oldVal ){
                if(oldVal.id){
                    this.disconnect(oldVal);
                }
                this.connect();
            }
        },
        methods:{
            connect(){
                if(this.currentRoom.id){
                    //this.lobby(0);

                }
            },
            lobby(state){
                let vm = this
                if (state === 1){
                    vm.getIdentity();
                    return;
                }
                var url = '/game/room/'+ this.currentRoom.id +'/lobby';
                axios.get(url).then(response => {
                    console.log(response);
                    setTimeout(function () {
                        vm.lobby(response.data);
                    }, 5000);
                }).catch(error => {console.log(error);})
            },
            getIdentity(){
                let vm = this;
                var url = '/game/room/'+ this.currentRoom.id +'/identity';
                axios.get(url).then(response => {
                    this.identity = response.data;
                }).catch(error => {console.log(error);})
            },
            disconnect(room){
                axios.post('/game/room/'+room.id+'/deleteSelf');
            },
            getRooms(){
                axios.get('/game/rooms')
                .then( response =>{
                    this.Rooms = response.data;
                    this.setRoom(response.data[0]);
                })
                .catch( error => {
                    console.log(error);
                })
            },
            setRoom( room){
                this.currentRoom = room;
                axios.post('/game/room/'+ room.id +'/join');
            },
        },
        created(){
            let vm =this;
            vm.getRooms();
            vm.lobby(0);

        }
    }
</script>
