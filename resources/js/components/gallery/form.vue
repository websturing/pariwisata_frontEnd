<template>
  <div class="main-panel">
    <div class="content-wrapper">
      <div class="row page-title-header">
        <div class="col-12">
          <div class="page-header">
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
              <ul class="quick-links">
                <li></li>
              </ul>
              <ul class="quick-links ml-auto">
                <li>
                  <a href="#">Settings {{id}}</a>
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
        <div
          class="col-md-12"
          v-loading="isLoading.page"
          element-loading-text="Uploading gallery ..."
        >
          <el-row :gutter="10">
            <el-col :md="6">
              <label for="GalleryImage" class="custom-file-upload" v-loading="isLoading.Gallery">
                <img
                  :src="form.gallery.imagePreview"
                  v-if="form.gallery.imagePreview"
                  class="img-previewUpload"
                />
              </label>
              <input
                type="file"
                id="GalleryImage"
                ref="file"
                accept="image/*"
                @change="ImageGallery($event)"
              />
              <el-input
                type="textarea"
                v-model="form.gallery.caption"
                placeholder="Keterangan Gambar"
              ></el-input>
            </el-col>
            <el-col :md="18">
              <el-row :gutter="10">
                <el-col :md="5">
                  <el-date-picker
                    v-model="form.gallery.date_publish"
                    type="date"
                    placeholder="Pick a day"
                  ></el-date-picker>
                </el-col>
                <el-col :md="14">
                  <el-input v-model="form.gallery.judul" placeholder="Judul Gallery"></el-input>
                </el-col>
                <el-col :md="5">
                  <el-tooltip placement="top">
                    <el-switch
                      v-model="form.gallery.is_active"
                      active-color="#13ce66"
                      inactive-color="#ff4949"
                      active-value="true"
                      inactive-value="false"
                    ></el-switch>
                  </el-tooltip>
                </el-col>
              </el-row>
              <el-row :gutter="10" style="margin-top:10px">
                <el-input
                  type="textarea"
                  placeholder="Deskripsi Gallery"
                  v-model="form.gallery.description"
                  :rows="8"
                ></el-input>
              </el-row>
            </el-col>
          </el-row>
          <el-divider></el-divider>
          <el-row :gutter="20">
            <el-col
              :md="6"
              v-for="(u,Index) in form.galleryDetail"
              :key="Index"
              style="margin-top:10px"
            >
              <label class="custom-file-upload" :id="u.Index">
                <img :src="u.imagePreview" v-if="u.imagePreview" class="img-previewUpload" />
              </label>
              <input type="file" :id="u.Index" :accept="accepts" />
              <el-row :gutter="10" type="justify">
                <el-col :md="18">
                  <el-input type="textarea" v-model="u.caption" placeholder="Keterangan gambar"></el-input>
                </el-col>
                <el-col :md="2">
                  <el-button type="danger" size="mini" @click="deleteDetailGallery(Index)">Hapus</el-button>
                </el-col>
              </el-row>
            </el-col>
            <el-col :md="6" style="margin-top:10px">
              <label class="custom-file-upload" for="addGalleryDetail" v-loading="isLoading.Detail">
                <!-- <span class="text-file-upload">Unggah Gambar</span> -->
              </label>
              <input
                type="file"
                id="addGalleryDetail"
                :accept="accepts"
                @change="ImageGalleryDetail($event)"
              />
            </el-col>
          </el-row>
          <el-divider>Gallery</el-divider>
          <el-button type="primary" @click="UploadToDatabase()">Simpan</el-button>
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
    return {
      id: null,
      isLoading: {
        Gallery: false,
        Detail: false,
        page: false
      },
      form: {
        gallery: {
          gallery_id: null,
          image: null,
          caption: null,
          created_at: null,
          updated_at: null,
          description: null,
          date_publish: null,
          user_id: null,
          imagePreview: false,
          is_active: false
        },
        galleryDetail: []
      },
      accepts: ["image"].join(",")
    };
  },
  methods: {
    ImageGallery(event) {
      var reader = new FileReader();
      this.isLoading.Gallery = true;

      const file = event.target.files[0];
      this.form.gallery.imagePreview = URL.createObjectURL(file);
      this.isLoading.Gallery = false;

      reader.onload = e => {
        this.form.gallery.image = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    ImageGalleryDetail(event) {
      var reader = new FileReader();

      const file = event.target.files[0];
      var PreviewImage = URL.createObjectURL(file);
      var image = null;
      this.isLoading.Detail = true;
      reader.onload = e => {
        image = e.target.result;
        this.form.galleryDetail.push({
          gallery_detail_id: null,
          gallery_id: null,
          image: image,
          caption: null,
          created_at: null,
          updated_at: null,
          user_id: null,
          imagePreview: PreviewImage
        });
        this.isLoading.Detail = false;
      };
      reader.readAsDataURL(file);
    },
    deleteDetailGallery(i) {
      this.$delete(this.form.galleryDetail, i);
    },
    GalleryDetail(id) {
      axios
        .post(urlBase.urlWeb + "/MasterGalleryDetail", {
          type: "insertData",
          GalleryDetail: this.form.galleryDetail,
          id: id
        })
        .then(r => (this.isLoading.page = false));
    },
    UploadToDatabase() {
      let id = null;
      this.isLoading.page = true;
      axios
        .post(urlBase.urlWeb + "/MasterGallery", {
          type: "insertData",
          gallery: this.form.gallery
        })
        .then(
          r => ((id = r.data), console.log(r.data), this.GalleryDetail(id))
        );
    }
  }
};
</script>

<style>
.itemDS {
  top: -30px !important;
  width: 100% !important;
}
.itemWarp {
  margin-top: -40px !important;
  font-size: 9px !important;
}

input[type="file"] {
  display: none;
}
.custom-file-upload {
  display: table;
  border: 2px dashed #ccc;
  border-radius: 5px;
  padding: 5px;
  cursor: pointer;
  width: 100%;
  text-align: center;
  vertical-align: middle;
  height: 220px;
}

.text-file-upload {
  display: table-cell;
  vertical-align: middle;
  padding: 10px;
  margin: auto;
}

.custom-file-upload-error {
  border: 3px dashed red;
}
.custom-file-upload-success {
  border: 3px dashed green;
}
</style>
