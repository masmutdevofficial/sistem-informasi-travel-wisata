<?php 
// Format: Rabu, 20 Maret 2025
function format_hari_tanggal($timestamp) {
    $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $waktu = strtotime($timestamp);
    return $hari[date('w', $waktu)] . ', ' . date('d', $waktu) . ' ' . $bulan[date('n', $waktu) - 1] . ' ' . date('Y', $waktu);
}

// Format: Rabu, 20 Maret 2025 12:00:00 WIB
function format_hari_tanggal_jam($timestamp) {
    return format_hari_tanggal($timestamp) . ' ' . date('H:i:s', strtotime($timestamp)) . ' WIB';
}

// Format: 20 Maret 2025
function format_tanggal_only($timestamp) {
    $bulan = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $waktu = strtotime($timestamp);
    return date('d', $waktu) . ' ' . $bulan[date('n', $waktu) - 1] . ' ' . date('Y', $waktu);
}

// Format: 1 Detik/1 Menit/1 Jam/... Yang Lalu
function waktu_lalu($timestamp) {
    $waktu = time() - strtotime($timestamp);

    if ($waktu < 60) {
        return $waktu . ' Detik Yang Lalu';
    } elseif ($waktu < 3600) {
        return floor($waktu / 60) . ' Menit Yang Lalu';
    } elseif ($waktu < 86400) {
        return floor($waktu / 3600) . ' Jam Yang Lalu';
    } elseif ($waktu < 604800) {
        return floor($waktu / 86400) . ' Hari Yang Lalu';
    } elseif ($waktu < 2592000) {
        return floor($waktu / 604800) . ' Minggu Yang Lalu';
    } elseif ($waktu < 31536000) {
        return floor($waktu / 2592000) . ' Bulan Yang Lalu';
    } else {
        return floor($waktu / 31536000) . ' Tahun Yang Lalu';
    }
}

// Upload file sederhana
function upload_file($file, $target_dir) {
    $filename = time() . '_' . basename($file['name']);
    $target_file = rtrim($target_dir, '/') . '/' . $filename;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return $filename;
    }
    return false;
}

// Hapus file jika ada
function hapus_file($path) {
    if (file_exists($path)) {
        unlink($path);
    }
}

// Filter input dari XSS
function sanitize($string) {
    return htmlspecialchars(strip_tags(trim($string)), ENT_QUOTES, 'UTF-8');
}

// Base URL helper
function base_url($path = '') {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    return $protocol . $host . $dir . '/' . ltrim($path, '/');
}

// Validasi email
function is_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Validasi & normalisasi nomor HP format Indonesia
function format_no_hp($nohp) {
    $nohp = preg_replace('/[^0-9]/', '', $nohp); // hapus karakter non-digit

    if (substr($nohp, 0, 1) === '0') {
        $nohp = '62' . substr($nohp, 1);
    }

    if (preg_match('/^62[0-9]{9,13}$/', $nohp)) {
        return $nohp;
    }

    return false;
}

function generate_captcha_image() {
    $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $captcha_text = '';
    for ($i = 0; $i < 5; $i++) {
        $captcha_text .= $characters[rand(0, strlen($characters) - 1)];
    }
    $_SESSION['captcha'] = $captcha_text;

    header('Content-type: image/png');
    $img = imagecreatetruecolor(120, 40);

    $bg    = imagecolorallocate($img, 255, 255, 255);
    $text  = imagecolorallocate($img, 0, 0, 0);
    $noise = imagecolorallocate($img, 150, 150, 150);

    imagefilledrectangle($img, 0, 0, 120, 40, $bg);

    for ($i = 0; $i < 100; $i++) {
        imagesetpixel($img, rand(0,120), rand(0,40), $noise);
    }

    for ($i = 0; $i < 3; $i++) {
        imageline($img, rand(0,120), rand(0,40), rand(0,120), rand(0,40), $noise);
    }

    imagestring($img, 5, 30, 10, $captcha_text, $text);
    imagepng($img);
    imagedestroy($img);
}

// Menu aktif dinamis berdasarkan URL
function isActive($page) {
  return basename($_SERVER['PHP_SELF']) == $page ? 'active' : '';
}
function isMenuActive(array $pages) {
    return in_array(basename($_SERVER['PHP_SELF']), $pages) ? 'active menu-open' : '';
}
?>