<template>
  <v-layout justify-center align-center>
    <v-flex xs12 sm10 md8>
      <v-card>
        <v-card-text>
          <v-data-table :headers="headers" :items="items" class="elevation-1" @click:row="clickRow">
            <template v-slot:top>
              <v-toolbar flat color="white">
                <v-toolbar-title>Pilih Mata Pelajaran</v-toolbar-title>
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
  middleware: "siswa",
  data() {
    return {
      headers: [
        {
          text: "Kode",
          align: "left",
          sortable: true,
          value: "kode_matpel"
        },
        {
          text: "Mata Pelajaran",
          alight: "left",
          value: "name"
        }
      ],
      items: []
    };
  },
  mounted() {
    this.initialize();
  },
  methods: {
    async initialize() {
      await this.$axios
        .get("/pelajaran")
        .then(result => {
          this.items = result.data.data;
        })
        .catch(err => {
          console.log(err);
        });
    },
    async clickRow(value) {
      this.$router.push("/siswa/" + value.id);
    }
  }
};
</script>
