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
          <el-select
            v-model="sort.type"
            placeholder="Sortir Berita Berdasarkan.."
            @change="SortType()"
          >
            <el-option
              v-for="item in options"
              :key="item.value"
              :label="item.label"
              :value="item.value"
            ></el-option>
          </el-select>
          <span class="byDate" v-if="show.tanggal">
            <el-date-picker
              v-model="today"
              @change="GetBeritaByDate(today)"
              type="date"
              value-format="dd-MM-yyyy"
              format="dd-MM-yyyy"
              placeholder="Pick a day"
            ></el-date-picker>
          </span>

          <span class="byRange" v-if="show.range">
            <el-date-picker
              v-model="range"
              @change="GetBeritaByDateRange(range)"
              type="daterange"
              range-separator="/"
              format="dd-MM-yyyy"
              :picker-options="pickerOptions"
              start-placeholder="Start date"
              end-placeholder="End date"
            ></el-date-picker>
          </span>
          <a href="berita/form" class="btn btn-primary">Tambah Berita</a>
          <br />
          <br />
          <div class="card">
            <el-table
              ref="table_berita"
              v-loading="table.isLoading"
              :data="table.data.filter(data => !table.search || data.judul.toLowerCase().includes(table.search.toLowerCase()))"
              style="width: 100%"
            >
              <el-table-column type="index" width="80"></el-table-column>
              <el-table-column label="judul" prop="judul"></el-table-column>
              <el-table-column label="tgl_publish" prop="tgl_publish"></el-table-column>
              <el-table-column align="right">
                <template slot="header" slot-scope="scope">
                  <el-input v-model="table.search" size="mini" placeholder="Type to search" />
                </template>
              </el-table-column>
            </el-table>
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
      today: moment().format("DD-MM-YYYY"),
      range: null,
      table: {
        data: [],
        search: "",
        isLoading: false
      },
      show: {
        tanggal: false,
        range: false
      },
      sort: {
        type: null,
        data: null
      },
      options: [
        {
          value: "all",
          label: "Semua Data"
        },
        {
          value: "range",
          label: "Range Tanggal"
        },
        {
          value: "Tanggal",
          label: "Tanggal"
        }
      ],
      pickerOptions: {
        shortcuts: [
          {
            text: "Minggu Lalu",
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
              picker.$emit("pick", [start, end]);
            }
          },
          {
            text: "Bulan Lalu",
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
              picker.$emit("pick", [start, end]);
            }
          },
          {
            text: "3 Bulan Terakhir",
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
              picker.$emit("pick", [start, end]);
            }
          }
        ]
      }
    };
  },
  mounted() {
    this.GetBeritaByDate(this.today);
  },
  created() {
    console.log("created");
    console.log(this.today);
  },
  methods: {
    moment(arg) {
      moment.locale("id");
      return moment(arg);
    },
    SortType() {
      if (this.sort.type == "Tanggal") {
        this.show.tanggal = true;
        this.show.range = false;
      }
      if (this.sort.type == "range") {
        this.show.tanggal = false;
        this.show.range = true;
      }
      if (this.sort.type == "all") {
        this.show.tanggal = false;
        this.show.range = false;

        this.GetBerita();
      }
    },
    GetBerita() {
      this.table.isLoading = true;
      axios
        .post(urlBase.urlWeb + "/Masterberita", {
          type: "AllBerita"
        })
        .then(
          r => ((this.table.data = r.data), (this.table.isLoading = false))
        );
    },
    GetBeritaByDate(date) {
      this.table.isLoading = true;
      axios
        .post(urlBase.urlWeb + "/Masterberita", {
          type: "beritaByDate",
          date: date
        })
        .then(
          r => ((this.table.data = r.data), (this.table.isLoading = false))
        );
    },
    GetBeritaByDateRange(date) {
      this.table.isLoading = true;
      axios
        .post(urlBase.urlWeb + "/Masterberita", {
          type: "beritaByDateRange",
          date: date
        })
        .then(
          r => (
            console.log(r.data),
            (this.table.data = r.data),
            (this.table.isLoading = false)
          )
        );
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
