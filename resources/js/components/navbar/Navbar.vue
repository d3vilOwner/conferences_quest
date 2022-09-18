<template>
    <v-container fluid>
        <v-app-bar
            color="grey darken-4"
            absolute
            dark
            elevation="10"
        >
            <v-toolbar-title>CONFERENCES</v-toolbar-title>
            <v-spacer/>
            <v-btn class="ml-3"><router-link class="nav-link" :to="{name: 'conferencesList'}">Conferences list</router-link></v-btn>
            <v-btn v-if="role === 'admin'" class="ml-3"><router-link class="nav-link" :to="{name: 'meetingsList'}">Meetings list</router-link></v-btn>
            <v-btn v-if="token" class="ml-3"><router-link class="nav-link" :to="{name: 'reports'}">Reports</router-link></v-btn>
            <v-btn v-if="!token" class="ml-3"><router-link class="nav-link" :to="{name: 'login'}">LOGIN</router-link></v-btn>
            <v-btn v-if="!token" class="ml-3"><router-link class="nav-link" :to="{name: 'register'}">REGISTER</router-link></v-btn>
            <v-btn v-if="token && (role !== 'Listener')" class="ml-3"><router-link class="nav-link" :to="{name: 'createConference'}">Create conference</router-link></v-btn>
            <v-btn v-if="token" class="ml-3"><router-link class="nav-link" :to="{name: 'categories'}">Categories</router-link></v-btn>
            <!-- <v-icon @click="get" v-if="token && (role !== 'admin')" class="ml-3" color="">mdi-cards-heart</v-icon> -->
            
            <v-layout row align-center class="ml-3" id="search">
                <v-text-field
                    @click="openSearchResults"
                    v-model="searchQuery"
                    solo
                    placeholder="Search..."
                    append-icon="mdi-magnify"
                    color="white"
                    hide-details
                    background-color="dark"
                ></v-text-field>
            </v-layout>

            <v-badge v-if="token && (role !== 'admin')" left class="ml-5">
                <template v-slot:badge>
                    <span>2</span>
                </template>
                <v-icon
                    color="red"
                    v-if="token && (role !== 'admin')"
                >
                    mdi-cards-heart
                </v-icon>
            </v-badge>

            <v-menu
                left
                bottom
                v-if="token"
            >
                <template v-slot:activator="{ on, attrs }">
                <v-btn
                    icon
                    v-bind="attrs"
                    v-on="on"
                    class="ml-3"
                >
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>
                </template>

                <v-list>
                    <v-list-item-group>
                        <v-list-item
                        >
                            <router-link class="nav-link" :to="{name: 'profile'}">Profile</router-link>
                        </v-list-item>
                        <v-list-item
                        >
                            <v-list-item-title v-if="token" @click.prevent="LogOut">Logout</v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-menu>
        </v-app-bar>
        
        <div class="header"></div> 
        <v-container v-if="searchResults === true">
            <v-card>
                <v-row>
                    <v-col cols="8">
                        <v-card-text>
                            <p v-if="showFoundConferences === true"><strong>Conferences</strong></p>
                            <p 
                                v-if="showFoundConferences === true"
                                v-for="conference in searchedConferences"
                                class="mb-1"
                            >
                                <router-link 
                                    class="nav-link" 
                                    :to="{name: 'conferenceDetails', params: {conferenceId: conference.id}}"
                                    target="_blank"
                                >
                                    {{ conference.title }} - {{ conference.conference_date }}
                                </router-link>
                            </p>
                            <p v-if="showFoundReports === true && token"><strong>Reports</strong></p>
                            <p 
                                v-if="showFoundReports === true && token"
                                v-for="report in searchedReports"
                                class="mb-1"
                            >
                                <router-link 
                                    class="nav-link" 
                                    :to="{name: 'reportDetails', params: {reportId: report.id}}"
                                    target="_blank"
                                >
                                    {{ report.topic }} - {{ report.report_start }} : {{ report.report_end}}
                                </router-link>
                            </p>
                        </v-card-text>
                    </v-col>
                    <v-divider
                        vertical
                    ></v-divider>
                    <v-col cols="4">
                        <v-checkbox
                            v-model="showFoundConferences"
                            :label="'Conferences'"
                        ></v-checkbox>
                        <v-checkbox
                            v-if="token"
                            class="mt-0"
                            v-model="showFoundReports"
                            :label="'Reports'"
                        ></v-checkbox>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn class="mr-2" @click="closeSearchResults">Close</v-btn>
                        </v-card-actions>
                    </v-col>
                </v-row>
            </v-card>
        </v-container> 
        <router-view></router-view>
    </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
    data() {
        return {
            showFoundConferences: true,
            showFoundReports: true,
            searchResults: false,
            token: null,
            role: null,
            searchQuery: '',
            conferences: [],
            reports: [],

        //    favorites: [],
        }
    },
    computed: {
        ...mapGetters(['getCurrentUserRole', 'getFavorites', 'getCurrentUserID', 'getAllConferences', 'getReports']),
        searchedConferences() {
            const nowDate = new Date()
            let conferenceDate
            return this.conferences.filter((conference) => {
                conferenceDate = new Date(conference.conference_date)
                return conference.title.toLowerCase().includes(this.searchQuery.toLowerCase()) && nowDate.getTime() <= conferenceDate.getTime()
            })
        },
        searchedReports() {
            const nowDate = new Date()
            let reportEndDate
            return this.getReports.filter((report) => {
                reportEndDate = new Date(`${report.conference_id.conference_date}T${report.report_end}`)
                return report.topic.toLowerCase().includes(this.searchQuery.toLowerCase()) && nowDate.getTime() < reportEndDate.getTime()
            })
        }
    },
    mounted() {
        this.getToken()
        // if(this.token) {
        //     this.fetchCurrentUserFavorites(this.getCurrentUserID)
        //     this.favorites = this.getFavorites
        // }
         this.getRole()
        
    },
    updated() {
        this.getToken()
        this.getRole()
    },
    methods: {
        ...mapActions(['logout', 'fetchCurrentUserFavorites', 'fetchConferences', 'fetchReports']),
        getToken() {
            this.token = localStorage.getItem('x-xsrf-token')
        },
        LogOut() {
            this.logout()
        },
        getRole() {
            this.role = this.getCurrentUserRole
        },

        closeSearchResults() {
            this.searchResults = false
        //    console.log(this.conferences)
        //    console.log(this.reports)
        //    console.log(this.searchQuery)
        },
        openSearchResults() {
            this.searchResults = true
            this.showFoundConferences = true
            this.showFoundReports = true
            if(this.token) {
                this.fetchReports()
            }
            this.fetchConferences()
            this.conferences = this.getAllConferences
        }
    }
}
</script>

<style scoped>
.header {
    height: 100px;
}
#search {
    width: 10px;
}
.searchResults {
    background-color: aqua;
    height: 200px;
}
</style>