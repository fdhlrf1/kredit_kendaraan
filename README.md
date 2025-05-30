<h1 class="code-line" data-line-start=0 data-line-end=1 ><a id="_Aplikasi_Kredit_Kendaraan_0"></a>🚗 Aplikasi Kredit Kendaraan</h1>
<p class="has-line-data" data-line-start="2" data-line-end="3"><img src="https://res.cloudinary.com/doxjwmouv/image/upload/v1748588567/ss_kredit_raur5v.png" alt="Kredit Kendaraan Screenshot"></p>
<h2 class="code-line" data-line-start=4 data-line-end=5 ><a id="_Deskripsi_Aplikasi_4"></a>📝 Deskripsi Aplikasi</h2>
<p class="has-line-data" data-line-start="6" data-line-end="7">Aplikasi Kredit Kendaraan adalah sistem manajemen kredit kendaraan berbasis web yang memudahkan pencatatan pengajuan kredit, pembayaran angsuran, pengelolaan data pelanggan, serta pembuatan laporan keuangan kredit kendaraan. Aplikasi ini dibangun menggunakan PHP Native dan MySQL, dengan antarmuka yang responsif dan mudah digunakan.</p>
<h2 class="code-line" data-line-start=8 data-line-end=9 ><a id="_Fitur_Utama_8"></a>🚀 Fitur Utama</h2>
<ul>
<li class="has-line-data" data-line-start="10" data-line-end="11">Dashboard informatif dengan statistik kredit dan pembayaran real-time</li>
<li class="has-line-data" data-line-start="11" data-line-end="12">Pencatatan pengajuan kredit kendaraan</li>
<li class="has-line-data" data-line-start="12" data-line-end="13">Pengelolaan data pelanggan dan kendaraan</li>
<li class="has-line-data" data-line-start="13" data-line-end="14">Pencatatan dan pengelolaan angsuran (angsuran bulanan, pelunasan)</li>
<li class="has-line-data" data-line-start="14" data-line-end="15">Pengelolaan data petugas kredit</li>
<li class="has-line-data" data-line-start="15" data-line-end="16">Pembuatan laporan kredit (harian, bulanan, tahunan)</li>
<li class="has-line-data" data-line-start="16" data-line-end="17">Pencarian data pelanggan dan histori kredit</li>
<li class="has-line-data" data-line-start="17" data-line-end="18">Sistem login multi-level (admin dan petugas)</li>
<li class="has-line-data" data-line-start="18" data-line-end="19">Desain responsif untuk desktop, tablet, dan perangkat mobile</li>
</ul>
<h2 class="code-line" data-line-start=21 data-line-end=22 ><a id="_Teknologi_yang_Digunakan_21"></a>🛠️ Teknologi yang Digunakan</h2>
<ul>
<li class="has-line-data" data-line-start="23" data-line-end="24"><strong>Backend:</strong> PHP Native</li>
<li class="has-line-data" data-line-start="24" data-line-end="25"><strong>Database:</strong> MySQL</li>
<li class="has-line-data" data-line-start="25" data-line-end="33"><strong>Frontend:</strong>
<ul>
<li class="has-line-data" data-line-start="26" data-line-end="27">HTML5, CSS3, JavaScript</li>
<li class="has-line-data" data-line-start="27" data-line-end="28">Bootstrap 4 (SB Admin 2)</li>
<li class="has-line-data" data-line-start="28" data-line-end="29">jQuery</li>
<li class="has-line-data" data-line-start="29" data-line-end="30">DataTables</li>
<li class="has-line-data" data-line-start="30" data-line-end="31">Font Awesome</li>
<li class="has-line-data" data-line-start="31" data-line-end="33">jQuery Easing</li>
</ul>
</li>
</ul>
<h2 class="code-line" data-line-start=33 data-line-end=34 ><a id="_Persyaratan_Sistem_33"></a>📋 Persyaratan Sistem</h2>
<ul>
<li class="has-line-data" data-line-start="35" data-line-end="36">PHP 7.0+</li>
<li class="has-line-data" data-line-start="36" data-line-end="37">MySQL 5.6+</li>
<li class="has-line-data" data-line-start="37" data-line-end="38">Apache Web Server</li>
<li class="has-line-data" data-line-start="38" data-line-end="40">XAMPP/WAMP/LAMP</li>
</ul>
<h2 class="code-line" data-line-start=40 data-line-end=41 ><a id="_Cara_Menjalankan_Aplikasi_40"></a>⚙️ Cara Menjalankan Aplikasi</h2>
<h3 class="code-line" data-line-start=42 data-line-end=43 ><a id="1_Persiapan_42"></a>1. Persiapan</h3>
<ul>
<li class="has-line-data" data-line-start="43" data-line-end="44">Instal dan jalankan XAMPP</li>
<li class="has-line-data" data-line-start="44" data-line-end="46">Aktifkan Apache dan MySQL</li>
</ul>
<h3 class="code-line" data-line-start=46 data-line-end=47 ><a id="2_Instalasi_Database_46"></a>2. Instalasi Database</h3>
<ul>
<li class="has-line-data" data-line-start="47" data-line-end="48">Buka <code>http://localhost/phpmyadmin</code></li>
<li class="has-line-data" data-line-start="48" data-line-end="49">Buat database baru: <code>dbkreditkendaraan</code></li>
<li class="has-line-data" data-line-start="49" data-line-end="50">Import file <code>dbkreditkendaraan.sql</code></li>
<li class="has-line-data" data-line-start="50" data-line-end="52">Klik <strong>Go</strong></li>
</ul>
<h3 class="code-line" data-line-start=52 data-line-end=53 ><a id="3_Instalasi_Aplikasi_52"></a>3. Instalasi Aplikasi</h3>
<ul>
<li class="has-line-data" data-line-start="53" data-line-end="54">Ekstrak/clone ke folder <code>htdocs</code></li>
<li class="has-line-data" data-line-start="54" data-line-end="61">Ubah koneksi database di <code>config.php</code>:<pre><code class="has-line-data" data-line-start="56" data-line-end="61" class="language-php"><span class="hljs-variable">$host</span> = <span class="hljs-string">"localhost"</span>;
<span class="hljs-variable">$username</span> = <span class="hljs-string">"root"</span>;
<span class="hljs-variable">$password</span> = <span class="hljs-string">""</span>;
<span class="hljs-variable">$database</span> = <span class="hljs-string">"dbkreditkendaraan"</span>;

</code></pre>
</li>
</ul>
<h3 class="code-line" data-line-start=61 data-line-end=62 ><a id="4_Menjalankan_Aplikasi_61"></a>4. Menjalankan Aplikasi</h3>
<ul>
<li class="has-line-data" data-line-start="62" data-line-end="63">Buka browser: <a href="http://localhost/kredit_kendaraan">http://localhost/kredit_kendaraan</a></li>
</ul>
<h3 class="code-line" data-line-start=65 data-line-end=66 ><a id="5_Login_65"></a>5. Login</h3>
<p class="has-line-data" data-line-start="66" data-line-end="67"><strong>Admin</strong></p>
<ul>
<li class="has-line-data" data-line-start="67" data-line-end="68">Username: admin</li>
<li class="has-line-data" data-line-start="68" data-line-end="69">Password: admin</li>
<li class="has-line-data" data-line-start="69" data-line-end="71">Hak Akses: Penuh</li>
</ul>
<p class="has-line-data" data-line-start="71" data-line-end="72"><strong>Petugas</strong></p>
<ul>
<li class="has-line-data" data-line-start="72" data-line-end="73">Username: petugas</li>
<li class="has-line-data" data-line-start="73" data-line-end="74">Password: petugas</li>
<li class="has-line-data" data-line-start="74" data-line-end="76">Hak Akses: Terbatas</li>
</ul>
<h2 class="code-line" data-line-start=76 data-line-end=77 ><a id="_Struktur_Proyek_76"></a>📁 Struktur Proyek</h2>
<pre><code class="has-line-data" data-line-start="79" data-line-end="100" class="language-plaintext">kredit_kendaraan/
├── assets/
│   ├── css/
│   ├── img/
│   ├── js/
│   ├── scss/
│   └── vendor/
├── auth/
├── config/
├── includes/
│   ├── footer.php
│   ├── header.php
│   ├── modals.php
│   ├── scripts.php
│   ├── sidebar.php
│   └── topbar.php
├── pages/
│   ├── dbkreditkendaraan.sql
├── index.php
└── README.md
</code></pre>
<h2 class="code-line" data-line-start=101 data-line-end=102 ><a id="_File_Konfigurasi_101"></a>🔧 File Konfigurasi</h2>
<ul>
<li class="has-line-data" data-line-start="102" data-line-end="104">config.php – konfigurasi koneksi database</li>
</ul>
<h2 class="code-line" data-line-start=104 data-line-end=105 ><a id="_Responsivitas_104"></a>📱 Responsivitas</h2>
<ul>
<li class="has-line-data" data-line-start="105" data-line-end="106">Desktop: Tampilan lengkap</li>
<li class="has-line-data" data-line-start="106" data-line-end="107">Tablet: Layout disesuaikan</li>
<li class="has-line-data" data-line-start="107" data-line-end="109">Mobile: Tampilan ringkas + menu hamburger</li>
</ul>
<h2 class="code-line" data-line-start=109 data-line-end=110 ><a id="_Lisensi_Library_109"></a>📜 Lisensi Library</h2>
<ul>
<li class="has-line-data" data-line-start="110" data-line-end="111">Bootstrap SB Admin 2: MIT</li>
<li class="has-line-data" data-line-start="111" data-line-end="112">jQuery: MIT</li>
<li class="has-line-data" data-line-start="112" data-line-end="113">DataTables: MIT</li>
<li class="has-line-data" data-line-start="113" data-line-end="114">Font Awesome: Free License</li>
<li class="has-line-data" data-line-start="114" data-line-end="116">jQuery Easing: BSD</li>
</ul>
<h2 class="code-line" data-line-start=116 data-line-end=117 ><a id="_Pengembang_116"></a>👨‍💻 Pengembang</h2>
<ul>
<li class="has-line-data" data-line-start="118" data-line-end="119">👤 Fadhil Rafi Fauzan</li>
<li class="has-line-data" data-line-start="119" data-line-end="120">📧 Email: <a href="mailto:fadhilrafifauzan.17@gmail.com">fadhilrafifauzan.17@gmail.com</a></li>
<li class="has-line-data" data-line-start="120" data-line-end="122">🐙 GitHub: <a href="http://github.com/fdhlrf.1">github.com/fdhlrf.1</a></li>
</ul>
<p class="has-line-data" data-line-start="122" data-line-end="124">© 2025 Kredit Kendaraan — Hak Cipta Dilindungi Undang-Undang.<br>
Terima kasih telah menggunakan aplikasi ini! ⭐</p>
