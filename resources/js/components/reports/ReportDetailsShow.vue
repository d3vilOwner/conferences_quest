<template>
    <v-app>
        <v-main>
            <v-container fluid fill-height>
                <v-layout justify-center>
                    <v-flex xs12 sm8>
                        <v-card class="mb-1">
                            <v-toolbar dark color="grey darken-4">
                                <v-toolbar-title class="text-h5 mx-auto">{{ report.topic }}</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <p class="text-h6">
                                    Start: {{ report.conference_id.conference_date }} {{ report.report_start }} | End:
                                    {{ report.conference_id.conference_date }} {{ report.report_end }}
                                </p>
                                <div v-if="report.description !== null" class="text-h5 text--primary">
                                    {{ report.description }}
                                </div>
                                <div>
                                    <v-text-field v-if="report.presentation !== 'null'" class="mt-5"
                                        value="Presentation" label="Download presentation" @click="download" readonly>
                                    </v-text-field>
                                </div>

                            </v-card-text>
                            <v-card-actions>
                                <v-btn v-if="((this.role === 'Announcer') && (this.report.user_id.id === this.user_id)) || this.role === 'admin'"
                                    dark color="">
                                    <router-link class="nav-link"
                                        :to="{ name: 'updateReport', params: { reportId: this.report.id } }">Edit
                                    </router-link>
                                </v-btn>
                                <v-btn v-if="(this.role === 'Announcer') && (this.report.user_id.id === this.user_id)"
                                    dark class="ml-3" @click="this.cancelJoining">
                                    Cancel joining
                                </v-btn>
                                <a v-if="role === 'admin'" v-bind:href="'/api/export/comments/'+report.id" type="button" download="comments.csv">
                                    <v-btn class="ml-3" color="primary" @click="exportComments">Export</v-btn>
                                </a>
                            </v-card-actions>
                        </v-card>
                        <div>
                            <h1 class="mt-5 mb-6">Write your comment</h1>
                            <VueEditor 
                                useCustomImageHandler
                                @image-added="handleImageAdded"
                                v-model="comment"
                            >
                            </VueEditor>
                        </div>
                        <div class="">
                            <v-btn 
                                dark 
                                class="mt-3"
                                @click="postComment"
                            >
                                Post comment
                            </v-btn>      
                        </div>
                        <h1 class="mt-5 mb-5">Comments</h1>
                        <Comments
                             v-for="comment in comments"
                            :comment="comment"
                            :key="comment.id"
                        >
                        </Comments>
                        <div ref="observer" class="observer"></div>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import axios from 'axios'
import { mapActions, mapGetters } from 'vuex'
import store from '../../store'
import Comments from '../comments/Comments.vue'
import { VueEditor } from "vue2-editor";

export default {
    data() {
        return {
            comments: [],
            comment: 'Great!',
        }
    },
    components: {
        Comments,
        VueEditor
    },
    props: {
        report: {
            type: Object,
            required: true
        },
        role: {
            type: String,
            required: true
        },
        user_id: {
            type: Number,
            required: true
        },
    },
    computed: mapGetters(['getComments', 'getPath', 'getUser']),
    methods: {
        ...mapActions(['deleteReportAndJoining', 'fetchComments', 'storeComment', 'moveImgToStorage']),
        exportComments() {
            axios.get('/api/export/comments/'+this.report.id)
        },
        cancelJoining() {
            axios.get('/api/conference/join/' + this.report.conference_id.id, {
                conference_id: this.report.conference_id.id
            }).then(response => {
                this.deleteReportAndJoining(this.report.id)
            })
        },
        download() {
            axios.get('/api/report/presentation/download/' + this.report.id).then(response => {
                let blob = new Blob([response.data], {
                    type: 'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                })
                let link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                link.download = 'Presentation.pptx'
                link.click()
            })
        },
        postComment() {
            store.dispatch('storeComment', {
                path:this.getPath, 
                comment:this.comment, 
                user_id:this.user_id, 
                report_id:this.report.id,

                conference_title:this.report.conference_id.title,
                username:this.getUser.firstname,
                report_topic:this.report.topic,
                report_author:this.report.user_id.id,
            }).then((response) => {
                console.log(response)
                this.comments.push(response)
            })
        },
        handleImageAdded(file, Editor, cursorLocation, resetUploader) {
            this.moveImgToStorage({imgFile: file, Editor: Editor, cursorLocation: cursorLocation, resetUploader: resetUploader})
        },
    },
    mounted() {
        store.dispatch('fetchComments', this.report.id).then((response) => {
            this.comments = response.data
            console.log(response.data)
        })
        const options = {
            rootMargin: '0px',
            threshold: 1.0,
        }

        const callback = function(entries, observer) {
            console.log('Cross')
        }

        const observer = new IntersectionObserver(callback, options)
        observer.observe(this.$refs.observer)
    }
}
</script>

<style>
.observer {
    height: 30px;
    background-color: green;
}
</style>