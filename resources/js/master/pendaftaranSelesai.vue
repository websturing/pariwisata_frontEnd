<template>
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
      <div class="row w-100">
        <div class="col-md-8 mx-auto">
          <div class="auto-form-wrapper">
            <center>DPMPTSP PROVINSI KEPRI</center>
            <el-divider>Konfirmasi Pendaftaran Email</el-divider>
            <el-row :gutter="20" type="flex" justify="center">
              <el-col :md="4">
                <el-image :src="url.assets+'/email.png'">
                  <div slot="placeholder" class="image-slot">
                    Loading
                    <span class="dot">...</span>
                  </div>
                </el-image>
              </el-col>
            </el-row>
            <el-row :gutter="20" type="flex" justify="center">
              <el-col :md="18" class="text-center">
                <p>Pendaftaran account anda sudah di terima, 1 step lagi untuk menyelesaikannya. silahkan konfirmasi email yang telah kami kirimkan ke email yang anda daftarkan sebelumnya</p>
                <a :href="url.web+'/login'" class="btn btn-primary btn-sm">masuk SI-JEMPOL</a>
              </el-col>
            </el-row>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import urlBase from "@/js/url";
export default {
  data() {
    return {
      url: {
        assets: urlBase.assets,
        web: urlBase.urlWeb
      }
    };
  }
};
</script>