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

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import RoomSelection from './roomSelection.vue'
    
    export default {
        components:{
            AppLayout,
            RoomSelection,

        },
         data: function () {
            return{
                Rooms: [],
                currentRoom: [],
                identity: [],
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
        },
        created(){
            this.getRooms();
            axios.post('/game/room/'+this.currentRoom.id+'/join')
        }
    }
</script>
