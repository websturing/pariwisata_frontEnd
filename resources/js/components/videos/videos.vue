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
          <div class="row">
            <div class="col-md-4">
              <el-input
                placeholder="link Youtube"
                v-model="YoutubeApi.q"
                @keypress.native.enter="getVideos()"
                @blur="getVideos()"
              ></el-input>
            </div>
          </div>
          <br />
          <div class="card" v-loading="isLoading" v-if="show">
            <div class="row">
              <div class="col-md-3">
                <img :src="video.thumbnails.high.url" class="img-fluid" />
              </div>
              <div class="col-md-9">
                <div class="card-body">
                  <h6>{{video.title}}</h6>
                  <span class="text-primary">{{moment(video.publishedAt).format("LLLL")}}</span>
                  <p>{{video.description}}</p>
                  <el-divider content-position="left">Berita Terkait</el-divider>
                  <div class="row">
                    <div class="col-md-10">
                      <el-col :span="24">
                        <el-autocomplete
                          class="wide-dropdown"
                          v-model="terkaitberita"
                          :fetch-suggestions="querySearch"
                          placeholder="Cari Berita Terkait"
                          :trigger-on-focus="false"
                          clearable
                          @select="selectedTerkait"
                        ></el-autocomplete>
                      </el-col>
                    </div>
                    <div class="col-md-2">
                      <label for>Active</label>
                      <el-tooltip :content="'modul active'" placement="top">
                        <el-switch
                          v-model="video.is_active"
                          active-color="#13ce66"
                          inactive-color="#ff4949"
                          active-value="true"
                          inactive-value="false"
                        ></el-switch>
                      </el-tooltip>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <button class="btn btn-primary" @click="Insert()">Simpan</button>
            </div>
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
    return {
      isLoading: true,
      show: false,
      YoutubeApi: {
        part: "snippet",
        key: "AIzaSyAwyJtfRbDYPtcEOOEPkZbdzw3j0IfHN1U",
        q: null,
        type: "video"
      },
      video: {
        thumbnails: {
          high: {}
        }
      },
      disabled: true,
      links: [],
      state2: "",
      beritaTerkait: {
        berita_id: 0,
        berita_terkait: "false"
      }
    };
  },
  created() {
    this.GetBerita();
  },
  computed: {
    terkaitberita: {
      get: function() {
        return this.state2;
      },
      // setter
      set: function(newValue) {
        if (newValue.length == 0) {
          this.beritaTerkait.berita_id = 0;
          this.beritaTerkait.berita_terkait = "false";
        }
        this.state2 = newValue;
      }
    }
  },
  methods: {
    moment(arg) {
      moment.locale("id");
      return moment(arg);
    },
    getVideos() {
      this.show = true;
      axios
        .get("https://www.googleapis.com/youtube/v3/search", {
          params: this.YoutubeApi
        })
        .then(
          r => (
            console.log(r.data),
            (this.isLoading = false),
            (this.video = r.data.items[0].snippet),
            this.$set(this.video, "is_active", "true"),
            this.$set(this.video, "url", this.YoutubeApi.q),
            this.$set(this.video, "berita", this.beritaTerkait)
          )
        );
    },
    querySearch(queryString, cb) {
      var links = this.links;
      var results = queryString
        ? links.filter(this.createFilter(queryString))
        : links;
      // call callback function to return suggestions
      cb(results);
    },
    createFilter(queryString) {
      return a => {
        return a.value.toLowerCase().indexOf(queryString.toLowerCase()) > -1;
      };
    },
    selectedTerkait(item) {
      this.beritaTerkait.berita_id = item.id_berita;
      this.beritaTerkait.berita_terkait = true;

      this.$set(this.video, "berita", this.beritaTerkait);
    },
    GetBerita() {
      axios
        .post(urlBase.urlWeb + "/Masterberita", {
          type: "AllBerita"
        })
        .then(r => (console.log(r.data), (this.links = r.data)));
    },
    Insert() {
      this.isLoading = true;
      axios
        .post(urlBase.urlWeb + "/MasterVideos", {
          type: "Insert",
          data: this.video
        })
        .then(
          r => (
            (this.isLoading = false),
            (window.location.href = urlBase.urlWeb + "/content/videos")
          )
        );
    }
  }
};
</script>
<style>
.wide-dropdown {
  width: 100% !important;
}
</style>
