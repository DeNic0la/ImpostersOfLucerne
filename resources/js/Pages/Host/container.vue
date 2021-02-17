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
                <div v-for="(player,index) in Players" :key="index">
                    <player
                        :Player="player"                  
                    />  
                </div>
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
            },
            getPlayers(){
                axios.get('/host/room/'+this.currentRoom.id+'/players')
                .then(response => {
                    this.Players = response.data;
                }).catch(error => {console.log(error);})
            }
        },
        created(){
            this.getRooms();
            this.getPlayers();
        }
    }
</script>
