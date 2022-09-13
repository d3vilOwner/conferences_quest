<template>
    <v-app id="inspire">
        <v-main>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-10">
                            <v-toolbar dark color="grey darken-4">
                                <v-toolbar-title>CREATE CONFERENCE</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-form ref="form" v-model="validation.valid" lazy-validation>
                                    <v-text-field 
                                        v-model="form.title" 
                                        :rules="validation.titleRules" 
                                        label="Title" 
                                        type="text"
                                        required
                                    ></v-text-field>
                                    <v-text-field 
                                        v-model="form.latitude" 
                                        :rules="validation.coordinateRules" 
                                        label="Latitude" 
                                        type="number"
                                    ></v-text-field>
                                    <v-text-field 
                                        v-model="form.longitude" 
                                        :rules="validation.coordinateRules" 
                                        label="Longitude" 
                                        type="number"
                                    ></v-text-field>
                                    <GmapMap
                                        :center="{lat:+form.latitude, lng:+form.longitude}"
                                        :zoom="7"
                                        class="google_map"
                                    >
                                        <GmapMarker
                                            :position="{lat: +form.latitude, lng: +form.longitude}"
                                            :clickable="false"
                                            :draggable="true"
                                            @dragend="mark"
                                        />
                                    </GmapMap>
                                    <!------------ Datepicker ------------>
                                    <v-menu
                                        ref="menu"
                                        v-model="menu"
                                        :close-on-content-click="false"
                                        :return-value.sync="form.conference_date"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="form.conference_date"
                                                label="Conference date"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="form.conference_date"
                                            no-title
                                            scrollable
                                        >
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="menu = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="$refs.menu.save(form.conference_date)"
                                        >
                                            OK
                                        </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                    <!------------------------------------>
                                    <v-select
                                        v-model="form.country_id"
                                        :items="this.countries"
                                        item-text="name"
                                        item-value="id"
                                        :rules="validation.countryRules"
                                        label="Country"
                                    ></v-select>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-layout align-center justify-center>
                                    <v-btn
                                        dark
                                        color="grey darken-4"
                                        @click.prevent="create"
                                    >
                                        Create
                                    </v-btn>
                                    
                                    
                                </v-layout>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
 //   userID: this.getCurrentUserID,
    props: {
        countries: {
            type: Array,
            required: true,
        },
        userID: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            menu: false,
            form: {
                title: '',
                latitude: 50.4536,
                longitude: 30.5164,
                country_id: '',
                conference_date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
                user_id: this.userID, 
            },
            validation: {
                valid: false,
                titleRules: [
                    v => !!v || 'Title is required',
                    v => (v && v.length >= 2) || 'Title must be more than 1 characters',
                    v => (v && v.length <= 255) || 'Titlle must be less than 255 characters'
                ],
            }
        }   
    },
    methods: {
        ...mapActions(['addConference']),
        create() {
            if(this.$refs.form.validate()) {
                this.addConference(this.form)
            }
        },
        mark(event) {
            this.form.latitude = event.latLng.lat()
            this.form.longitude = event.latLng.lng()
        },
        getUserIDID() {
            console.log(this.form.user_id)
        }
    }
}
</script>