<template>
    <v-card>
        <v-card-title>
            <span class="text-h5">Update Comment</span>
        </v-card-title>
        <v-card-text>
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <VueEditor
                            useCustomImageHandler
                            @image-added="handleImageAdded"
                            v-model="comment.content"                        
                        >
                        </VueEditor>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="cancel">
                Close
            </v-btn>
            <v-btn color="blue darken-1" text @click="save">
                Save
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
import axios from "axios";
import { VueEditor } from "vue2-editor";

export default {
    props: {
        comment: {
            type:Object,
            required:true
        }
    },
    data() {
        return {
            content: ''
        }
    },
    components: {
        VueEditor
    },
    mounted() {
    },
    methods: {
        save() {
            console.log(this.comment)
            axios.put('/api/comment/update/'+this.comment.id, {
                media_path:this.comment.media_path,
                content:this.comment.content,
                user_id:this.comment.user_id.id,
                report_id:this.comment.report_id.id
            }).then(response => {
                console.log(response)
            }).catch(error => {
                console.log(error)
            })
            this.$emit('closeModal', {})
        },
        cancel() {
            this.$emit('closeModal', {})
        },
        handleImageAdded(file, Editor, cursorLocation, resetUploader) {
            console.log(file)
        }
    }
}
</script>