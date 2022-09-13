<template>
    <v-app>
        <RegisterForm
            :countries="getCountries"
        >
        </RegisterForm>
    </v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import RegisterForm from '../../components/auth/RegisterForm.vue';

export default {
    methods: {
        ...mapActions(['fetchCountries'])
    },
    computed: mapGetters(['getCountries']),
    created() {
        this.fetchCountries();
    },
    components: { RegisterForm }
}
</script>