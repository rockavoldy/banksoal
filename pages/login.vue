<template>
  <v-layout column justify-center align-center>
    <v-flex xs12 sm8 md6>
      <v-card>
        <v-card-title>Silahkan Masuk</v-card-title>
        <v-card-text>
          <v-form @submit.prevent="loginProcess()">
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="auth.username"
                  label="Username"
                  required
                  autocomplete="false"
                  autofocus
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field v-model="auth.password" type="password" label="Password" required></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-btn color="primary" type="submit">Masuk</v-btn>
              </v-col>
            </v-row>
          </v-form>
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  middleware: "noauth",
  data() {
    return {
      auth: {
        username: null,
        password: null
      }
    };
  },
  methods: {
    loginProcess() {
      this.$auth.loginWith("local", {
        data: {
          username: this.auth.username,
          password: this.auth.password
        }
      });
    }
  }
};
</script>
