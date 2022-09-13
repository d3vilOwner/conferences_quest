<template>
    <v-app id="inspire">
        <v-main>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md5>
                        <v-card class="elevation-10">
                            <v-toolbar dark color="grey darken-4">
                                <v-toolbar-title class="text-h5 mx-auto">{{ conference.title }}</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <p class="text-h6">{{ conference.conference_date }}</p>
                                <div v-if="conference.latitude !== null" class="text-h5 text--primary">
                                    {{ conference.latitude }}
                                </div>
                                <div v-if="conference.longitude !== null" class="text-h5 text--primary">
                                    {{ conference.longitude }}
                                </div>
                                <GmapMap
                                    v-if="conference.latitude !== null && conference.longitude !==null"
                                    :center="{lat:parseFloat(conference.latitude), lng:parseFloat(conference.longitude)}"
                                    :zoom="7"
                                    class="google_map"
                                >
                                    <GmapMarker
                                        :position="{lat: +conference.latitude, lng: +conference.longitude}"
                                        :clickable="false"
                                        :draggable="false"
                                    />
                                </GmapMap>
                                <div class="text-h5 text--primary">
                                    {{ conference.country_id }}
                                </div>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn v-if="(role !== 'Listener') && (conference.user_id.id === user_id)" dark color="">
                                    <router-link class="nav-link" :to="{name: 'conferenceUpdate', params: {conferenceId: conference.id}}">Edit</router-link>
                                </v-btn>
                                <v-btn 
                                    v-if="(role !== 'admin') && (isJoinConf === false)" 
                                    @click="join" 
                                    dark
                                    class="ml-3"
                                >
                                    Join
                                </v-btn>
                                <v-btn 
                                    v-if="(role !== 'admin') && (isJoinConf === true)" 
                                    @click="cancelJoin" 
                                    dark
                                    class="ml-3"
                                >
                                    Cancel joining
                                </v-btn>
                                <v-btn 
                                    v-if="(role !== 'Listener') && (conference.user_id.id === user_id)" 
                                    @click="deleteConference(conference.id)" 
                                    dark 
                                    color=""
                                >
                                    Delete
                                </v-btn>
                                <a v-if="role === 'admin'" v-bind:href="'/api/export/listeners/'+this.conference.id" type="button" download="listeners.csv">
                                    <v-btn class="ml-3" color="primary" @click="exportListeners">Export</v-btn>
                                </a>
                                <v-spacer></v-spacer>
                                <facebook v-if="(role !== 'admin') && (isJoinConf === true)" :url="url" scale="3" class="ml-2"></facebook>
                                <twitter v-if="(role !== 'admin') && (isJoinConf === true)" :url="url" scale="3" :title="title" class="ml-2"></twitter>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    </v-app>
</template>


<script>
import { mapGetters, mapActions } from 'vuex'
import { Facebook, Twitter } from "vue-socialmedia-share";
import axios from 'axios';

export default {
    components: {
        Facebook, Twitter
    },
    data() {
        return {
            url: "http://127.0.0.1:8000/register",
            title: "Check out this Meetup with SoCal AngularJS!",
            role: null,
            user_id: null,
            isJoinConf: false,
            joinedId: null,
        }
    },
    props: {
        conference: {
            type: Object,
            required: true,
        }
    },
    mounted() {
        this.getRole()
        this.getUserID()
        if(this.user_id !== null && this.role !== 'admin') {
            this.isJoin()
        }
    },
    updated() {
        this.getRole()
        this.getUserID()
//        if(this.user_id !== null && this.role !== 'admin') {
//            this.isJoin()
//        }
    },  
    computed: mapGetters(['getCurrentUserRole', 'getCurrentUserID']),
    methods: {
        ...mapActions(['deleteConference', 'getJoin', 'getIsJoined']),
        exportListeners() {
            axios.get('/api/export/listeners/'+this.conference.id)
        },
        getRole() {
            this.role = this.getCurrentUserRole
        },
        getUserID() {
            this.user_id = this.getCurrentUserID
        },
        join() {
            axios.post('/api/conference/join/'+this.conference.id, {
                conference_id: this.conference.id,
                user_id: this.user_id
            }).then(response => {
                this.isJoinConf = true
            })
        },
        isJoin() {
            axios.get('/api/conference/join/'+this.conference.id, {
                conference_id: this.conference_id,
                user_id: this.user_id
            }).then(response => {
                console.log(response)
                if(response.data.length >= 1) {
                    this.isJoinConf = true
                    this.joinedId = response.data[0].id
                } else {
                    this.isJoinConf = false
                }
                
            })
          
   //         this.getJoin({conference_id: this.conference.id, user_id: this.user_id})
   //         this.isJoinConf = this.getIsJoined
   //         console.log(this.getIsJoined)
        },
        cancelJoin() {
            axios.delete('/api/conference/join/'+this.joinedId).then(response => {
                this.isJoinConf = false
            })
        },
    },
}
</script>

<style>
.google_map{
    height: 360px;
}
</style>