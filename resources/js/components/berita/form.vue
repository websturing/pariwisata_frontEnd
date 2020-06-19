<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row page-title-header">
        <div class="col-12">
          <div class="page-header">
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
              <ul class="quick-links">
                <li>
                  <!-- <a href="#">{{perusahaan.fullname}}</a> -->
                </li>
              </ul>
              <ul class="quick-links ml-auto">
                <li>
                  <a href="#">Settings</a>
                </li>
                <li>
                  <a href="#">Analytics</a>
                </li>
                <li>
                  <a href="#">Watchlist</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <el-form :model="form" ref="berita_form" label-position="top">
                <div class="row">
                  <div class="form-group col-md-5">
                    <el-form-item
                      label="judul"
                      prop="judul"
                      :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'blur' }"
                    >
                      <el-input
                        placeholder="Nama Modul"
                        v-model="form.judul"
                        @input="formDiasbled()"
                        clearable
                      ></el-input>
                    </el-form-item>
                  </div>
                  <div class="form-group col-md-3">
                    <el-form-item
                      prop="id_kategori"
                      label="Kategori"
                      :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'change'}"
                    >
                      <el-select
                        v-model="form.id_kategori"
                        clearable
                        placeholder="Pilih Kategori"
                        :disabled="disabled"
                        @change="GetSubKategori()"
                      >
                        <el-option
                          v-for="item in kategori"
                          :key="item.id_kategori"
                          :label="item.nama_kategori"
                          :value="item.id_kategori"
                        ></el-option>
                      </el-select>
                    </el-form-item>
                  </div>
                  <div class="form-group col-md-3">
                    <el-form-item label="Sub Kategori">
                      <el-select
                        v-model="form.id_subkategori"
                        clearable
                        placeholder="Pilih  sub Kategori"
                        :disabled="select.subKategori"
                      >
                        <el-option
                          v-for="item in subKategori"
                          :key="item.id_subkategori"
                          :label="item.nama_subkategori"
                          :value="item.id_subkategori"
                        ></el-option>
                      </el-select>
                    </el-form-item>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-3">
                    <el-form-item
                      label="Tanggal Publish"
                      prop="tgl_publish"
                      :disabled="disabled"
                      :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'change' }"
                    >
                      <el-date-picker
                        :disabled="disabled"
                        v-model="form.tgl_publish"
                        type="date"
                        value-format="dd-MM-yyyy"
                        format="dd-MM-yyyy"
                        placeholder="Pick a day"
                      ></el-date-picker>
                    </el-form-item>
                  </div>

                  <div class="col-md-3">
                    <el-form-item
                      label="#hastag"
                      label-width="100%"
                      prop="tag"
                      :rules="{ required: true, message: 'field tidak boleh kosong', trigger: 'blur' }"
                    >
                      <el-col :span="24">
                        <el-select
                          :disabled="disabled"
                          v-model="form.tag"
                          multiple
                          filterable
                          allow-create
                          default-first-option
                          placeholder="#hastag"
                        >
                          <el-option v-for="item in hastag" :key="item" :label="item" :value="item"></el-option>
                        </el-select>
                      </el-col>
                    </el-form-item>
                  </div>
                  <div class="col-md-1">
                    <el-form-item label="headline">
                      <el-switch v-model="form.headline" :disabled="disabled"></el-switch>
                    </el-form-item>
                  </div>
                  <div class="col-md-1">
                    <el-form-item label="Publish">
                      <el-switch v-model="form.publish" :disabled="disabled"></el-switch>
                    </el-form-item>
                  </div>
                </div>
              </el-form>
            </div>
          </div>
          <div class="row" style="margin-top:20px">
            <div class="col-md-5">
              <img :src="image.imagePreview" v-if="image.imagePreview" class="img-previewUpload" />
              <input
                type="file"
                id="file"
                :disabled="disabled"
                ref="file"
                accept="image/*"
                @change="handleFileUpload()"
              />
            </div>
            <div class="col-md-7">
              <el-input
                :disabled="disabled"
                type="textarea"
                :rows="8"
                placeholder="Keterangan Gambar"
                v-model="form.ket_gambar"
              ></el-input>
            </div>
          </div>
          <br />
          <div class="row">
            <div class="col-md-12">
              <froala id="edit" :tag="'textarea'" :config="config" v-model="form.isi_berita"></froala>
            </div>
          </div>
          <br />
          <div class="row">
            <button type="button" class="btn btn-primary" @click="UpdateTOdatabase()">Publish</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueFroala from "vue-froala-wysiwyg";
import urlBase from "@/js/url";
import moment from "moment";

export default {
  data() {
    var csrf_token = $('meta[name="csrf-token"]').attr("content");
    return {
      isLoading: true,
      url: {
        image: urlBase.urlWeb + "/public/20180723_10.jpeg"
      },
      config: {
        heightMin: 400,
        requestHeaders: {
          "X-CSRF-TOKEN": csrf_token
        },
        imageUploadURL: urlBase.urlWeb + "/Masterberita/imageUpload",
        events: {
          initialized: function() {
            console.log("initialized");
          },
          "image.inserted": function($img, response) {
            // Image was inserted in the editor.

            console.log("img inserted");
          },
          "image.removed": function($img, response) {
            // Do something here.
            // this is the editor instance.
            console.log($img.attributes);
          },
          "image.error": function(error, response) {
            console.log(response);
          }
        }
      },
      disabled: true,
      form: {
        id_berita: null,
        id_kategori: null,
        id_subkategori: 0,
        id_user: null,
        judul: null,
        judul_seo: null,
        judul_highlight: null,
        isi_berita: null,
        tgl_posting: null,
        tgl_publish: moment().format("DD-MM-YYYY"),
        jam: null,
        gambar: null,
        ket_gambar: null,
        dibaca: null,
        tag: [],
        headline: null,
        redaksi: null,
        aktif: null,
        publish: null,
        status: null
      },
      select: {
        kategori: false,
        subKategori: true
      },
      image: {
        showPreview: false,
        imagePreview: ""
      },
      kategori: [],
      subKategori: [],
      hastag: []
    };
  },
  created() {
    this.GetKategori();
    this.GetHastag();
    if (this.$route.query.q) {
      this.GetBeritaById(this.$route.query.q);
    }
  },
  methods: {
    moment(arg) {
      moment.locale("id");
      return moment(arg);
    },
    formDiasbled() {
      this.form.judul === "" ? (this.disabled = true) : (this.disabled = false);
    },
    notif(s, m, type) {
      this.$notify({
        title: s,
        message: m,
        type: type
      });
    },
    GetBeritaById(id) {
      let tagarray;
      axios
        .post(urlBase.urlWeb + "/Masterberita", {
          type: "GetBeritaById",
          id: id
        })
        .then(
          r => (
            console.log(r.data[0]),
            (this.form = r.data[0]),
            (tagarray = this.form.tag.split(",")),
            (this.image.showPreview = true),
            (this.form.tag = tagarray),
            (this.disabled = false),
            (this.image.imagePreview =
              urlBase.urlWeb +
              "/storage/app/artikel/" +
              this.form.folder +
              "/" +
              this.form.gambar)
          )
        );
    },
    GetKategori() {
      axios
        .post(urlBase.urlWeb + "/MasterKategori", {
          type: "GetByAktif"
        })
        .then(r => (this.kategori = r.data));
    },
    GetHastag() {
      axios
        .post(urlBase.urlWeb + "/Masterberita", {
          type: "HastagFull"
        })
        .then(r => ((this.hastag = r.data), console.log(this.hastag)));
    },
    GetSubKategori() {
      axios
        .post(urlBase.urlWeb + "/MasterSubKategori", {
          type: "GetByKategori",
          id: this.form.id_kategori
        })
        .then(
          r => (
            (this.subKategori = r.data),
            this.subKategori.length === 0
              ? (this.select.subKategori = true)
              : (this.select.subKategori = false),
            (this.form.id_subkategori = 0)
          )
        );
    },
    handleFileUpload() {
      this.form.gambar = this.$refs.file.files[0];

      /*
                  Initialize a File Reader object
                */
      let reader = new FileReader();

      /*
                  Add an event listener to the reader that when the file
                  has been loaded, we flag the show preview as true and set the
                  image to be what was read from the reader.
                */
      reader.addEventListener(
        "load",
        function() {
          this.image.showPreview = true;
          this.image.imagePreview = reader.result;
        }.bind(this),
        false
      );

      /*
                  Check to see if the file is not empty.
                */
      if (this.form.gambar) {
        /*
                      Ensure the file is an image file.
                    */
        reader.readAsDataURL(event.target.files[0]);
        reader.onload = e => {
          this.form.gambar = e.target.result;
        };
        if (/\.(jpe?g|png|gif)$/i.test(this.form.gambar.name)) {
          /*
                          Fire the readAsDataURL method which will read the file in and
                          upon completion fire a 'load' event which we will listen to and
                          display the image in the preview.
                        */
          reader.readAsDataURL(this.form.gambar);
        }
      }
    },
    imageUtamaUpload() {
      axios
        .post(urlBase.urlWeb + "/Masterberita", {
          type: "uploadImageUtama",
          form: this.form
        })
        .then(r => console.log(r.data));
    },
    UpdateTOdatabase() {
      this.$refs["berita_form"].validate(valid => {
        if (valid) {
          axios
            .post(urlBase.urlWeb + "/Masterberita", {
              type: "insert",
              form: this.form
            })
            .then(
              r =>
                this.notif(
                  "information",
                  "Data Berhasil Di Tambahkan",
                  "success"
                ),
              this.$router.push({
                name: "content-berita"
              })
            );
        } else {
          return false;
        }
      });
    }
  }
};
</script>

<style>
.img-previewUpload {
  width: 100%;
  height: 200px;
  object-fit: cover;
}
</style>
