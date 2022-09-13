<template>
    <ProfileShow
        :user="user"
    >
    </ProfileShow>
</template>

<script>
import axios from 'axios';
import ProfileShow from '../../components/user/ProfileShow.vue';
export default {
    components: {
        ProfileShow
    },
    data() {
        return {
            user: null
        }
    },
    methods: {
        getUser() {
            axios.get('/api/user/get-auth').then(response => {
                console.log(response)
                this.user = response.data.data
            })
        }
    },
    mounted() {
        this.getUser()
    }
}
</script>