<template>
    <v-app id="inspire">
        <v-main>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-10 mx-auto" max-width="600">
                            <v-toolbar dark color="grey darken-4">
                                <v-toolbar-title>EDIT REPORT</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-form ref="form" v-model="validation.valid" lazy-validation>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12">
                                                <v-text-field v-model="report.topic" label="Report topic" required
                                                    :rules="validation.topicRules">
                                                </v-text-field>
                                            </v-col>

                                            <v-col cols="12">
                                                <v-menu ref="menuStartPicker" v-model="startPicker" :close-on-content-click="false"
                                                    :nudge-right="40" :return-value.sync="report.report_start" transition="scale-transition"
                                                    offset-y max-width="290px" min-width="290px">
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-text-field v-model="report.report_start" label="Start of report" prepend-icon=""
                                                            readonly v-bind="attrs" v-on="on" :rules="validation.reportStartRules">
                                                        </v-text-field>
                                                    </template>
                                                    <v-time-picker v-if="startPicker" format="24hr" v-model="report.report_start" full-width @change="setTimeChanged"
                                                        @click:minute="$refs.menuStartPicker.save(report.report_start)">
                                                    </v-time-picker>
                                                </v-menu>
                                            </v-col>

                                            <v-col cols="12">
                                                <v-menu ref="menuEndPicker" v-model="endPicker" :close-on-content-click="false"
                                                    :nudge-right="40" :return-value.sync="report.report_end" transition="scale-transition"
                                                    offset-y max-width="290px" min-width="290px">
                                                    <template v-slot:activator="{ on, attrs }">
                                                        <v-text-field v-model="report.report_end" label="End of report" prepend-icon=""
                                                            readonly v-bind="attrs" v-on="on" :rules="validation.reportEndRules">
                                                        </v-text-field>
                                                    </template>
                                                    <v-time-picker v-if="endPicker" format="24hr" v-model="report.report_end" full-width @change="setTimeChanged"
                                                        @click:minute="$refs.menuEndPicker.save(report.report_end)">
                                                    </v-time-picker>
                                                </v-menu>
                                            </v-col>

                                            <v-col cols="12">
                                                <v-textarea v-model="report.description" autocomplete="email" label="Description">
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
                                        </v-row>
                                    </v-container>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="back">
                                    Back
                                </v-btn>
                                <v-btn color="blue darken-1" text @click="save">
                                    Save
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import router from '../../router/router';
export default {
    props: {
        report: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            startPicker: false,
            endPicker: false,

            timeChanged: false,

   /*         form: {
                topic: '',
                presentation: null,
                report_start: null,
                report_end: null,
                description: '',
                conference_id: this.conferenceID,
                user_id: this.user_id,
            }, */
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
                        if (this.report.report_start !== null && this.report.report_end !== null) {
                            let firstDate = this.report.report_start;
                            let secondDate = this.report.report_end;

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
                        if (this.report.report_start !== null && this.report.report_end !== null) {
                            let firstDate = this.report.report_start;
                            let secondDate = this.report.report_end;

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
    methods: {
        setTimeChanged() {
            this.timeChanged = true
        },
        onChange(e) {
            this.report.presentation = e
        },
        save() {
            if(this.$refs.form.validate()) {
                var fd = new FormData();
                for (var key in this.report) {
                    //    console.log(key)
                    //    console.log(this.form[key])
                    if(key === 'conference_id') {
                        fd.append(key, this.report[key].id)
                        fd.append('conference_title', this.report[key].title)
                    } else if(key === 'user_id') {
                        fd.append(key, this.report[key].id)
                        fd.append('username', this.report[key].firstname)
                    } else {
                        fd.append(key, this.report[key]);
                    }
                }
                fd.append('_method', 'put')
                fd.append('timeChanged', this.timeChanged)
                for (var pair of fd.entries()) {
                    console.log(pair[0] + ' - ' + pair[1]);
                }
                axios.post('/api/report/update/'+this.report.id, fd, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    console.log(response)
                }).catch(response => {
                    console.log(response)
                })
                
                this.timeChanged = false
            
              //  console.log(form.topic)

// Не получилось сделать обновление с axios пишет что хочет видеть файл , а ajax вообще не получает никаких данных и пишет об ошибке валидации required хотя тоже самое с post работает в создании репорта
// ------------------------------- AJAX ПОПЫТКА
 /*               console.log(this.report)
                var fd = new FormData();
                for (var key in this.report) {
                //        console.log(key)
                //       console.log(this.form[key])
                    fd.append(key, this.report[key]);
                }
                for (var pair of fd.entries()) {
                    console.log(pair[0] + ' - ' + pair[1]);
                }
                $.ajax({
                    url: '/api/report/update/'+this.report.id,
                    type: "PUT",
                    data: fd,
                    processData: false,  // Сообщить jQuery не передавать эти данные
                    contentType: false   // Сообщить jQuery не передавать тип контента
                }); 
*/
// ------------------------------ ПОПЫТКА С axios
     /*            axios.put('/api/report/update/'+this.report.id, {
                    topic: this.report.topic,
                    presentation: this.report.presentation,
                    report_start: this.report.report_start,
                    report_end: this.report.report_end,
                    description: this.report.description,
                    conference_id: this.report.conference_id,
                    user_id: this.report.user_id,
                 })
                        .then(response => {
                            console.log(response)
                        })
                        .catch(err => {
                 //           this.handleErrors(err.response.data.errors)
                        })
                        .then(() => {
                  //          this.loading = false
                        }) */
// --------------------------
            }
        },
        back() {
            router.push({name: 'reportDetails'})
        }
    }
}
</script>