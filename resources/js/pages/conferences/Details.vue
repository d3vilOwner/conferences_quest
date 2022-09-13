<template>
    <v-app>
        <ConferenceDetailsShow
            :conference="getConferenceDetails"
        >
        </ConferenceDetailsShow>
    </v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import ConferenceDetailsShow from '../../components/conferences/ConferenceDetailsShow.vue'
export default {
    props: [
        'conferenceId'
    ],
    methods: {
        ...mapActions(['fetchConferenceDetails'])
    },
    computed: mapGetters(['getConferenceDetails']),
    created() {
        this.fetchConferenceDetails(this.conferenceId);
    },
    components: { ConferenceDetailsShow }
}
</script>