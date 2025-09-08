<?php
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bài tập HTML/CSS/PHP – thực hành cơ bản</title>
<style>
/* ...existing code... */
/* Nút ẩn/hiện menu bên trái */
.aside-toggle {
  position: fixed; left: 12px; top: 16px; z-index: 200;
  background: var(--accent); color: #fff; border: none; border-radius: 8px;
  padding: 8px 12px; font-size: 22px; cursor: pointer; box-shadow: 0 2px 8px rgba(56,189,248,0.12);
  display: none;
}
@media (max-width: 900px) {
  .container { grid-template-columns: 1fr; }
  .aside { position: fixed; left: 0; top: 0; height: 100vh; width: 240px; transform: translateX(-100%); transition: transform 0.3s; z-index: 150; }
  .aside.show { transform: translateX(0); }
  .aside-toggle { display: block; }
  main { padding-left: 0 !important; }
  .navbar-top { flex-direction: column; align-items: stretch; gap: 8px; padding: 8px 12px 0 12px; }
  .search-bar input[type="text"] { min-width: 120px; }
  .navbar-menu ul { flex-direction: column; }
  .navbar-menu ul li a { padding: 12px 16px; }
  .navbar-menu .dropdown-content { position: static; min-width: unset; box-shadow: none; border-radius: 0; }
}
</style>
<script>
function toggleAside() {
  var aside = document.querySelector('.aside');
  aside.classList.toggle('show');
  var icon = document.getElementById('aside-icon');
  icon.textContent = aside.classList.contains('show') ? '✖' : '☰';
}
// Tự động ẩn menu khi click ra ngoài trên mobile
document.addEventListener('click', function(e) {
  var aside = document.querySelector('.aside');
  var toggle = document.querySelector('.aside-toggle');
  if (window.innerWidth <= 900 && aside.classList.contains('show')) {
    if (!aside.contains(e.target) && !toggle.contains(e.target)) {
      aside.classList.remove('show');
      document.getElementById('aside-icon').textContent = '☰';
    }
  }
});
</script>
</head>
<body>
  <button class="aside-toggle" aria-label="Ẩn/hiện menu" onclick="toggleAside()">
    <span id="aside-icon">☰</span>
  </button>
<?php
session_start();

/* ========= Helpers ========= */
function is_prime($x) {
    if ($x < 2) return false;
    if ($x % 2 == 0) return $x == 2;
    for ($i = 3; $i * $i <= $x; $i += 2) {
        if ($x % $i == 0) return false;
    }
    return true;
}

function sum_primes_1_100() {
    $sum = 0;
    for ($i = 2; $i <= 100; $i++) if (is_prime($i)) $sum += $i;
    return $sum;
}

function sum_series_2a($n) {
    // T = 1/2 + 2/3 + ... + n/(n+1)
    $k = 1;
    $T = 0.0;
    while (true) {               // vòng lặp không xác định
        $T += $k / ($k + 1);
        $k++;
        if ($k > $n) break;
    }
    return $T;
}

function sum_series_2b_eps($eps = 0.0001) {
    // T = 1/2 + 1/4 + 1/6 + ... + 1/(n+2) với 1/(n+2) > eps
    // dừng khi term <= eps
    $n = 0;
    $T = 0.0;
    while (true) {
        $term = 1.0 / ($n + 2);  // n: 0,2,4,... -> mẫu số 2,4,6...
        if ($term <= $eps) break;
        $T += $term;
        $n += 2;
    }
    return $T;
}

function factorial($n) {
    if ($n < 0) return null;
    $res = 1;
    for ($i = 2; $i <= $n; $i++) $res *= $i;
    return $res;
}

function is_perfect($n) {
    if ($n <= 1) return false;
    $sum = 1;
    for ($i = 2; $i * $i <= $n; $i++) {
        if ($n % $i == 0) {
            $sum += $i;
            if ($i != $n / $i) $sum += $n / $i;
        }
    }
    return $sum == $n;
}

function divisors($n) {
    $ds = [];
    for ($i = 1; $i * $i <= $n; $i++) {
        if ($n % $i == 0) {
            $ds[] = $i;
            if ($i != $n / $i) $ds[] = $n / $i;
        }
    }
    sort($ds);
    return $ds;
}

function format_hms($seconds) {
    $seconds = max(0, (int)$seconds);
    $h = floor($seconds / 3600);
    $m = floor(($seconds % 3600) / 60);
    $s = $seconds % 60;
    return sprintf("%02d:%02d:%02d", $h, $m, $s);
}

/* ========= Classes for Bài 10 ========= */
class Person {
    public $hoten;
    public $ngaysinh;
    public $quequan;
    public function __construct($hoten, $ngaysinh, $quequan) {
        $this->hoten = $hoten;
        $this->ngaysinh = $ngaysinh;
        $this->quequan = $quequan;
    }
}
class SinhVien extends Person {
    public $lop;
    public function __construct($hoten, $ngaysinh, $quequan, $lop) {
        parent::__construct($hoten, $ngaysinh, $quequan);
        $this->lop = $lop;
    }
}

/* ========= Bài 4: lưu chuỗi số trong session ========= */
if (!isset($_SESSION['bai4'])) $_SESSION['bai4'] = [];
if (isset($_POST['bai4_add'])) {
    $val = (int)($_POST['bai4_value'] ?? 0);
    if ($val === 0) {
        $_SESSION['bai4_end'] = true;
    } else {
        $_SESSION['bai4'][] = $val;
    }
}
if (isset($_POST['bai4_reset'])) {
    $_SESSION['bai4'] = [];
    unset($_SESSION['bai4_end']);
}

/* ========= Submit handlers ========= */
$results = [];

if (isset($_POST['bai1'])) {
    $results['bai1'] = sum_primes_1_100();
}

if (isset($_POST['bai2a'])) {
    $n = max(1, (int)($_POST['n2a'] ?? 1));
    $results['bai2a'] = sum_series_2a($n);
}

if (isset($_POST['bai2b'])) {
    $eps = floatval($_POST['eps2b'] ?? 0.0001);
    if ($eps <= 0) $eps = 0.0001;
    $results['bai2b'] = sum_series_2b_eps($eps);
}

if (isset($_POST['bai3'])) {
    // TODO: Cập nhật biểu thức đúng theo ảnh đề (Bài 3).
    // TẠM THỜI: ví dụ placeholder: S = 1 + 1/2 + ... + 1/n
    $n = max(1, (int)($_POST['n3'] ?? 1));
    $S = 0.0;
    for ($i = 1; $i <= $n; $i++) $S += 1.0 / $i;
    $results['bai3'] = [
        'note' => 'Đây là công thức tạm. Thay bằng biểu thức đúng của đề khi có ảnh rõ.',
        'value' => $S
    ];
}

if (isset($_POST['bai5'])) {
    $n = max(1, (int)($_POST['n5'] ?? 1));
    $results['bai5'] = is_perfect($n);
}

if (isset($_POST['bai6'])) {
    $n = max(0, (int)($_POST['n6'] ?? 0));
    $results['bai6'] = factorial($n);
}

if (isset($_POST['bai7'])) {
    $n = max(1, (int)($_POST['n7'] ?? 1));
    $results['bai7'] = divisors($n);
}

// Tách xử lý bài 8 ra file riêng
include_once __DIR__ . '/bai8.php';
if (isset($_POST['bai8'])) {
  $arrstr = trim($_POST['arr8'] ?? '');
  $results['bai8'] = bai8_handle($arrstr);
}

if (isset($_POST['bai9'])) {
    $sec = max(0, (int)($_POST['sec9'] ?? 0));
    $results['bai9'] = format_hms($sec);
}

if (isset($_POST['bai10'])) {
    $sv = new SinhVien(
        $_POST['hoten10'] ?? '',
        $_POST['ngaysinh10'] ?? '',
        $_POST['que10'] ?? '',
        $_POST['lop10'] ?? ''
    );
    $results['bai10'] = $sv;
}

if (isset($_POST['bai11'])) {
    // Demo nhận form bài 11
    $results['bai11'] = [
        'name' => $_POST['f11_name'] ?? '',
        'email' => $_POST['f11_email'] ?? '',
        'phone' => $_POST['f11_phone'] ?? '',
        'note' => $_POST['f11_note'] ?? ''
    ];
}
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bài tập HTML/CSS/PHP – thực hành cơ bản</title>
<style>
/* Màu sắc tươi sáng, hiện đại */
:root {
  --bg: #f3f8ff;      /* nền sáng */
  --panel: #e0e7ef;   /* panel sáng */
  --card: #ffffff;    /* card trắng */
  --accent: #38bdf8;  /* xanh dương sáng */
  --accent2: #fbbf24; /* vàng nhấn */
  --muted: #64748b;   /* xám nhạt */
  --text: #1e293b;    /* chữ đậm */
}
* { box-sizing: border-box; }
body {
  margin: 0; font-family: system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial;
  background: linear-gradient(135deg, #e0e7ef 0%, #f3f8ff 40%, #e0e7ef 100%);
  color: var(--text);
}
/* Layout và panel */
.container { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }
.aside {
  background: linear-gradient(180deg, #fbbf24 0%, var(--panel) 100%);
  border-right: 1px solid #cbd5e1;
  padding: 24px 16px; position: sticky; top: 0; height: 100vh; overflow:auto;
}
.brand { font-size: 20px; font-weight: 700; letter-spacing:.3px; margin-bottom: 16px; color: var(--accent2); }
.brand span { color: var(--accent); }
.nav a {
  display:block; padding:10px 12px; margin:6px 0; border-radius:10px;
  color: var(--text); text-decoration:none; background: #e0e7ef; border:1px solid #cbd5e1;
  font-weight: 500;
}
.nav a:hover { border-color: var(--accent); background: var(--accent); color: #fff; box-shadow: 0 0 0 2px #38bdf8 inset; }
main { padding: 32px 24px; }
h1 { margin: 0 0 12px; font-size: 28px; color: var(--accent); }
.subtitle { color: var(--muted); margin-bottom: 24px; font-size: 16px; }
.card {
  background: linear-gradient(120deg, #f3f8ff 60%, #e0e7ef 100%);
  border: 1px solid #cbd5e1; border-radius: 18px; margin-bottom: 18px; overflow: hidden;
  box-shadow: 0 2px 12px rgba(56,189,248,0.08);
}
.card header { padding: 16px 18px; font-weight: 600; border-bottom:1px solid #cbd5e1; background: var(--accent2); color: #fff; }
.card .body { padding: 18px; }
.row { display:flex; gap:14px; flex-wrap: wrap; }
.row > * { flex: 1 1 240px; }
input, select, textarea, button {
  width: 100%; padding: 11px 13px; border-radius: 10px; border:1px solid #cbd5e1;
  background:#f3f8ff; color:var(--text); font-size: 15px;
}
button {
  background: linear-gradient(135deg, #38bdf8, #fbbf24); color:#1e293b; font-weight:700; cursor:pointer;
  border:none; transition: filter 0.2s;
}
button:hover { filter: brightness(1.08); }
.code { font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace; color:#2563eb; }
.kq { margin-top:10px; padding:10px; border:1px dashed #38bdf8; border-radius:10px; background:#e0e7ef; color:var(--text); }
.small { font-size: 12px; color: var(--muted); }
hr.soft { border:none; height:1px; background: linear-gradient(90deg,#e0e7ef, #38bdf8, #e0e7ef); margin: 20px 0; }
footer { color: var(--muted); font-size: 13px; text-align: center; padding: 14px; }
@media (max-width: 900px) {
  .container { grid-template-columns: 1fr; }
  .aside { position: static; height: auto; }
}
<style>
/* Navbar ngang và thông tin sinh viên, tìm kiếm */
.navbar {
  width: 100%; background: var(--panel); border-bottom: 1px solid #1e293b;
  padding: 0; margin: 0; position: sticky; top: 0; z-index: 100;
}
.navbar-top {
  display: flex; justify-content: space-between; align-items: center;
  padding: 8px 24px 0 24px;
  background: var(--panel);
}
.student-info {
  font-size: 16px; color: var(--accent2); font-weight: 600;
  letter-spacing: .5px;
}
.search-bar {
  display: flex; align-items: center; gap: 6px;
}
.search-bar input[type="text"] {
  padding: 7px 12px; border-radius: 8px; border: 1px solid #cbd5e1;
  background: #fff; color: var(--text); font-size: 15px; min-width: 220px;
}
.search-bar button {
  padding: 7px 14px; border-radius: 8px; border: none;
  background: var(--accent); color: #fff; font-size: 16px; font-weight: 700; cursor: pointer;
  transition: background 0.2s;
}
.search-bar button:hover {
  background: var(--accent2); color: var(--text);
}
.navbar-menu ul {
  list-style: none; margin: 0; padding: 0; display: flex; align-items: center;
}
.navbar-menu ul li {
  position: relative; margin: 0; padding: 0;
}
.navbar-menu ul li a {
  display: block; padding: 14px 22px; color: var(--text); text-decoration: none;
  font-weight: 500; font-size: 16px; transition: background 0.2s;
}
.navbar-menu ul li a:hover {
  background: var(--accent); color: #001018;
}
.navbar-menu .dropdown:hover > a {
  background: var(--accent); color: #001018;
}
.navbar-menu .dropdown-content {
  display: none; position: absolute; left: 0; top: 100%; min-width: 220px;
  background: var(--card); border: 1px solid #1e293b; border-radius: 0 0 12px 12px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.12);
  z-index: 10;
}
.navbar-menu .dropdown:hover .dropdown-content {
  display: block;
}
.navbar-menu .dropdown-content li a {
  padding: 12px 18px; font-size: 15px;
}
.navbar-menu .dropdown-content li a:hover {
  background: var(--accent); color: #001018;
}
@media (max-width: 900px) {
  .navbar-top { flex-direction: column; align-items: stretch; gap: 8px; padding: 8px 12px 0 12px; }
  .search-bar input[type="text"] { min-width: 120px; }
  .navbar-menu ul { flex-direction: column; }
  .navbar-menu ul li a { padding: 12px 16px; }
  .navbar-menu .dropdown-content { position: static; min-width: unset; box-shadow: none; border-radius: 0; }
}
</style>
</style>
</head>
<body>
<!-- Navbar ngang ở header -->
<header class="navbar">
  <div class="navbar-top">
    <div class="student-info">
      <span><b>Vũ Văn Hà Công</b></span> | Khoa CNTT | Lớp CNTT4-K63
    </div>
    <form class="search-bar" method="get" action="#">
      <input type="text" name="search" placeholder="Tìm kiếm bài tập, lý thuyết..." />
      <button type="submit">🔍</button>
    </form>
  </div>
  <nav class="navbar-menu">
    <ul>
      <li><a href="#home">Trang chủ</a></li>
      <li class="dropdown">
        <a href="#bai">Bài tập ▼</a>
        <ul class="dropdown-content">
          <li><a href="#b1">Bài 1 – Tổng số nguyên tố</a></li>
          <li><a href="#b2">Bài 2 – Chuỗi & epsilon</a></li>
          <li><a href="#b3">Bài 3 – Biểu thức (ảnh)</a></li>
          <li><a href="#b4">Bài 4 – Nhập đến 0</a></li>
          <li><a href="#b5">Bài 5 – Số hoàn hảo</a></li>
          <li><a href="#b6">Bài 6 – Giai thừa</a></li>
          <li><a href="#b7">Bài 7 – Ước số</a></li>
          <li><a href="#b8">Bài 8 – Đếm âm/dương</a></li>
          <li><a href="#b9">Bài 9 – hh:mm:ss</a></li>
          <li><a href="#b10">Bài 10 – PERSON/SINHVIEN</a></li>
          <li><a href="#b11">Bài 11 – Form</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#tai-lieu">Tài liệu ▼</a>
        <ul class="dropdown-content">
          <li><a href="hoc-php.html">Học PHP</a></li>
          <li><a href="hoc-css-html.html">Học CSS &amp; HTML</a></li>
          <li><a href="#lythuyet">Lý thuyết</a></li>
          <li><a href="#huongdan">Hướng dẫn</a></li>
        </ul>
      </li>
      <li><a href="#lienhe">Liên hệ</a></li>
    </ul>
  </nav>
</header>
<div class="container">
  <aside class="aside">
    <div class="brand">Thực hành <span>HTML/CSS/PHP</span></div>
    <div class="nav">
      <a href="#b1">Bài 1 – Tổng số nguyên tố</a>
      <a href="#b2">Bài 2 – Chuỗi & epsilon</a>
      <a href="#b3">Bài 3 – Biểu thức (ảnh)</a>
      <a href="#b4">Bài 4 – Nhập đến 0</a>
      <a href="#b5">Bài 5 – Số hoàn hảo</a>
      <a href="#b6">Bài 6 – Giai thừa</a>
      <a href="#b7">Bài 7 – Ước số</a>
      <a href="#b8">Bài 8 – Đếm âm/dương</a>
      <a href="#b9">Bài 9 – hh:mm:ss</a>
      <a href="#b10">Bài 10 – PERSON/SINHVIEN</a>
      <a href="#b11">Bài 11 – Form</a>
    </div>
  </aside>

  <main>
    <h1>Thực hành cơ bản với HTML, CSS, PHP</h1>
    <div class="subtitle">Giao diện gọn nhẹ, mỗi bài là một thẻ thao tác riêng. (Bạn có thể chỉnh màu, font cho khớp mẫu PDF)</div>

    <!-- Bài 1 -->
    <section id="b1" class="card">
      <header>Bài 1 – Tính tổng các số nguyên tố từ 1 đến 100</header>
      <div class="body">
        <form method="post" class="row">
          <div><button name="bai1">Tính tổng</button></div>
        </form>
        <?php if (isset($results['bai1'])): ?>
          <div class="kq">Tổng các số nguyên tố 1..100 = <b><?= htmlspecialchars($results['bai1']) ?></b></div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Bài 2 -->
    <section id="b2" class="card">
      <header>Bài 2 – Vòng lặp không xác định</header>
      <div class="body">
        <div class="row">
          <div>
            <form method="post">
              <div class="small">2a) T = 1/2 + 2/3 + ... + n/(n+1)</div>
              <input type="number" name="n2a" min="1" value="5" required>
              <button name="bai2a" class="mt">Tính</button>
            </form>
            <?php if (isset($results['bai2a'])): ?>
              <div class="kq">Kết quả 2a: <b><?= htmlspecialchars($results['bai2a']) ?></b></div>
            <?php endif; ?>
          </div>
          <div>
            <form method="post">
              <div class="small">2b) Dừng khi 1/(n+2) ≤ epsilon</div>
              <input type="number" step="0.0001" name="eps2b" value="0.0001">
              <button name="bai2b">Tính</button>
            </form>
            <?php if (isset($results['bai2b'])): ?>
              <div class="kq">Kết quả 2b: <b><?= htmlspecialchars($results['bai2b']) ?></b></div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <!-- Bài 3 -->
    <section id="b3" class="card">
      <header>Bài 3 – Tính giá trị biểu thức (biểu thức nằm trong ảnh đề)</header>
      <div class="body">
        <form method="post" class="row">
          <div>
            <label class="small">Nhập n</label>
            <input type="number" name="n3" min="1" value="5" required>
          </div>
          <div style="flex-basis: 100%;">
            <div class="small">* Hiện đang dùng <span class="code">S = 1 + 1/2 + ... + 1/n</span> làm placeholder. Cập nhật công thức theo ảnh khi có.</div>
          </div>
          <div><button name="bai3">Tính</button></div>
        </form>
        <?php if (isset($results['bai3'])): ?>
          <div class="kq">
            <div><?= htmlspecialchars($results['bai3']['note']) ?></div>
            <div>Giá trị: <b><?= htmlspecialchars($results['bai3']['value']) ?></b></div>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Bài 4 -->
    <section id="b4" class="card">
      <header>Bài 4 – Nhập số cho đến khi nhập 0 thì dừng (dùng session)</header>
      <div class="body">
        <form method="post" class="row">
          <div>
            <label class="small">Nhập một số (0 để dừng)</label>
            <input type="number" name="bai4_value" required>
          </div>
          <div style="max-width:200px"><button name="bai4_add">Thêm</button></div>
          <div style="max-width:200px"><button name="bai4_reset" type="submit">Reset</button></div>
        </form>
        <div class="kq">
          <div class="small">Dãy hiện tại:</div>
          <div><b><?= htmlspecialchars(implode(', ', $_SESSION['bai4'])) ?></b></div>
          <?php if (!empty($_SESSION['bai4_end'])): ?>
            <div class="small">Đã nhập 0: dừng nhận thêm. Nhấn Reset để bắt đầu lại.</div>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- Bài 5 -->
    <section id="b5" class="card">
      <header>Bài 5 – Kiểm tra số hoàn hảo</header>
      <div class="body">
        <form method="post" class="row">
          <div><input type="number" name="n5" min="1" value="28" required></div>
          <div style="max-width:200px"><button name="bai5">Kiểm tra</button></div>
        </form>
        <?php if (isset($results['bai5'])): ?>
          <div class="kq">
            Kết quả: <b><?= $results['bai5'] ? 'Là số hoàn hảo' : 'Không phải số hoàn hảo' ?></b>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Bài 6 -->
    <section id="b6" class="card">
      <header>Bài 6 – Tính n!</header>
      <div class="body">
        <form method="post" class="row">
          <div><input type="number" name="n6" min="0" value="6" required></div>
          <div style="max-width:200px"><button name="bai6">Tính</button></div>
        </form>
        <?php if (isset($results['bai6'])): ?>
          <div class="kq">n! = <b><?= htmlspecialchars($results['bai6']) ?></b></div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Bài 7 -->
    <section id="b7" class="card">
      <header>Bài 7 – Liệt kê ước số</header>
      <div class="body">
        <form method="post" class="row">
          <div><input type="number" name="n7" min="1" value="36" required></div>
          <div style="max-width:200px"><button name="bai7">Liệt kê</button></div>
        </form>
        <?php if (isset($results['bai7'])): ?>
          <div class="kq">Ước số: <b><?= htmlspecialchars(implode(', ', $results['bai7'])) ?></b></div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Bài 8 -->
    <section id="b8" class="card">
      <header>Bài 8 – Mảng 10 phần tử: đếm âm/dương</header>
      <div class="body">
        <form method="post" class="row">
          <div style="flex-basis:100%">
            <label class="small">Nhập 10 số, cách nhau bởi dấu phẩy (để trống sẽ random):</label>
            <input type="text" name="arr8" placeholder="-2,0,3,..." value="">
          </div>
          <div style="max-width:200px"><button name="bai8">Đếm</button></div>
        </form>
        <?php if (isset($results['bai8'])): ?>
          <div class="kq">
            <div>Mảng: <span class="code"><?= htmlspecialchars(json_encode($results['bai8']['array'])) ?></span></div>
            <div>Dương: <b><?= $results['bai8']['pos'] ?></b> — Âm: <b><?= $results['bai8']['neg'] ?></b> — 0: <b><?= $results['bai8']['zero'] ?></b></div>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Bài 9 -->
    <section id="b9" class="card">
      <header>Bài 9 – Đổi giây sang hh:mm:ss</header>
      <div class="body">
        <form method="post" class="row">
          <div><input type="number" name="sec9" min="0" value="3769" required></div>
          <div style="max-width:200px"><button name="bai9">Đổi</button></div>
        </form>
        <?php if (isset($results['bai9'])): ?>
          <div class="kq">Kết quả: <b><?= htmlspecialchars($results['bai9']) ?></b></div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Bài 10 -->
    <section id="b10" class="card">
      <header>Bài 10 – Lớp PERSON / SINHVIEN (in thông tin cá nhân)</header>
      <div class="body">
        <form method="post" class="row">
          <div><input name="hoten10" placeholder="Họ tên" required></div>
          <div><input type="date" name="ngaysinh10" required></div>
          <div><input name="que10" placeholder="Quê quán" required></div>
          <div><input name="lop10" placeholder="Lớp" required></div>
          <div style="max-width:200px"><button name="bai10">Tạo & In</button></div>
        </form>
        <?php if (isset($results['bai10'])): $sv = $results['bai10']; ?>
          <div class="kq">
            <div><b>Thông tin sinh viên</b></div>
            <div>Họ tên: <?= htmlspecialchars($sv->hoten) ?></div>
            <div>Ngày sinh: <?= htmlspecialchars($sv->ngaysinh) ?></div>
            <div>Quê quán: <?= htmlspecialchars($sv->quequan) ?></div>
            <div>Lớp: <?= htmlspecialchars($sv->lop) ?></div>
          </div>
        <?php endif; ?>
      </div>
    </section>

    <!-- Bài 11 -->
    <section id="b11" class="card">
      <header>Bài 11 – Form giao diện (dựng theo tinh thần mẫu ảnh)</header>
      <div class="body">
        <form method="post" class="row">
          <div><input name="f11_name" placeholder="Họ và tên" required></div>
          <div><input type="email" name="f11_email" placeholder="Email" required></div>
          <div><input name="f11_phone" placeholder="Số điện thoại"></div>
          <div style="flex-basis:100%"><textarea name="f11_note" rows="4" placeholder="Ghi chú"></textarea></div>
          <div style="max-width:200px"><button name="bai11">Gửi</button></div>
        </form>
        <?php if (isset($results['bai11'])): ?>
          <div class="kq">
            <div>Đã nhận form:</div>
            <div class="code"><?= htmlspecialchars(json_encode($results['bai11'], JSON_UNESCAPED_UNICODE)) ?></div>
          </div>
        <?php endif; ?>
        <div class="small">* Khi có ảnh mẫu chính xác, bạn chỉ cần chỉnh lại nhãn/input cho trùng 100%.</div>
      </div>
    </section>

    <hr class="soft">
    <footer>Made with ❤️ — có thể chỉnh màu/spacing nhanh trong phần <span class="code">&lt;style&gt;</span>.</footer>
  </main>
</div>
</body>
</html>
