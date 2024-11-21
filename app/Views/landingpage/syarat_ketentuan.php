<?php $app_settings = model('AppSettings')->find(1); ?>

<style>
.header {
    min-height: 40vh;
    background-image: linear-gradient(25deg, #17153B 50%, #2E236C 90%, #433D8B 110%);
    border-radius: 0 0 0 150px;
    padding-top: 180px;
    padding-left: 50px;
    padding-right: 50px;
}

h1 {
    line-height: 130%;
}
h5 {
    line-height: 150%;
}
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="header">
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <h1 class="text-danger fw-600">Syarat dan Ketentuan</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="container">
    <div class="row">
        <div class="col-12 text-center">
            <h1>Syarat dan Ketentuan</h1>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12 offset-xl-2 col-xl-8 text-justify">
            <p>Selamat datang di SLIP Indonesia! Dengan mengakses dan menggunakan situs web SLIPIndonesia.com, Anda menyetujui untuk mematuhi dan terikat oleh syarat dan ketentuan penggunaan berikut ini. Jika Anda tidak setuju dengan syarat dan ketentuan ini, mohon untuk tidak menggunakan layanan kami.</p>

            <h4>Definisi</h3>
            <ul>
                <li>SLIP Indonesia: Sistem Layanan Informasi Pengemudi yang dikelola melalui situs web SLIPIndonesia.com.</li>
                <li>Pengguna: Setiap individu atau entitas yang mengakses dan menggunakan layanan yang disediakan oleh SLIP Indonesia.</li>
                <li>Layanan: Fasilitas dan informasi yang disediakan oleh SLIP Indonesia melalui situs web ini.</li>
            </ul>

            <h4>Penggunaan Layanan</h3>
            <ul>
                <li>Layanan SLIP Indonesia disediakan untuk memberikan informasi dan fasilitas terkait dengan layanan pengemudi. Anda setuju untuk menggunakan layanan ini hanya untuk tujuan yang sah sesuai dengan peraturan hukum yang berlaku.</li>
                <li>Anda setuju untuk tidak menggunakan layanan kami dengan cara yang dapat merusak, mengganggu, atau membatasi akses atau fungsi dari situs web atau server kami.</li>
            </ul>

            <h4>Akun Pengguna</h3>
            <ul>
                <li>Untuk mengakses beberapa layanan SLIP Indonesia, Anda mungkin diminta untuk membuat akun pengguna. Anda bertanggung jawab atas menjaga kerahasiaan informasi akun Anda, termasuk kata sandi, dan bertanggung jawab penuh atas segala aktivitas yang terjadi melalui akun Anda.</li>
                <li>SLIP Indonesia berhak menangguhkan atau menghapus akun Anda jika ditemukan pelanggaran terhadap syarat dan ketentuan ini.</li>
            </ul>

            <h4>Kewajiban Pengguna</h3>
            <ul>
                <li>Pengguna wajib memberikan informasi yang akurat dan benar saat menggunakan layanan SLIP Indonesia. Pengguna bertanggung jawab penuh atas data yang mereka sediakan.</li>
                <li>Pengguna tidak diperkenankan untuk menggunakan layanan ini untuk tujuan ilegal atau melanggar hak-hak pihak lain.</li>
            </ul>

            <h4>Kepemilikan Intelektual</h3>
            <ul>
                <li>Semua konten yang terdapat di situs web SLIP Indonesia, termasuk namun tidak terbatas pada teks, gambar, logo, dan grafik, dilindungi oleh undang-undang hak cipta dan merupakan milik SLIP Indonesia atau pihak ketiga yang memberikan lisensi kepada kami.</li>
                <li>Anda dilarang untuk menyalin, mendistribusikan, atau mengubah konten tanpa izin tertulis dari SLIP Indonesia.</li>
            </ul>

            <h4>Batasan Tanggung Jawab</h3>
            <ul>
                <li>SLIP Indonesia tidak bertanggung jawab atas kerugian atau kerusakan yang terjadi akibat penggunaan atau ketidakmampuan untuk menggunakan layanan kami.</li>
                <li>Meskipun kami berusaha untuk memberikan informasi yang akurat dan terkini, kami tidak menjamin kelengkapan, keandalan, atau kesesuaian informasi yang disediakan di situs web ini.</li>
            </ul>

            <h4>Tautan Pihak Ketiga</h3>
            <ul>
                <li>Situs web kami mungkin menyertakan tautan ke situs web pihak ketiga yang tidak dioperasikan oleh SLIP Indonesia. Kami tidak memiliki kendali atas konten atau kebijakan dari situs pihak ketiga tersebut, dan kami tidak bertanggung jawab atas segala kerugian yang mungkin timbul dari akses atau penggunaan situs-situs tersebut.</li>
            </ul>

            <h4>Perubahan Syarat dan Ketentuan</h3>
            <ul>
                <li>SLIP Indonesia berhak untuk mengubah syarat dan ketentuan ini kapan saja dengan memposting perubahan tersebut di situs web kami. Anda disarankan untuk secara berkala memeriksa halaman ini untuk melihat pembaruan.</li>
            </ul>

            <h4>Pengakhiran Layanan</h3>
            <ul>
                <li>SLIP Indonesia berhak untuk menghentikan akses Anda ke layanan kami kapan saja, tanpa pemberitahuan sebelumnya, jika Anda melanggar syarat dan ketentuan ini atau jika kami menghentikan layanan kami.</li>
            </ul>

            <h4>Hukum yang Berlaku</h3>
            <ul>
                <li>Syarat dan ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum yang berlaku di Indonesia. Setiap perselisihan yang timbul dari atau sehubungan dengan syarat dan ketentuan ini akan diselesaikan di pengadilan Indonesia.</li>
            </ul>

            <h4>Kontak Kami</h3>
            <p>Jika Anda memiliki pertanyaan mengenai syarat dan ketentuan ini, Anda dapat menghubungi kami di:</p>
            <ul>
                <li>Nomor Telepon: <?= $app_settings['no_hp']; ?></li>
                <li>Email: contact@slipindonesia.com</li>
            </ul>

            <p>Dengan menggunakan layanan SLIP Indonesia, Anda menyetujui syarat dan ketentuan ini sepenuhnya. Terima kasih telah menggunakan layanan kami!</p>
        </div>
    </div>
</section>
