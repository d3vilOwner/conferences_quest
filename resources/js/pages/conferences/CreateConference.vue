<template>
    <v-app>
            <CreateConferenceForm
                :countries="getCountries"
                :userID="getCurrentUserID"
            >
            </CreateConferenceForm>
    </v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import CreateConferenceForm from '../../components/conferences/CreateConferenceForm.vue';

export default {
    methods: {
        ...mapActions(['fetchCountries'])
    },
    computed: mapGetters(['getCountries', 'getCurrentUserID']),
    created() {
        this.fetchCountries();
    },
    components: { CreateConferenceForm }
}
</script>