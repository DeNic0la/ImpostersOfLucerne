<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <room-selection 
                    v-if="currentRoom.id"
                    :rooms="Rooms"
                    :currentRoom="currentRoom"
                    v-on:roomchanged="setRoom($event)"
                />

                
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Rolle</th>
                        <th scope="col">Ready</th>
                        <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(player,index) in Players" :key="index">
                            <player
                                :Player="player"
                                :room="currentRoom"    
                                v-on:playerDeleted="deletePlayer(player)"              
                            /> 
                        </tr>                       
                    </tbody>
                </table>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import RoomSelection from '../Player/roomSelection.vue'
    import Player from './player.vue'



    export default {
        components:{
            AppLayout,
            RoomSelection,
            Player,

        },
         data: function () {
            return{
                Rooms: [],
                currentRoom: [],
                Players: [],
            }
        },
        methods:{
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
                this.getPlayers(room);
            },
            getPlayers(room){
                axios.get('/host/room/'+room.id+'/players')
                .then(response => {
                    this.Players = response.data;
                }).catch(error => {console.log(error);})
            },
            deletePlayer(playerToDelete){

                axios.post('host/room/'+this.currentRoom.id+'/delete',{
                    playerId: playerToDelete.id
                })
                .then( response =>{                
                    if (response.data == 1){
                        this.getPlayers(this.currentRoom);
                    }
                    else{
                        alert("There was an Error delete this Player, refresh the page and Try again");
                    }                
                })
            }
        },
        created(){
            this.getRooms();
        }
    }
</script>
