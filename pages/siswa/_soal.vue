<template>
  <v-layout justify-center align-center>
    <v-flex xs12 sm10 md8>
      <v-card v-if="soalSaatIni">
        <v-card-title>Pertanyaan ke {{soalke + 1}}</v-card-title>
        <v-card-text>
          <v-card color="grey lighten-5" class="mb-4">
            <v-card-text>
              <p>{{ soalSaatIni.pertanyaan }}</p>
            </v-card-text>
          </v-card>
          <h4 class="ml-1">Pilihan Jawaban</h4>
          <v-item-group v-model="jawaban">
            <div class="mt-2" v-for="(item, index) in soalSaatIni.pilihans" :key="index">
              <v-item v-slot:default="{ active, toggle }" :value="item.id">
                <v-card
                  :color="active ? 'blue darken-1' : 'grey lighten-3'"
                  :dark="active"
                  @click="toggle"
                >
                  <v-card-text>{{ item.pilihan }}</v-card-text>
                </v-card>
              </v-item>
            </div>
          </v-item-group>
        </v-card-text>
        <v-card-actions class="px-4 py-3">
          <v-spacer />
          <v-btn color="primary" @click="simpan()">
            Simpan
            <v-icon right>mdi-chevron-right</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>

      <v-card v-else>
        <v-card-title>Terima kasih !</v-card-title>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  middleware: "siswa",
  data() {
    return {
      soal: [],
      soalSaatIni: {},
      soalke: 0,
      jawaban: null
    };
  },
  mounted() {
    this.initialize();
  },
  methods: {
    async initialize() {
      await this.$axios
        .get("/api/siswa/soal/" + this.$route.params.soal)
        .then(result => {
          this.soal = result.data.data;
          console.log(this.soal);
          this.mulai();
        })
        .catch(err => {});
    },
    async mulai() {
      if (confirm("Anda siap?")) this.soalSaatIni = this.soal[this.soalke];
      console.log(this.soalSaatIni);
    },
    async simpan() {
      await this.$axios
        .post("/api/siswa/soal/" + this.soalSaatIni.id, {
          pilihan_id: this.jawaban
        })
        .then(result => {
          console.log("done");
          console.log(this.jawaban);
          this.nextSoal();
        })
        .catch(err => {
          console.log(err);
        });
    },
    nextSoal() {
      this.soalke++;
      this.soalSaatIni = this.soal[this.soalke];
      alert("Soal selanjutnya !");
    }
  }
};
</script>

<style>
</style>