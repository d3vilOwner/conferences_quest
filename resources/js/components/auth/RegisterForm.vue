<template>
    <v-app id="inspire">
        <v-main>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-10">
                            <v-toolbar dark color="grey darken-4">
                                <v-toolbar-title>REGISTER</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-form ref="form" v-model="validation.valid" lazy-validation>
                                    <v-text-field 
                                        v-model="form.firstname" 
                                        :rules="validation.nameRules" 
                                        label="Firstname" 
                                        type="text"
                                        required
                                    ></v-text-field>
                                    <v-text-field 
                                        v-model="form.lastname" 
                                        :rules="validation.nameRules" 
                                        label="Lastname" 
                                        type="text"
                                        required
                                    ></v-text-field>
                                    <v-select
                                        v-model="form.role"
                                        :items="selects.selectRolesItems"
                                        :rules="validation.roleRules"
                                        label="Role"
                                        required
                                    ></v-select>
                                    <v-select
                                        v-model="form.country_id"
                                        :items="this.countries"
                                        item-text="name"
                                        item-value="id"
                                        :rules="validation.countryRules"
                                        label="Country"
                                        required
                                    ></v-select>
                                    <!------------ Datepicker ------------>
                                    <v-menu
                                        ref="menu"
                                        v-model="menu"
                                        :close-on-content-click="false"
                                        :return-value.sync="form.birthdate"
                                    >
                                        <template v-slot:activator="{ on, attrs }">
                                            <v-text-field
                                                v-model="form.birthdate"
                                                label="Birthdate"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="form.birthdate"
                                            no-title
                                            scrollable
                                        >
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="menu = false"
                                        >
                                            Cancel
                                        </v-btn>
                                        <v-btn
                                            text
                                            color="primary"
                                            @click="$refs.menu.save(form.birthdate)"
                                        >
                                            OK
                                        </v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                    <!------------------------------------>
                                    <v-text-field
                                        v-model="form.phone" 
                                        :rules="validation.phoneRules" 
                                        label="Phone" 
                                        type="text"
                                        required
                                    ></v-text-field>
                                    <v-text-field 
                                        v-model="form.email" 
                                        :rules="validation.emailRules" 
                                        label="Email" 
                                        type="email"
                                        required
                                    ></v-text-field>
                                    <v-text-field 
                                        v-model="form.password" 
                                        :rules="validation.passwordRules" 
                                        label="Password" 
                                        type="password"
                                        required
                                    ></v-text-field>
                                    <v-text-field 
                                        v-model="form.password_confirmation" 
                                        :rules="validation.passwordRules" 
                                        label="Confirm password" 
                                        type="password"
                                        required
                                    ></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-layout align-center justify-center>
                                    <v-btn
                                        dark
                                        color="grey darken-4"
                                        @click.prevent="registerIn"
                                    >
                                        Register
                                    </v-btn>
                                </v-layout>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import axios from 'axios'
import { mapActions, mapGetters } from 'vuex'

export default {
    props: {
        countries: {
            type: Array,
            required: true,
        }
    },
    data: () => ({
        menu: false,
        selects: {
            selectRolesItems: [
                'Announcer',
                'Listener'
            ],
        },
        form: {
            firstname: '',
            lastname: '',
            role: '',
            country_id: '',
            birthdate: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
            email: '',
            password: '',
            password_confirmation: ''
        },
        validation: {
            valid: false,
            passwordRules: [
                v => !!v || 'Password is required',
            ],
            emailRules: [
                v => !!v || 'E-mail is required',
                v => /.+@.+/.test(v) || 'E-mail must be valid',
            ],
            nameRules: [
                v => !!v || 'Name is required',
                v => (v && v.length >= 2) || 'Name must be more than 1 characters'
            ],
            roleRules: [
                v => !!v || 'Role is required',
            ],
            countryRules: [
                v => !!v || 'Country is required',
            ],
            phoneRules: [
                v => !!v || 'Phone is required',
            ],
        }
    }),
    computed: mapGetters(['getErrorStatus']),
    methods: {
        ...mapActions(['register']),
        registerIn() { 
            if(this.$refs.form.validate()) {
                this.register(this.form)
            }            
        }
    },
}
</script>