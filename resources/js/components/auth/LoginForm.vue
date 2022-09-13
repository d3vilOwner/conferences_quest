<template>
    <v-app id="inspire">
        <v-main>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-alert
                            v-if="getErrorStatus === true"
                            color="red"
                            dark
                        >
                            No user with this data
                        </v-alert>
                        <v-card class="elevation-10">
                            <v-toolbar dark color="grey darken-4">
                                <v-toolbar-title>LOGIN</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-form ref="form" v-model="validation.valid" lazy-validation>
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
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-layout align-center justify-center>
                                    <v-btn
                                        dark
                                        color="grey darken-4"
                                        @click.prevent="loginIn"
                                    >
                                        Login
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
import { mapActions, mapGetters } from 'vuex'
export default {
    data: () => ({
        form: {
            email: '',
            password: '',
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
        }
    }),
    computed: mapGetters(['getErrorStatus']),
    mounted() {
        
    },
    methods: {
        ...mapActions(['login']),
        loginIn() { 
            if(this.$refs.form.validate()) {
                this.login(this.form)
            }            
        }
    }
}
</script>