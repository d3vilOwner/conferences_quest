<template>
    <v-col>
            <v-card> 
                <v-card-text>
                    <v-row align="center" justify="center">
                        <v-col cols="12">
                            <v-row class="mb-1 pl-3 pr-3 pt-3">
                                <div>
                                    Start: {{this.report.conference_id.conference_date}} {{this.report.report_start}} | End: {{this.report.conference_id.conference_date}} {{this.report.report_end}} 
                                </div>
                                <v-spacer></v-spacer>

                                <v-icon v-if="isFavoriteFlag === false && this.getCurrentUserToken !== null && this.getCurrentUserRole !== 'admin'" @click="this.addToFavorite" class="favorite" color="">mdi-cards-heart</v-icon>
                                <v-icon v-if="isFavoriteFlag === true && this.getCurrentUserToken !== null && this.getCurrentUserRole !== 'admin'" @click="this.removeFromFavorite" class="favorite" color="red">mdi-cards-heart</v-icon>
                                <v-badge>
                                    <template v-slot:badge>
                                        <span v-if="meetingStatus === 'ended'">Ended</span>
                                        <span v-if="meetingStatus === 'waiting'">Waiting</span>
                                        <span v-if="meetingStatus === 'started'">Started</span>
                                    </template>
                                </v-badge>
                            </v-row>
                            <div>
                                <v-icon small>mdi-message-text</v-icon>
                                2
                            </div>

                            <p class="text-h5 text--primary mb-0">
                                <router-link class="nav-link" :to="{name: 'reportDetails', params: {reportId: this.report.id}}">{{this.report.topic}}</router-link>
                            </p>
                            <p class="text-h7 text--primary mb-0">
                                {{this.report.description}}
                            </p>    
                        </v-col>
                        <v-col class="text-right">
                            <v-btn @click="deleteCurrentReport"  dark v-if="this.getCurrentUserRole === 'admin'">Delete</v-btn>
                        </v-col>
                    </v-row>
                </v-card-text>
            </v-card>
    </v-col>
</template>

<script>
import axios from 'axios';
import { mapActions, mapGetters } from 'vuex';

export default {
    props: {
        report: {
            type: Object,
            required: true
        }
    },
    mounted() {
        console.log(this.report)
        this.isFavorite()
    },
    data() {
        return {
            isFavoriteFlag: false,
            favorite_id: null,

            statusOfMeeting: '',
        }
    },
    computed: { 
        ...mapGetters(['getCurrentUserID', 'getCurrentUserToken', 'getCurrentUserRole']),
        meetingStatus() {
            const nowDate = new Date()
            const reportEndDate = new Date(`${this.report.conference_id.conference_date}T${this.report.report_end}`)
            const reportStartDate = new Date(`${this.report.conference_id.conference_date}T${this.report.report_start}`)
            if(nowDate.getTime() >= reportEndDate.getTime()) {
                // this.statusOfMeeting = 'ended'
                return 'ended'
            } else if(nowDate.getTime() < reportStartDate.getTime()) {
                console.log(nowDate.getTime())
                console.log(reportEndDate.getTime())
                return 'waiting'
                // this.statusOfMeeting = 'waiting'
            } else {
                return 'started'
                // this.statusOfMeeting = 'started'
            }
        }
    },
    methods: {
        ...mapActions(['deleteReport']),
        addToFavorite() {
            axios.post('/api/favorite/store', {
                user_id: this.getCurrentUserID,
                report_id: this.report.id
            }).then(response => {
                this.favorite_id = response.data.data.id
                this.isFavoriteFlag = true
                
            })
        },
        removeFromFavorite() {
            axios.delete('/api/favorite/delete/'+this.favorite_id).then(response => {
                console.log(response)
                this.favorite_id = null
                this.isFavoriteFlag = false
            })
        },
        isFavorite() {
            axios.get(`/api/favorite/show/${this.report.id}/${this.getCurrentUserID}`).then(response => {
                if(response.data.length !== 0) {
                    this.isFavoriteFlag = true
                    this.favorite_id = response.data[0].id
                }
            })
        },
        deleteCurrentReport() {
            this.deleteReport({
                conference_title: this.report.conference_id.title,
                report_id: this.report.id
            })
        },
        
    }
}
</script>

<style scoped>
.favorite:hover {
    cursor:pointer;
}
</style>