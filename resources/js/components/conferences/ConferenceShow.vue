<template>
    <v-col>
        <v-card> 
            <v-card-text>
                <v-row align="center" justify="center">
                    <v-col>
                        <div>{{ conference.conference_date }}</div>
                        <p class="text-h5 text--primary mb-0">
                            {{ conference.title }}
                        </p>
                        <v-breadcrumbs class="breadcrumbs" :items="items"></v-breadcrumbs>
                    </v-col>
                    <v-col v-if="(role !== 'admin') && (isJoinConf === true)" cols="2">
                        <facebook v-if="(role !== 'admin') && (isJoinConf === true)" :url="url" scale="3"></facebook>
                        <twitter v-if="(role !== 'admin') && (isJoinConf === true)" :url="url" scale="3" :title="title"></twitter>
                    </v-col>  
                    <v-col class="text-right">

                        <v-dialog  v-model="dialog" persistent max-width="600px">


                            <template  v-slot:activator="{ on, attrs }">
                                <v-btn 
                                    v-if="(role !== 'admin') && (isJoinConf === false)"
                                    @click="joinToConference" 
                                    class="ml-3"
                                >
                                    Join
                                </v-btn>
                            </template>
                            <DialogReportForm 
                                v-if="role === 'Announcer'" 
                                @closeModal="dialog = false"
                                :conferenceID="conference.id"

                                :conference_title="conference.title"
                                :username="getUser.firstname"

                                :user_id="this.user_id"
                                :role="this.role"

                                :conference_date="this.conference.conference_date"
                            >
                            </DialogReportForm>
                        </v-dialog>


                        <v-btn 
                            v-if="(role !== 'admin') && (isJoinConf === true)" 
                            @click="cancelJoinToConference" 
                            class="ml-3"
                        >
                            Cancel joining
                        </v-btn>
                        
                        <v-btn class="ml-3">
                            <router-link :to="{name: 'conferenceDetails', params: {conferenceId: conference.id}}">Details</router-link>
                        </v-btn>    
                        <v-btn 
                            v-if="((role !== 'Listener') && (conference.user_id.id === user_id)) || role === 'admin'" 
                            class="ml-3" 
                            @click="deleteConference(conference.id)"
                        >
                            Delete
                        </v-btn>
                     
                    </v-col>  
                </v-row>
            </v-card-text>
        </v-card>
    </v-col>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import { Facebook, Twitter } from "vue-socialmedia-share";
import DialogReportForm from '../reports/DialogReportForm.vue';
import router from '../../router/router';

export default {
    components: {
        Facebook, 
        Twitter,
        DialogReportForm
    },
    data() {
        return {
            items: [],
            // items: [
            //     {
            //         text: 'conferences-list',
            //         disabled: true,
            //         href: '#',
            //     },
            //     {
            //         text: this.conference.category_id.name,
            //         disabled: false,
            //         href: 'breadcrumbs_link_1',
            //     },
            //     {
            //         text: this.conference.title,
            //         disabled: false,
            //         href: '/details/'+this.conference.id
            //     },
            // ],
            url: "http://127.0.0.1:8000/register",
            title: "Check out this Meetup with SoCal AngularJS!",
            role: null,
            user_id: null,
            isJoinConf: false,
            joinedId: null,
            dialog: false,
            
        }
    },
    props: {
        conference: {
            type: Object,
            required: true,
        },
        joins: {
            type: Array,
            required: true
        }
    },
    mounted() {
        this.getRole()
        this.getUserID()
        if(this.user_id !== null && this.role !== 'admin') {
            this.isJoin()
        }
        this.breadcrumbs()


        
    },
    updated() {
        this.getRole()
        this.getUserID()
    },
    watch: {
        joins:{deep:true, handler() {
            if(this.user_id !== null && this.role !== 'admin') {
                this.isJoin()
            }
        }}
    },
    computed: mapGetters(['getCurrentUserRole', 'getCurrentUserID', 'getUser']),
    methods: {
        ...mapActions(['deleteConference', 'isJoin', 'join', 'cancelJoin']),
        getRole() {
            this.role = this.getCurrentUserRole
        },
        getUserID() {
            this.user_id = this.getCurrentUserID
        },
        joinToConference() {
            //-----------
            if(this.role === 'Announcer') {
                this.dialog = true
            }
            this.join({
                conference_id: this.conference.id,
                user_id: this.user_id,
                conference_title: this.conference.title,
                username: this.getUser.firstname
            }) 
            this.isJoinConf = true  
            //------------
        },
        cancelJoinToConference() {
      //      axios.delete('api/conference/join/'+this.joinedId).then(response => {
      //          this.isJoinConf = false
      //      })
            this.cancelJoin(this.joinedId)
            this.isJoinConf = false
        },
        isJoin() {
            this.joins.forEach((element) => {
                if(this.conference.id === element.conference_id) {
                    this.isJoinConf = true
                    this.joinedId = element.id
                }
            }) 
            console.log(this.isJoinConf)
        },

        breadcrumbs() {
            this.items.push({
                text: 'conferences-list',
                disabled: true,
                href: '#',
            })

            if(this.conference.category_id !== null) {
                this.items.push({
                    text: this.conference.category_id.name,
                    disabled: false,
                    href: '/category-details/'+this.conference.category_id.id
                })
                if(this.conference.subcategory_id !== null) { 
                    this.items.push({
                        text: this.conference.subcategory_id.name,
                        disabled: false,
                        href: '/category-details/'+this.conference.category_id.id
                    })
                }
            }

            this.items.push({
                text: this.conference.title,
                disabled: false,
                href: '/details/'+this.conference.id
            })
        }
    }
}
</script>

<style scoped>
.breadcrumbs {
    padding: 0 0 0 0;
}
</style>