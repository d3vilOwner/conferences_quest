<template>
    <ProfileEditShow
        :user="user"
        :countries="this.getCountries"
    >
    </ProfileEditShow>
</template>

<script>
import ProfileEditShow from '../../components/user/ProfileEditShow.vue';
import { mapGetters, mapActions } from 'vuex';
export default {
    components: {
        ProfileEditShow
    },
    data() {
        return {
            user: null
        }
    },
    methods: {
        ...mapActions(['fetchCountries']),
        getUser() {
            axios.get('/api/user/get-auth').then(response => {
                this.user = response.data.data
            })
        }
    },
    computed: mapGetters(['getCountries']),
    mounted() {
        this.getUser()
        this.fetchCountries();
    }
}
</script>