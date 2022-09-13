<template>
    <v-app>
            <UpdateConferenceForm
                :conference="getConferenceDetails"
                :countries="getCountries"
            >
            </UpdateConferenceForm>
    </v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import UpdateConferenceForm from '../../components/conferences/UpdateConferenceForm.vue';
export default {
    props: [
        'conferenceId'
    ],
    methods: {
        ...mapActions(['fetchConferenceDetails', 'fetchCountries'])
    },
    computed: mapGetters(['getConferenceDetails', 'getCountries']),
    created() {
        this.fetchCountries()
        this.fetchConferenceDetails(this.conferenceId);
    },
    components: { UpdateConferenceForm }
}
</script>