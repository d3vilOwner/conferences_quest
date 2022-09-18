<template>
    <v-data-table
        :headers="headers"
        :items="meetings"
        :items-per-page="15"
        class="elevation-1"
    ></v-data-table>
    <!-- <v-btn @click="get" >click</v-btn> -->
</template>

<script>
export default {
    props: {
        meetings: {
            type:Array,
            required:true
        }
    },
    data() {
        return {
            headers: [
                {
                    text: 'topic',
                    align: 'start',
                    sortable: false,
                    value: 'topic'
                },
                { text: 'uuid', value: 'uuid'},
                { text: 'id', value: 'id' },
                { text: 'host_id', value: 'host_id' },
                { text: 'topic', value: 'topic' },
                { text: 'type', value: 'type' },
                { text: 'start_time', value: 'start_time' },
                { text: 'timezone', value: 'timezone' },
                { text: 'created_at', value: 'created_at' },
                { text: 'join_url', value: 'join_url' },
            ],
        }
    },
    methods: {
        get() {
            console.log(this.meetings)
        }
    }
}
</script>