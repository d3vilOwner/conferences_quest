<template>
    <v-container fluid>
        <MeetingShow
            :meetings="this.get_meetings"
        >
        </MeetingShow>
    </v-container>
</template>

<script>
import MeetingShow from '../../components/meetings/MeetingShow.vue'
import { mapActions, mapGetters } from 'vuex'
export default {
    components: {
        MeetingShow
    },
    data() {
        return {
           
        }
    },
    computed: {
        ...mapGetters(['get_meetings'])
    },
    methods: {
        ...mapActions(['getAllMeetings']),
    },
    mounted() {
        this.getAllMeetings()
    }
}
</script>