<template>
    <v-col>
        <v-expansion-panels>
            <v-expansion-panel>
                <v-expansion-panel-header v-slot="{ open }">
                    <v-row no-gutters>
                        <v-col>
                            <strong>Filter</strong>
                        </v-col>
                    </v-row>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <div>
                        <p>Quantity of reports: </p>
                        <v-slider
                            v-model="filter.conferencesQuantity"
                            :thumb-size="20"
                            hint="i"
                            max="15"
                            min="-1"
                            thumb-label
                            @change="sendData"
                        ></v-slider>
                    </div>

                    <div>
                        <p>From: </p>

                        <v-menu
                        ref="startMenu"
                        :close-on-content-click="false"
                        :return-value.sync="filter.start"
                        offset-y
                        min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                v-model="filter.start"
                                label="Start date"
                                prepend-icon="mdi-calendar"
                                readonly
                                v-bind="attrs"
                                v-on="on"
                                ></v-text-field>
                            </template>
                            <v-date-picker
                                v-model="filter.dateFrom"
                                no-title
                                scrollable
                            >
                                <v-spacer></v-spacer>
                                <v-btn
                                text
                                color="primary"
                                @click="$refs.startMenu.isActive = false"
                                >
                                    Cancel
                                </v-btn>
                                <v-btn
                                text
                                color="primary"
                                @click="saveFromDate"
                                >
                                    OK
                                </v-btn>
                            </v-date-picker>
                        </v-menu>
                    </div>
                    <div>
                        <p>To: </p>

                        <v-menu
                        ref="endMenu"
                        :close-on-content-click="false"
                        :return-value.sync="filter.end"
                        offset-y
                        min-width="290px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                                <v-text-field
                                    v-model="filter.end"
                                    label="Start date"
                                    prepend-icon="mdi-calendar"
                                    readonly
                                    v-bind="attrs"
                                    v-on="on"
                                >
                                </v-text-field>
                            </template>
                            <v-date-picker
                                v-model="filter.dateTo"
                                no-title
                                scrollable
                            >
                                <v-spacer></v-spacer>
                                <v-btn
                                    text
                                    color="primary"
                                    @click="$refs.startMenu.isActive = false"
                                >
                                    Cancel
                                </v-btn>
                                <v-btn
                                    text
                                    color="primary"
                                    @click="saveToDate"
                                >
                                    OK
                                </v-btn>
                            </v-date-picker>
                        </v-menu>
                    </div>
                    <v-combobox
                        v-model="filter.selectedCategories"
                        :items="this.regroupArray"
                        label="I use chips"
                        multiple
                        chips
                        @change="sendData"
                    ></v-combobox>
                    <div>
                        <v-btn dark @click="resetFilter">Reset filters</v-btn>
                        <a v-if="getCurrentUserRole === 'admin'" href="/api/export/conferences" type="button" download="conferences.csv">
                            <v-btn class="mt-3" color="primary" @click="exportConferences">Export</v-btn>
                        </a>
                    </div>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
    </v-col>
</template>

<script>
import axios from 'axios'
import { mapActions, mapGetters } from 'vuex'

export default {
    data() {
        return {
            trip: {
                name: '',
                location: null,
                
            },
            filter: {
                conferencesQuantity: -1,

                start: null,
                end: null,
                dateFrom: null,
                dateTo: null,

                itemsCategories: [],
                selectedCategories: [],
            }
        }
    },
    mounted() {
        this.fetchCategories()
    },
    computed: {
       ...mapGetters(['getCategories', 'getCurrentUserRole']),
        regroupArray() {
            return this.getCategories.map(function(el) {
                return el.name
            })
        },
    },
    methods: {
        ...mapActions(['fetchCategories']),
        sendData () {
            this.$emit('data', {
                conferencesQuantity: this.filter.conferencesQuantity,
                start: this.filter.dateFrom,
                end: this.filter.dateTo,
                selectedCategories: this.filter.selectedCategories
            })
        },
        resetFilter() {
            this.$emit('data', {
                conferencesQuantity: -1,
                start: null,
                end: null,
                selectedCategories: []
            })
        },
      
        saveFromDate() {
            this.$refs.startMenu.save(this.filter.dateFrom)
        //    console.log(this.date)
            this.sendData()
        },
        saveToDate() {
            this.$refs.endMenu.save(this.filter.dateTo)
            this.sendData()
        },
        handleChange(event) {
            this.$emit("customChange", event.target.value)
        },
        exportConferences() {
            axios.get('/api/export/conferences')
        }
    }
}
</script>