<template>
  <v-layout justify-center align-center>
    <v-flex xs12 sm10>
      <v-card>
        <v-card-text>
          <v-data-table :headers="headers" :items="items" class="elevation-1">
            <template v-slot:top>
              <v-toolbar flat color="white">
                <v-toolbar-title>Mata Pelajaran</v-toolbar-title>
                <v-spacer />
                <v-dialog v-model="newItemDialog" max-width="500px">
                  <template v-slot:activator="{ on }">
                    <v-btn color="primary" dark class="mb-2" v-on="on">Tambah</v-btn>
                  </template>
                  <v-card>
                    <v-card-title>
                      <span class="headline">Tambah Mata Pelajaran</span>
                    </v-card-title>
                    <v-form @submit.prevent="addMatpel()">
                      <v-card-text>
                        <v-row>
                          <v-col cols="12">
                            <v-text-field v-model="tambah.nama" label="Nama Mata Pelajaran" />
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col cols="12">
                            <v-text-field v-model="tambah.kode" label="Kode Mata Pelajaran" />
                          </v-col>
                        </v-row>
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer />
                        <v-btn type="submit" color="primary">Tambah</v-btn>
                      </v-card-actions>
                    </v-form>
                  </v-card>
                </v-dialog>
              </v-toolbar>
            </template>
            <template v-slot:item.action="{ item }">
              <v-icon small @click="showMatpel(item)">mdi-eye</v-icon>
              <v-icon small @click="deleteMatpel(item)">mdi-delete</v-icon>
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
          text: "Kode",
          align: "left",
          sortable: true,
          value: "kode_matpel"
        },
        {
          text: "Mata Pelajaran",
          alight: "left",
          value: "name"
        },
        {
          text: "Aksi",
          align: "right",
          value: "action",
          sortable: false
        }
      ],
      items: [],
      tambah: {
        nama: null,
        kode: null
      },
      newItemDialog: false
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
    async addMatpel() {
      await this.$axios
        .post("/pelajaran", {
          name: this.tambah.nama,
          kode_matpel: this.tambah.kode
        })
        .then(result => {
          alert("Berhasil tambah Mata Pelajaran");
          this.newItemDialog = false;
          this.initialize();
        })
        .catch(err => {
          console.log(err);
        });
    },
    async deleteMatpel(item) {
      await this.$axios
        .delete("/pelajaran/" + item.kode_matpel)
        .then(result => {
          alert("Berhasil hapus Mata Pelajaran");
          this.initialize();
        })
        .catch(err => {
          console.log(err);
        });
    },
    async showMatpel(item) {
      await this.$router.push("/guru/" + item.kode_matpel);
    }
  }
};
</script>
