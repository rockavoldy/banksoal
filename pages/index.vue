<template>
  <div>
    <v-container>
      <v-card>
        <v-card-text>
          Hello World!
          <br />
          <v-btn nuxt to="login">Masuk disini</v-btn>
        </v-card-text>
      </v-card>
    </v-container>
  </div>
</template>

<script>
export default {
  middleware: "noauth"
};
</script>

<style>
</style>