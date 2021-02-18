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
                    let vm = this;
                    window.Echo.private("game."+this.currentRoom.id).listen('.game.confirm', e => {
                        this.gameStage = 1;
                        axios.post('/game/room/'+this.currentRoom.id+'/confirmSelf');
                    });
                    window.Echo.private("game."+this.currentRoom.id).listen('.game.started', e => {
                        this.gameStage = 2;
                        axios.get('/game/room/'+ this.currentRoom.id +'/identity').then(response => {
                            this.identity = response.data;
                        }).catch(error => {console.log(error);})
                    });
                }
            },
            disconnect(room){
                window.Echo.leave("game."+room.id);
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
            this.getRooms();
            
            
        }
    }
</script>
