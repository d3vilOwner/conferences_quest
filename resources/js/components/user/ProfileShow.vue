<template>
    <v-app id="inspire">
        <v-main>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md5>
                        <v-card class="elevation-10">
                            <v-toolbar dark color="grey darken-4">
                                <v-toolbar-title class="text-h5 mx-auto">PROFILE</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-row class="row">
                                    <v-col cols="4">
                                        <p class="text-h6 text--primary">
                                            Firstname: 
                                        </p>
                                    </v-col>
                                    <v-col>
                                        <p class="text-h6">
                                            {{ user.firstname }}
                                        </p>
                                    </v-col>
                                </v-row>

                                <v-row class="row">
                                    <v-col cols="4">
                                        <p class="text-h6 text--primary">
                                            Lastname: 
                                        </p>
                                    </v-col>
                                    <v-col>
                                        <p class="text-h6">
                                            {{ user.lastname }}
                                        </p>
                                    </v-col>
                                </v-row>

                                <v-row class="row">
                                    <v-col cols="4">
                                        <p class="text-h6 text--primary">
                                            Birthdate: 
                                        </p>
                                    </v-col>
                                    <v-col>
                                        <p class="text-h6">
                                            {{ user.birthdate }}
                                        </p>
                                    </v-col>
                                </v-row>

                                <v-row class="row">
                                    <v-col cols="4">
                                        <p class="text-h6 text--primary">
                                            Email: 
                                        </p>
                                    </v-col>
                                    <v-col>
                                        <p class="text-h6">
                                            {{ user.email }}
                                        </p>
                                    </v-col>
                                </v-row>

                                <v-row class="row">
                                    <v-col cols="4">
                                        <p class="text-h6 text--primary">
                                            Phone: 
                                        </p>
                                    </v-col>
                                    <v-col>
                                        <p class="text-h6">
                                            {{ user.phone }}
                                        </p>
                                    </v-col>
                                </v-row>

                                <v-row class="row">
                                    <v-col cols="4">
                                        <p class="text-h6 text--primary">
                                            Country: 
                                        </p>
                                    </v-col>
                                    <v-col>
                                        <p class="text-h6">
                                            {{ user.country_id.name }}
                                        </p>
                                    </v-col>
                                </v-row>
                                   
                                
                                
                                
                            </v-card-text>
                            <v-card-actions>
                               <v-btn 
                                    dark 
                                >
                                    <router-link 
                                        class="nav-link" 
                                        :to="{name: 'profileEdit'}"
                                    >
                                        Edit
                                    </router-link>
                                        
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import axios from 'axios';

export default { 
    props: {
        user: {
            type:Object,
            required:true
        }
    },
    methods: {

    }
}
</script>

<style scoped>
.row {
    height: 40px;
}
</style>