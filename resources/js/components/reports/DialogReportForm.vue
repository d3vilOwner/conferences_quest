<template>
    <v-card>
        <v-card-title>
            <span class="text-h5">Report</span>
        </v-card-title>
        <v-card-text>
            <v-form ref="form" v-model="validation.valid" lazy-validation>
                <v-container>
                    <v-row>
                        <v-col cols="12">
                            <v-text-field v-model="form.topic" label="Report topic" required
                                :rules="validation.topicRules">
                            </v-text-field>
                        </v-col>

                        <v-col cols="12">
                            <v-menu ref="menuStartPicker" v-model="startPicker" :close-on-content-click="false"
                                :nudge-right="40" :return-value.sync="form.report_start" transition="scale-transition"
                                offset-y max-width="290px" min-width="290px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="form.report_start" label="Start of report" prepend-icon=""
                                        readonly v-bind="attrs" v-on="on" :rules="validation.reportStartRules">
                                    </v-text-field>
                                </template>
                                <v-time-picker 
                                    v-if="startPicker" 
                                    format="24hr" 
                                    v-model="form.report_start" 
                                    full-width
                                    @click:minute="$refs.menuStartPicker.save(form.report_start)"
                                >
                                </v-time-picker>
                            </v-menu>
                        </v-col>

                        <v-col cols="12">
                            <v-menu ref="menuEndPicker" v-model="endPicker" :close-on-content-click="false"
                                :nudge-right="40" :return-value.sync="form.report_end" transition="scale-transition"
                                offset-y max-width="290px" min-width="290px">
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field v-model="form.report_end" label="End of report" prepend-icon=""
                                        readonly v-bind="attrs" v-on="on" :rules="validation.reportEndRules">
                                    </v-text-field>
                                </template>
                                <v-time-picker v-if="endPicker" format="24hr" v-model="form.report_end" full-width
                                    @click:minute="$refs.menuEndPicker.save(form.report_end)">
                                </v-time-picker>
                            </v-menu>
                        </v-col>

                        <v-col cols="12">
                            <v-textarea v-model="form.description" autocomplete="email" label="Description">
                            </v-textarea>
                        </v-col>
                        <v-col cols="12">
                            <v-file-input 
                                prepend-icon="" 
                                accept=".ppt, .pptx"
                                label="Presentation (.ppt, .pptx)"
                                @change="onChange"
                            >
                            </v-file-input>
                        </v-col>
                        <v-row align="center" fustify="center">
                            <v-col cols="6">
                                <v-radio-group v-model="form.is_online">
                                    <v-radio
                                        :label="'Online'"
                                        :value="true"
                                    ></v-radio>
                                </v-radio-group>
                            </v-col>
                            <v-col cols="6" align="center" fustify="center" v-if="form.is_online === true">
                                <p>10 minutes before start you will recieve start-meeting link on report details page</p>
                            </v-col>
                        </v-row>
                    </v-row>
                </v-container>
            </v-form>
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
import axios from 'axios';
import { mapGetters } from 'vuex';
export default {
    props: {
        conferenceID: {
            type: Number,
            required: true
        },
        user_id: {
            type: Number,
            required: true
        },
        role: {
            type: String,
            required: true
        },
        username: {
            type: String,
            required: true
        },
        conference_title: {
            type: String,
            required: true
        },
        conference_date: {
            type:String,
            required:true
        }
    },
    data() {
        return {
            startPicker: false,
            endPicker: false,
            form: {
                topic: '',
                presentation: [],
                report_start: null,
                report_end: null,
                description: '',
                conference_id: this.conferenceID,
                user_id: this.user_id,
                
                username: this.username,
                conference_title: this.conference_title,

                is_online: false
            },
            validation: {
                validTime: null,
                valid: false,
                topicRules: [
                    v => !!v || 'Topic is required',
                    v => (v && v.length >= 2) || 'Topic must be more than 1 character',
                    v => (v && v.length <= 255) || 'Topic must be less than 255 characters'
                ],
                reportStartRules: [
                    v => !!v || 'Start time of report is required',
                    v => {
                        if (this.form.report_start !== null && this.form.report_end !== null) {
                            let firstDate = this.form.report_start;
                            let secondDate = this.form.report_end;

                            let getDate = (string) => new Date(0, 0, 0, string.split(':')[0], string.split(':')[1]);
                            let different = (getDate(secondDate) - getDate(firstDate));

                            let result = different / 60000


                            if (result > 60 || result < 1) {
                                this.validation.validTime = false
                            } else {
                                this.validation.validTime = true
                            }
                        }

                        if (this.validation.validTime === true) {
                            return true
                        } else if (this.validation.validTime === false) {
                            return 'Your report must be no more than 60 minutes'
                        } else {
                            return true
                        }
                    }
                ],
                reportEndRules: [
                    v => !!v || 'End time of report is required',
                    v => {
                        if (this.form.report_start !== null && this.form.report_end !== null) {
                            let firstDate = this.form.report_start;
                            let secondDate = this.form.report_end;

                            let getDate = (string) => new Date(0, 0, 0, string.split(':')[0], string.split(':')[1]);
                            let different = (getDate(secondDate) - getDate(firstDate));

                            let result = different / 60000

                            if (result > 60 || result < 1) {
                                this.validation.validTime = false
                            } else {
                                this.validation.validTime = true
                            }
                        }

                        if (this.validation.validTime === true) {
                            return true
                        } else if (this.validation.validTime === false) {
                            return 'Your report must be no more than 60 minutes'
                        } else {
                            return true
                        }
                    }
                ],
            }
        }
    },
    computed: {
        ...mapGetters(['getCurrentUserID']),
    },
    methods: {
        onChange(e) {
            this.form.presentation = e
        },
        save() {

            if(this.$refs.form.validate()) {
               
                

                var fd = new FormData();

                if(this.form.is_online === true) {
                    this.form.is_online = 1
                } else {
                    this.form.is_online = 0
                }

                for (var key in this.form) {
                    //    console.log(key)
                    //    console.log(this.form[key])
                    fd.append(key, this.form[key]);
                }

                for (var pair of fd.entries()) {
                    console.log(pair[0] + ' - ' + pair[1]);
                }

                if(this.form.is_online === 1) {
                    this.form.is_online = true
                } else {
                    this.form.is_online = false
                }

                axios.post('/api/report/store', fd, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    if(this.form.is_online === true) {
                        let firstDate = this.form.report_start;
                        let secondDate = this.form.report_end;
                                    
                        let getDate = (string) => new Date(0, 0,0, string.split(':')[0], string.split(':')[1]); //получение даты из строки (подставляются часы и минуты
                        let different = (getDate(secondDate) - getDate(firstDate));

                        let hours = Math.floor((different % 86400000) / 3600000);
                        let minutes = Math.round(((different % 86400000) % 3600000) / 60000);

                        let result = (hours * 60) + minutes 

                        axios.post('/api/meeting/store', {
                            topic: this.form.topic,
                            start_time: `${this.conference_date}T${this.form.report_start}:00Z`,
                            duration: result,
                            agenda: `Meeting on ${this.form.topic} report`,
                            host_video: 1,
                            participant_video: 1,
                            report_id: response.data.data.id,
                            user_id: this.user_id 
                        }).then(response => {
                            console.log(response)
                        })
                    }
                })

                

                this.$emit('closeModal', {})
            }
        },
        cancel() {
            this.$emit('closeModal', {})
        },
    }
}
</script>