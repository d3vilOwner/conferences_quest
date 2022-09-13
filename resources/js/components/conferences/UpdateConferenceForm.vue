<template>
    <v-app id="inspire">
        <v-main>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-10 mx-auto" max-width="600">
                            <v-toolbar dark color="grey darken-4">
                                <v-toolbar-title>EDIT CONFERENCE</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-form>
                                    <v-text-field name="title" v-model="conference.title" label="Title" type="text">
                                    </v-text-field>
                                    <v-menu 
                                        ref="menu"
                                        v-model="datepicker.menu" 
                                        :close-on-content-click="false"
                                        :return-value.sync="datepicker.date" 
                                        transition="scale-transition" offset-y
                                        min-width="auto"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field v-model="conference.conference_date" label="Conference date"
                                            readonly v-bind="attrs" v-on="on">
                                            </v-text-field>
                                        </template>
                                        <v-date-picker v-model="conference.conference_date" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn text color="primary" @click="datepicker.menu = false">
                                                Cancel
                                            </v-btn>
                                            <v-btn text color="primary" @click="$refs.menu.save(conference.conference_date)">
                                                OK
                                            </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                    <v-text-field step="any" v-model="conference.latitude" id="latitude" name="latitude" label="Latitude"
                                        type="number"></v-text-field>
                                    <v-text-field step="any" v-model="conference.longitude" id="longitude" name="longitude" label="Longitude"
                                        type="number"></v-text-field>
                                    <GmapMap
                                        :center="{lat:+conference.latitude, lng:+conference.longitude}"
                                        :zoom="7"
                                        class="google_map"
                                        ref="mapRef"
                                    >
                                        <GmapMarker
                                            :position="{lat: +conference.latitude, lng: +conference.longitude}"
                                            :clickable="false"
                                            :draggable="true"
                                            @dragend="mark"
                                        />
                                    </GmapMap>
                                    <v-select
                                        v-model="conference.country_id"
                                        :items="this.countries"
                                        item-text="name"
                                        item-value="id"
                                        label="Country"
                                        persistent-hint
                                        single-line
                                    ></v-select>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn @click="save" dark color="grey darken-4">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                     </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    </v-app>

   
</template>

<script>
import { mapActions } from 'vuex'

export default {
    props: {
        conference: {
            type: Object,
            required: true,
        },
        countries: {
            type: Array,
            required: true,
        }
    },
    data: () => {
        return {
            datepicker: {
                menu: false,
            },
        }
    },
    methods: {
        ...mapActions(['editConference']),
        showCountry() {
            console.log(this.conference.country_id)
        },
        save() {
            this.editConference(this.conference)
        },
        mark(event) {
            this.conference.longitude = event.latLng.lng()
            this.conference.latitude = event.latLng.lat()
        },
    }
}
</script>