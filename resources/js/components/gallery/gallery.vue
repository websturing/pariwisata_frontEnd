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
        <div class="col-md-12">3</div>
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
