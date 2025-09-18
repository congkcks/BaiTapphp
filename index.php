<?php
session_start();

/* ========= Helper Functions ========= */

// Bài 1: Kiểm tra số nguyên tố
function is_prime($x) {
    if ($x < 2) return false;
    if ($x % 2 == 0) return $x == 2;
    for ($i = 3; $i * $i <= $x; $i += 2) {
        if ($x % $i == 0) return false;
    }
    return true;
}

// Bài 1: Tính tổng các số nguyên tố từ 1 đến 100
function sum_primes_1_100() {
    $sum = 0;
    for ($i = 2; $i <= 100; $i++) if (is_prime($i)) $sum += $i;
    return $sum;
}

// Bài 2a: Tính tổng chuỗi T = 1/2 + 2/3 + ... + n/(n+1)
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

// Bài 2b: Tính tổng chuỗi T = 1/2 + 1/4 + 1/6 + ... với điều kiện epsilon
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

// Bài 6: Tính giai thừa của số n
function factorial($n) {
    if ($n < 0) return null;
    $res = 1;
    for ($i = 2; $i <= $n; $i++) $res *= $i;
    return $res;
}

// Bài 5: Kiểm tra số hoàn hảo
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

// Bài 7: Tìm các ước số của một số nguyên
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

// Bài 9: Chuyển đổi giây thành định dạng hh:mm:ss
function format_hms($seconds) {
    $seconds = max(0, (int)$seconds);
    $h = floor($seconds / 3600);
    $m = floor(($seconds % 3600) / 60);
    $s = $seconds % 60;
    return sprintf("%02d:%02d:%02d", $h, $m, $s);
}

/* ========= Bài 10: Classes Person và SinhVien ========= */
// Bài 10: Class cơ sở Person
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

// Bài 10: Class SinhVien kế thừa từ Person
class SinhVien extends Person {
    public $lop;
    public function __construct($hoten, $ngaysinh, $quequan, $lop) {
        parent::__construct($hoten, $ngaysinh, $quequan);
        $this->lop = $lop;
    }
}

/* ========= Bài 4: Xử lý session lưu chuỗi số ========= */
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

/* ========= Submit Handlers - Xử lý kết quả các bài tập ========= */
$results = [];

// Bài 1: Xử lý submit tổng số nguyên tố
if (isset($_POST['bai1'])) {
    $results['bai1'] = sum_primes_1_100();
}

// Bài 2a: Xử lý submit tính tổng chuỗi với n cho trước
if (isset($_POST['bai2a'])) {
    $n = max(1, (int)($_POST['n2a'] ?? 1));
    $results['bai2a'] = sum_series_2a($n);
}

// Bài 2b: Xử lý submit tính tổng chuỗi với epsilon
if (isset($_POST['bai2b'])) {
    $eps = floatval($_POST['eps2b'] ?? 0.0001);
    if ($eps <= 0) $eps = 0.0001;
    $results['bai2b'] = sum_series_2b_eps($eps);
}

// Bài 3: Xử lý submit biểu thức (placeholder)
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

// Bài 5: Xử lý submit kiểm tra số hoàn hảo
if (isset($_POST['bai5'])) {
    $n = max(1, (int)($_POST['n5'] ?? 1));
    $results['bai5'] = is_perfect($n);
}

// Bài 6: Xử lý submit tính giai thừa
if (isset($_POST['bai6'])) {
    $n = max(0, (int)($_POST['n6'] ?? 0));
    $results['bai6'] = factorial($n);
}

// Bài 7: Xử lý submit tìm ước số
if (isset($_POST['bai7'])) {
    $n = max(1, (int)($_POST['n7'] ?? 1));
    $results['bai7'] = divisors($n);
}

// Bài 8: Xử lý submit đếm số âm/dương (sử dụng file bai8.php)
include_once __DIR__ . '/bai8.php';
if (isset($_POST['bai8'])) {
  $arrstr = trim($_POST['arr8'] ?? '');
  // Lọc tất cả số nguyên từ chuỗi nhập vào, lấy tối đa 10 số đầu tiên
  preg_match_all('/-?\d+/', $arrstr, $matches);
  $numbers = array_map('intval', $matches[0]);
  $numbers = array_slice($numbers, 0, 10);
  // Nếu không nhập hoặc không đủ 10 số thì random cho đủ
  while (count($numbers) < 10) {
    $numbers[] = rand(-20, 20);
  }
  $results['bai8'] = bai8_handle(implode(',', $numbers));
}

// Bài 9: Xử lý submit chuyển đổi giây thành hh:mm:ss
if (isset($_POST['bai9'])) {
    $sec = max(0, (int)($_POST['sec9'] ?? 0));
    $results['bai9'] = format_hms($sec);
}

// Bài 10: Xử lý submit tạo đối tượng SinhVien
if (isset($_POST['bai10'])) {
    $sv = new SinhVien(
        $_POST['hoten10'] ?? '',
        $_POST['ngaysinh10'] ?? '',
        $_POST['que10'] ?? '',
        $_POST['lop10'] ?? ''
    );
    $results['bai10'] = $sv;
}

/* ========= Navigation Logic - Xác định bài vừa submit ========= */
$lastBai = '';
foreach ( [
  'bai1'=>'b1','bai2a'=>'b2','bai2b'=>'b2','bai3'=>'b3','bai4_add'=>'b4','bai4_reset'=>'b4','bai5'=>'b5','bai6'=>'b6','bai7'=>'b7','bai8'=>'b8','bai9'=>'b9','bai10'=>'b10'
] as $postName => $sectionId) {
  if (isset($_POST[$postName])) {
    $lastBai = $sectionId;
    break;
  }
}
?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bài tập HTML/CSS/PHP – thực hành cơ bản</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header-banner" style="background:linear-gradient(90deg,#2196f3 60%,#fff 100%);color:#fff;padding:32px 0 18px 0;text-align:center;box-shadow:0 2px 12px rgba(33,150,243,0.08);">
    <div style="font-size:38px;font-weight:900;letter-spacing:1px;line-height:1.1;">
      <span style="vertical-align:middle;">🚀</span> HỌC LẬP TRÌNH WEB HIỆN ĐẠI <span style="vertical-align:middle;">✨</span>
    </div>
    <div style="font-size:18px;font-weight:400;margin-top:8px;opacity:.95;">Khám phá HTML, CSS, PHP, JavaScript và nhiều công nghệ web khác!</div>
  </div>
  
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
      <li><a href="index.php">Trang chủ</a></li>
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
          <li><a href="#b11">Bài 11 – Đăng nhập/Đăng ký</a></li>
        </ul>
      </li>
      <li><a href="gioi-thieu-js.html">JavaScript</a></li>
      <li><a href="gioi-thieu-welscholl.html">W3Schools</a></li>
      <li><a href="hoc-php.html">Học PHP</a></li>
      <li><a href="hoc-css-html.html">Học CSS &amp; HTML</a></li>
      <li><a href="auth.html">Đăng nhập/Đăng ký</a></li>
    </ul>
  </nav>
</header>
<div class="container">
  <aside class="aside">
    <div class="brand" title="Thực hành HTML/CSS/PHP">
      <span>Thực hành</span> HTML/CSS/PHP
      <span class="brand-emoji" style="font-size:22px;">✨</span>
    </div>
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
      <a href="#b11">Bài 11 – Đăng nhập/Đăng ký</a>
    </div>
  </aside>

  <main>
    <h1>Thực hành cơ bản với HTML, CSS, PHP</h1>
    <div class="subtitle">Giao diện gọn nhẹ, mỗi bài là một thẻ thao tác riêng. (Bạn có thể chỉnh màu, font cho khớp mẫu PDF)</div>
    <section id="b1" class="card" style="display:none">
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
    <section id="b2" class="card" style="display:none">
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
    <section id="b3" class="card" style="display:none">
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
    <section id="b4" class="card" style="display:none">
      <header>Bài 4 – Nhập số cho đến khi nhập 0 thì dừng (dùng session)</header>
      <div class="body">
        <form method="post" class="row" id="bai4-form">
          <div>
            <label class="small">Nhập một số (0 để dừng)</label>
            <input type="number" name="bai4_value" id="bai4_value" required autocomplete="off">
          </div>
          <div style="max-width:200px"><button name="bai4_add">Thêm</button></div>
        </form>
        <div class="kq">
          <div class="small">Dãy hiện tại:</div>
          <div><b><?= htmlspecialchars(implode(', ', $_SESSION['bai4'])) ?></b></div>
          <?php if (!empty($_SESSION['bai4_end'])): ?>
            <div class="small">Đã nhập 0: dừng nhận thêm. Nhập số mới để bắt đầu lại.</div>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- Bài 5 -->
    <section id="b5" class="card" style="display:none">
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
    <section id="b6" class="card" style="display:none">
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
    <section id="b7" class="card" style="display:none">
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
    <section id="b8" class="card" style="display:none">
      <header>Bài 8 – Mảng 10 phần tử: đếm âm/dương</header>
      <div class="body">
        <form method="post" class="row" id="bai8-form">
          <div style="flex-basis:100%">
            <label class="small">Nhập 10 số, cách nhau bởi dấu phẩy (để trống sẽ random):</label>
            <input type="text" name="arr8" id="arr8" placeholder="-2,0,3,..." value="">
            <div id="bai8-err" style="color:#d32f2f;font-size:14px;display:none;margin-top:4px"></div>
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
    <section id="b9" class="card" style="display:none">
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
    <section id="b10" class="card" style="display:none">
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
    <section id="b11" class="card" style="display:none">
      <header>Bài 11 – Đăng nhập/Đăng ký</header>
      <div class="body">
        <p>Thực hiện chức năng đăng nhập và đăng ký tài khoản.</p>
        <a href="auth.html" style="display:inline-block;padding:10px 18px;background:var(--accent);color:#fff;border-radius:8px;font-weight:600;text-decoration:none;">Chuyển đến trang Đăng nhập/Đăng ký</a>
      </div>
    </section>

    <hr class="soft">
  </main>
</div>
<script>
function showSection(id) {
  document.querySelectorAll('main .card').forEach(function(sec) {
    sec.style.display = 'none';
  });
  var el = document.getElementById(id);
  if (el) el.style.display = '';
}
window.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.nav a').forEach(function(link) {
    link.addEventListener('click', function(e) {
      var href = link.getAttribute('href');
      if (href && href.startsWith('#b')) {
        e.preventDefault();
        showSection(href.substring(1));
      }
    });
  });
  // Hiển thị đúng bài vừa submit
  var showId = '<?php echo $lastBai ?: "b1"; ?>';
  showSection(showId);
});
window.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.navbar-menu .dropdown-content a').forEach(function(link) {
    link.addEventListener('click', function(e) {
      var href = link.getAttribute('href');
      if (href && href.startsWith('#b')) {
        e.preventDefault();
        showSection(href.substring(1));
      }
    });
  });
});
window.addEventListener('DOMContentLoaded', function() {
  // Bài 4: reset dãy nếu nhập 0
  var bai4Input = document.getElementById('bai4_value');
  if (bai4Input) {
    bai4Input.addEventListener('input', function() {
      if (bai4Input.value === '0') {
        // Gửi form reset qua AJAX hoặc chuyển hướng với tham số reset
        var f = document.createElement('form');
        f.method = 'post';
        f.action = '';
        var inp = document.createElement('input');
        inp.type = 'hidden';
        inp.name = 'bai4_reset';
        inp.value = '1';
        f.appendChild(inp);
        document.body.appendChild(f);
        f.submit();
      }
    });
  }
});
window.addEventListener('DOMContentLoaded', function() {
  // Bài 8: kiểm tra input bằng regex
  var bai8Form = document.getElementById('bai8-form');
  var arr8Input = document.getElementById('arr8');
  var bai8Err = document.getElementById('bai8-err');
  if (bai8Form && arr8Input && bai8Err) {
    bai8Form.addEventListener('submit', function(e) {
      var val = arr8Input.value.trim();
      if (val.length > 0) {
        // Chỉ cho phép: số nguyên, dấu trừ đầu số, dấu phẩy, dấu cách
        var regex = /^\s*-?\d+(\s*,\s*-?\d+)*\s*$/;
        if (!regex.test(val)) {
          bai8Err.textContent = 'Vui lòng nhập đúng định dạng: các số nguyên, cách nhau bởi dấu phẩy. Ví dụ: -2, 0, 3, ...';
          bai8Err.style.display = 'block';
          e.preventDefault();
          return false;
        }
      }
      bai8Err.style.display = 'none';
    });
  }
});
function toggleAside() {
  const aside = document.querySelector('.aside');
  const icon = document.getElementById('aside-icon');
  if (aside) {
    // Desktop: dùng class 'hidden', Mobile: dùng class 'show'
    if (window.innerWidth <= 900) {
      aside.classList.toggle('show');
    } else {
      aside.classList.toggle('hidden');
    }
    
    if (icon) {
      const isHidden = aside.classList.contains('hidden') || !aside.classList.contains('show');
      icon.textContent = (window.innerWidth <= 900) ? 
        (aside.classList.contains('show') ? '✕' : '☰') :
        (aside.classList.contains('hidden') ? '☰' : '✕');
    }
  }
}
</script>
</body>
</html>
