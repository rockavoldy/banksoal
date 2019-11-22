<template>
  <v-app>
    <v-app-bar fixed app>
      <v-toolbar-title v-text="title" />
      <v-spacer />
      <v-toolbar-items v-if="$store.state.auth.loggedIn">
        <v-menu
          v-model="openProfile"
          close-on-content-click
          offset-y
          transition="slide-y-transition"
        >
          <template v-slot:activator="{ on }">
            <v-btn color="grey darken-1" text v-on="on">
              <v-icon left>mdi-account</v-icon>
              <span class="hidden-sm-and-down">{{ $store.state.auth.user.name }}</span>
            </v-btn>
          </template>
          <v-list color="primary--text">
            <v-subheader
              class="text-capitalize"
            >{{ $store.state.auth.user.username }}&nbsp;({{ $store.state.auth.user.roles }})</v-subheader>
            <v-list-item @click="logoutProcess">
              <v-list-item-title>Keluar</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </v-toolbar-items>
    </v-app-bar>
    <v-content>
      <v-container>
        <nuxt />
      </v-container>
    </v-content>
    <v-footer app>
      <v-spacer></v-spacer>
      <div class="overline font-regular text-center">
        <span class="text-center font-mono">
          Made with &hearts; in
          <b>Bandung</b> 2019
        </span>
      </div>
      <v-spacer></v-spacer>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      title: "Sistem Ujian Online",
      openProfile: false
    };
  },
  methods: {
    async logoutProcess() {
      await this.$auth.logout();
      alert("Sukses logout !");
    }
  }
};
</script>
