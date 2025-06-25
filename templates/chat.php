<?php
$title = 'CRUD ADMIN';

$customCss = '

';

$customJs = '

';
?>

<?php include '../includes/admin_header.php' ?>

  <!-- Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Chat</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Chat</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <!-- Konten Chat -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- Sidebar List User -->
        <div class="col-md-4">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title">Daftar Kontak</h3>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column" id="contactList">
                <li class="nav-item">
                  <a href="#" class="nav-link active">
                    <img src="../assets/img/avatar.png" alt="User" class="img-size-32 mr-2 img-circle">
                    Imam Nur Muttaqin
                    <span class="float-right text-sm text-muted">Online</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link">
                    <img src="../assets/img/avatar.png" alt="User" class="img-size-32 mr-2 img-circle">
                    Fikri Alif
                    <span class="float-right text-sm text-muted">Offline</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Chat Area -->
        <div class="col-md-8">
          <div class="card card-primary card-outline">
          <div class="card-header">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <h3 class="card-title mb-0">Obrolan</h3>

                <div class="dropdown">
                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownChatAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Pilihan
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownChatAction">
                    <a class="dropdown-item" href="https://wa.me/6281234567890" target="_blank">
                        <i class="fab fa-whatsapp mr-2"></i> Whatsapp
                    </a>
                    <a class="dropdown-item text-danger" href="#" id="clearChat">
                        <i class="fas fa-trash-alt mr-2"></i> Bersihkan
                    </a>
                    </div>
                </div>
            </div>
            </div>
            <div class="card-body" style="height: 400px; overflow-y: auto;" id="chatArea">
              <!-- Chat Bubbles -->
              <div class="direct-chat-messages">
                <div class="direct-chat-msg">
                  <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">Imam</span>
                    <span class="direct-chat-timestamp float-right">Hari ini, 10:00</span>
                  </div>
                  <img class="direct-chat-img" src="../assets/img/avatar.png" alt="User Image">
                  <div class="direct-chat-text">
                    Halo, ada yang bisa saya bantu?
                  </div>
                </div>

                <div class="direct-chat-msg right">
                  <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-right">Fikri</span>
                    <span class="direct-chat-timestamp float-left">Hari ini, 10:01</span>
                  </div>
                  <img class="direct-chat-img" src="../assets/img/avatar.png" alt="User Image">
                  <div class="direct-chat-text">
                    Ya kak, saya mau tanya soal pesanan.
                  </div>
                </div>
              </div>
            </div>

            <!-- Form Input Chat -->
            <div class="card-footer">
              <form action="#" method="post" id="chatForm">
                <div class="input-group">
                  <input type="text" name="message" placeholder="Ketik pesan..." class="form-control" id="messageInput">
                  <span class="input-group-append">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                  </span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php
$bodyJs = <<<'EOD'
<script>
$(document).on('click', '#clearChat', function (e) {
  e.preventDefault();
  if (confirm('Apakah Anda yakin ingin menghapus semua obrolan?')) {
    $('#chatArea .direct-chat-messages').empty();
  }
});
</script>

EOD;

?>
<?php include '../includes/admin_footer.php' ?>