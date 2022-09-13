<template>
    <v-container fluid>
            <v-row>
                <v-col cols="3">
                    <FilterBlock @data="getData"></FilterBlock>
                </v-col>
                <v-col cols="9"> 
                    <ConferenceShow
                        v-for="conference in filteredConferences"
                        :conference="conference"
                        :key="conference.id"
                        :joins="getJoinedConferences"
                    >
                    </ConferenceShow>
                </v-col>
            </v-row>
            
    </v-container>
</template>

<script>
import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';
import ConferenceShow from '../../components/conferences/ConferenceShow.vue';
import FilterBlock from '../../components/filter/FilterBlock.vue';

export default {
    data() {
        return {
            user_id: null,
            conferences: [],
            currentUserJoinedConferences: [],
            filter: {
                conferencesQuantity: -1,
                startDate: null,
                endDate: null,
                categories: [],
            },
        }
    },

    methods: {
        ...mapActions(['fetchConferences', 'isJoin', 'setOnNull']),
        getData(data) {
            this.filter.conferencesQuantity = data.conferencesQuantity
            this.filter.startDate = data.start
            this.filter.endDate = data.end
            this.filter.categories = data.selectedCategories
            console.log(data)
        },
    },

    computed:  {
        ...mapGetters(['getAllConferences', 'getCurrentUserID', 'getJoinedConferences']),
        filteredConferences() {
       //     return this.getAllConferences.filter(conference => conference.title === this.dima)
            return this.getAllConferences.filter((conference) => {
                if(this.filter.conferencesQuantity === -1 && this.filter.startDate === null && this.filter.endDate === null && this.filter.categories.length === 0) {
                    return conference
                } else {

                    if(this.filter.conferencesQuantity === -1 && this.filter.startDate !== null && this.filter.endDate === null && this.filter.categories.length === 0) { // only start date
                        return conference.conference_date > this.filter.startDate
                    } else if(this.filter.conferencesQuantity === -1 && this.filter.startDate === null && this.filter.endDate !== null && this.filter.categories.length === 0) { // only end date
                        return conference.conference_date < this.filter.endDate
                    } else if(this.filter.conferencesQuantity === -1 && this.filter.startDate !== null && this.filter.endDate !== null && this.filter.categories.length === 0) { // only start && end date
                        return conference.conference_date < this.filter.endDate && conference.conference_date > this.filter.startDate
                    } else if(this.filter.conferencesQuantity === -1 && this.filter.startDate === null && this.filter.endDate === null && this.filter.categories.length !== 0) { // only categories filter
                        if(conference.category_id !== null) {
                            for(var i = 0; i < this.filter.categories.length; i++) {
                                if(conference.category_id.name === this.filter.categories[i]) {
                                    return conference
                                }
                            }
                        }
                    } else if(this.filter.conferencesQuantity === -1 && this.filter.startDate !== null && this.filter.endDate === null && this.filter.categories.length !== 0) { // only categories && start date
                        if(conference.category_id !== null) {
                            for(var i = 0; i < this.filter.categories.length; i++) {
                                if((conference.category_id.name === this.filter.categories[i]) && conference.conference_date > this.filter.startDate) {
                                    return conference
                                }
                            }
                        }
                    } else if(this.filter.conferencesQuantity === -1 && this.filter.startDate === null && this.filter.endDate !== null && this.filter.categories.length !== 0) { // only categories && end date
                        if(conference.category_id !== null) {
                            for(var i = 0; i < this.filter.categories.length; i++) {
                                if((conference.category_id.name === this.filter.categories[i]) && conference.conference_date < this.filter.endDate) {
                                    return conference
                                }
                            }
                        }
                    } else if(this.filter.conferencesQuantity === -1 && this.filter.startDate !== null && this.filter.endDate !== null && this.filter.categories.length !== 0) { // only categories && end && start date
                        if(conference.category_id !== null) {
                            for(var i = 0; i < this.filter.categories.length; i++) {
                                if((conference.category_id.name === this.filter.categories[i]) && (conference.conference_date < this.filter.endDate) && (conference.conference_date > this.filter.startDate)) {
                                    return conference
                                }
                            }
                        }
                    } else if(this.filter.conferencesQuantity !== -1 && this.filter.startDate === null && this.filter.endDate === null && this.filter.categories.length === 0) { // only quantity
                        return conference.reports.length === this.filter.conferencesQuantity
                    } else if(this.filter.conferencesQuantity !== -1 && this.filter.startDate !== null && this.filter.endDate === null && this.filter.categories.length === 0) { // only quantity && start date
                        return conference.reports.length === this.filter.conferencesQuantity && conference.conference_date > this.filter.startDate
                    } else if(this.filter.conferencesQuantity !== -1 && this.filter.startDate === null && this.filter.endDate !== null && this.filter.categories.length === 0) { // only quantity && end date
                        return conference.reports.length === this.filter.conferencesQuantity && conference.conference_date < this.filter.endDate
                    } else if(this.filter.conferencesQuantity !== -1 && this.filter.startDate === null && this.filter.endDate === null && this.filter.categories.length !== 0) { // only quantity && categories 
                        if(conference.category_id !== null) {
                            for(var i = 0; i < this.filter.categories.length; i++) {
                                if(conference.category_id.name === this.filter.categories[i] && conference.reports.length === this.filter.conferencesQuantity) {
                                    return conference 
                                }
                            }
                        }
                    } else if(this.filter.conferencesQuantity !== -1 && this.filter.startDate !== null && this.filter.endDate !== null && this.filter.categories.length === 0) { // only quantity && start && end 
                        return conference.reports.length === this.filter.conferencesQuantity && conference.conference_date > this.filter.startDate && conference.conference_date < this.filter.endDate
                    } else if(this.filter.conferencesQuantity !== -1 && this.filter.startDate !== null && this.filter.endDate === null && this.filter.categories.length !== 0) { // only quantity && start && categories 
                        if(conference.category_id !== null) {
                            for(var i = 0; i < this.filter.categories.length; i++) {
                                if(conference.category_id.name === this.filter.categories[i] && conference.reports.length === this.filter.conferencesQuantity && conference.conference_date > this.filter.startDate) {
                                    return conference 
                                }
                            }
                        }
                    } else if(this.filter.conferencesQuantity !== -1 && this.filter.startDate === null && this.filter.endDate !== null && this.filter.categories.length !== 0) { // only quantity && end && categories 
                        if(conference.category_id !== null) {
                            for(var i = 0; i < this.filter.categories.length; i++) {
                                if(conference.category_id.name === this.filter.categories[i] && conference.reports.length === this.filter.conferencesQuantity && conference.conference_date < this.filter.endDate) {
                                    return conference 
                                }
                            }
                        }
                    } else if(this.filter.conferencesQuantity !== -1 && this.filter.startDate !== null && this.filter.endDate !== null && this.filter.categories.length !== 0) { // only quantity && end && categories && start 
                        if(conference.category_id !== null) {
                            for(var i = 0; i < this.filter.categories.length; i++) {
                                if(conference.category_id.name === this.filter.categories[i] && conference.reports.length === this.filter.conferencesQuantity && conference.conference_date < this.filter.endDate && conference.conference_date > this.filter.startDate) {
                                    return conference 
                                }
                            }
                        }
                    }
                }
            }) 
        }
    },
    mounted() {
        this.user_id = this.getCurrentUserID
        this.fetchConferences()
        this.conferences = this.getAllConferences
        this.isJoin({user_id: this.user_id, conferences: this.conferences})
        console.log(this.getJoinedConferences)
    },
    updated() {
        //this.isJoin({user_id: this.user_id, conferences: this.conferences})
    },
    components: { ConferenceShow, FilterBlock }
}
</script>