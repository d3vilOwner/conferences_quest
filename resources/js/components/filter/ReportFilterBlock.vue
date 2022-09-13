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
                        <p>Start time: </p>
                        <v-time-picker
                            v-model="filter.startTime"
                            format="24hr"
                            width="200"
                            @change="sendData"
                        ></v-time-picker>
                    </div>
                    <div>
                        <p>End time: </p>
                        <v-time-picker
                            v-model="filter.endTime"
                            width="200"
                            format="24hr"
                            @change="sendData"
                        ></v-time-picker>
                    </div>
                    <div>
                        <p>Duration: </p>
                        <v-slider
                            :thumb-size="20"
                            hint="i"
                            max="15"
                            min="-1"
                            thumb-label
                        ></v-slider>
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
                        <a v-if="getCurrentUserRole === 'admin'" href="/api/export/reports" type="button" download="reports.csv">
                            <v-btn class="mt-3" color="primary" @click="exportReports">Export</v-btn>
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
            filter: {
                startTime: null,
                endTime: null,
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
        exportReports() {
            axios.get('/api/export/reports')
        },
        ...mapActions(['fetchCategories']),
        sendData () {
            this.$emit('data', {
                startTime: this.filter.startTime,
                endTime: this.filter.endTime,
                selectedCategories: this.filter.selectedCategories
            })
        },
        resetFilter() {
            this.$emit('data', {
                startTime: null,
                endTime: null,
                selectedCategories: []
            })
        },
    }
}
</script>