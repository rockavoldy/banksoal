<template>
  <v-layout justify-center align-center>
    <v-flex xs12 sm10>
      <v-card>
        <v-card-text>
          <v-data-table :headers="headers" :items="items" class="elevation-1">
            <template v-slot:top>
              <v-toolbar flat color="white">
                <v-toolbar-title>Soal</v-toolbar-title>
                <v-spacer />
                <v-btn class="mb-2 mr-2" nuxt to="/guru/PGD/nilai" color="success">Nilai Siswa</v-btn>
                <v-dialog v-model="newItemDialog" max-width="500px">
                  <template v-slot:activator="{ on }">
                    <v-btn color="primary" dark class="mb-2" v-on="on">Tambah</v-btn>
                  </template>
                  <v-card>
                    <v-card-title>
                      <span class="headline">Tambah Soal</span>
                    </v-card-title>
                    <v-form @submit.prevent="addSoal()">
                      <v-card-text>
                        <v-row>
                          <v-col cols="12">
                            <v-textarea v-model="tambah.pertanyaan" label="Pertanyaan" />
                          </v-col>
                        </v-row>
                        <v-row>
                          <v-col cols="12">
                            <v-text-field v-model="tambah.skor" label="Skor Pertanyaan" />
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
              <v-icon small @click="lihatJawaban(item)">mdi-eye</v-icon>
              <v-icon small @click="tambahJawaban(item)">mdi-plus-circle</v-icon>
              <v-icon small @click="deleteSoal(item)">mdi-delete</v-icon>
            </template>
            <template v-slot:no-data>
              <v-btn color="primary" @click="initialize">Reload</v-btn>
            </template>
          </v-data-table>
        </v-card-text>
      </v-card>
    </v-flex>
    <v-dialog v-model="showJawabanDialog" max-width="800">
      <v-card>
        <v-card-title>Lihat Jawaban</v-card-title>
        <v-card-text>
          <v-simple-table>
            <template v-slot:default>
              <thead>
                <tr>
                  <th class="text-left">Pilihan Jawban</th>
                  <th class="text-left">Kunci</th>
                  <th class="text-right">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(pilihan, index) in pilihanJawaban" :key="pilihan.id">
                  <td>
                    <v-textarea
                      readonly
                      v-model="pilihan.pilihan"
                      :label="'Pilihan ke-'+(index+1)"
                    />
                  </td>
                  <td class="text-left">
                    <v-checkbox v-model="pilihanKunci" :value="pilihan.id"></v-checkbox>
                  </td>
                  <td class="text-right">
                    <v-icon @click="deletePilihan(pilihan.id)">mdi-delete</v-icon>
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn type="button" @click="saveKunci()" color="primary">Simpan</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="addJawabanDialog" max-width="800">
      <v-card>
        <v-card-title>
          Tambah Pilihan Jawaban
          <v-spacer />
          <v-icon @click="tambahPilihan.push({pilihan: null, kunci: false })">mdi-plus-circle</v-icon>
        </v-card-title>
        <v-form @submit.prevent="addChoices()">
          <v-card-text>
            <v-row v-for="(pilihan, index) in tambahPilihan" :key="pilihan.id">
              <v-col cols="12">
                <v-textarea outlined v-model="pilihan.pilihan" :label="'Pilihan ke-'+(index+1)" />
              </v-col>
            </v-row>
          </v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn type="submit" color="primary">Simpan</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
export default {
  middleware: "guru",
  data() {
    return {
      headers: [
        {
          text: "Pertanyaan",
          align: "left",
          sortable: true,
          value: "pertanyaan"
        },
        {
          text: "Skor",
          alight: "left",
          value: "skor"
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
        pertanyaan: null,
        skor: null
      },
      tambahPilihan: [
        {
          pilihan: null
        }
      ],
      soal_id: null,
      pilihanKunci: null,
      pilihanJawaban: [],
      showJawabanDialog: false,
      newItemDialog: false,
      addJawabanDialog: false
    };
  },
  mounted() {
    this.initialize();
  },
  methods: {
    async initialize() {
      await this.$axios
        .get("/api/soal/pelajaran/" + this.$route.params.soal)
        .then(result => {
          console.log(result);
          this.items = result.data.data[0].soals;
        })
        .catch(err => {
          console.log(err);
        });
    },
    async clear() {
      this.initialize();
      this.tambah.pertanyaan = null;
      this.tambah.skor = null;
      this.tambahPilihan.pilihan = null;
      this.soal_id = null;
      this.pilihanKunci = null;
      this.newItemDialog = false;
      this.addJawabanDialog = false;
      this.showJawabanDialog = false;
    },
    async addSoal() {
      await this.$axios
        .post("/api/soal", {
          pertanyaan: this.tambah.pertanyaan,
          skor: this.tambah.skor,
          kode_matpel: this.$route.params.soal
        })
        .then(result => {
          alert("Berhasil tambah Mata Pelajaran");
          this.newItemDialog = false;
          this.clear();
        })
        .catch(err => {
          console.log(err);
        });
    },
    async deleteSoal(item) {
      if (confirm("Anda yakin akan menghapus soal ini?"))
        await this.$axios
          .delete("/api/soal/" + item.id)
          .then(result => {
            alert("Berhasil hapus Mata Pelajaran");
            this.clear();
          })
          .catch(err => {
            console.log(err);
            alert("Tidak bisa menghapus soal. Soal sudah diisi oleh user");
          });
    },
    async tambahJawaban(item) {
      this.soal_id = item.id;
      this.addJawabanDialog = true;
    },
    async lihatJawaban(item) {
      this.soal_id = item.id;
      await this.$axios
        .$get("/api/soal/" + this.soal_id + "/pilihan")
        .then(result => {
          console.log(result);
          this.pilihanJawaban = result.data[0].pilihans;
          this.pilihanKunci = result.data[0].kuncis.kunci_id;
        })
        .catch(err => {
          console.log(err);
        });
      this.showJawabanDialog = true;
    },
    async addChoices() {
      await this.$axios
        .post("/api/soal/" + this.soal_id + "/pilihan", {
          pilihan: this.tambahPilihan
        })
        .then(result => {
          this.clear();
          this.pilihanKunci = null;
        })
        .catch(err => {
          console.log(err.response);
        });
    },
    async saveKunci() {
      this.pilihanKunci
      ? await this.$axios
        .post("/api/soal/" + this.soal_id + "/kunci", {
          kunci_id: this.pilihanKunci
        })
        .then(result => {
          console.log(result);
          this.clear();
        })
        .catch(err => {
          console.log(err.response);
        })
      : console.error('Belum memilih salah satu pilihan  jawaban');
      this.clear();
    },
    async deletePilihan(pilihan_id) {
      if (confirm("Anda yakin akan menghapus pilihan jawaban ini?"))
        await this.$axios
          .delete("/api/soal/" + this.soal_id + "/pilihan/" + pilihan_id)
          .then(result => {
            alert("Berhasil hapus Pilihan Jawban");
            this.clear();
          })
          .catch(err => {
            console.log(err);
            alert("Tidak bisa menghapus. Sudah diisi oleh user");
          });
    }
  }
};
</script>

<style>
</style>