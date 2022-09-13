<template>
<div>
    <v-divider></v-divider>
    <p class="font-weight-thin">
        {{comment.user_id.firsname}}
        {{comment.user_id.lastname}} 
        -
        {{comment.created_at}}
    </p>
    <div>
        <span v-html="comment.content"></span>
    </div>
    <v-img
        v-if="comment.media_path !== null"
        max-height="150"
        max-width="250"
        :src="'/storage/'+comment.media_path"
    ></v-img>  
    <v-dialog v-model="dialog" persistent max-width="1000px">
        <template v-slot:activator="{ on, attrs }">
            <v-btn 
                @click="dialog = true" 
                class="mt-3 mb-3"
                dark
                small
            >
                Edit
            </v-btn>
        </template>
        <UpdateComment 
            @closeModal="dialog = false"
            :comment="comment"
        >
        </UpdateComment>
    </v-dialog>
</div>        


</template>

<script>
import axios from "axios";
import { mapActions, mapGetters } from 'vuex'
import UpdateComment from './UpdateComment.vue'

export default {
    props: {
        comment: {
            type: Object,
            required:true
        }
    },
    components: {
        UpdateComment,
        UpdateComment
    },
    data() {
        return {
            dialog: false,
        }
    },
    methods: {
        editComment() {
           this.dialog = true
        },
    },

}
</script>