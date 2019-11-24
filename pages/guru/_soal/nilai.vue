<template>
  <v-layout justify-center align-center>
    <v-flex xs12 sm10>
      <v-card>
        <v-card-text>
          <v-data-table :headers="headers" :items="siswa" :class="elevation-1">
            <template v-slot:top>
              <v-toolbar flat color="white">
                <v-toolbar-title>Soal</v-toolbar-title>
              </v-toolbar>
            </template>
            <template v-slot:no-data>
              <v-btn color="primary" @click="initialize">Reload</v-btn>
            </template>
          </v-data-table>
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  middleware: "guru",
  data() {
    return {
      headers: [
        {
          text: "Username",
          value: 'username'
        },
        {
          text: "Nama",
          value: "name"
        },
        {
          text: "Nilai",
          value: "skors.skor"
        },
        {
          text: "Tanggal",
          value: "skors.updated_at"
        }
      ],
      siswa: []
    }
  },
  mounted() {
    this.initialize();
  },
  methods: {
    async initialize() {
      await this.$axios.get('/nilai').then(result => {
        this.siswa = result.data.data;
      }).catch(err => {
        console.log(err.response);
      })
    }
  }
}
</script>

<style>

</style>