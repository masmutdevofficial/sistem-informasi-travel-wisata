    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>
            Copyright &copy; <?php echo date("Y"); ?>
            <a href="https://adminlte.io"><?php echo $title ?? '' ?></a>.
        </strong> All rights reserved.
    </footer>

        <!-- Modal Konfirmasi Logout -->
        <div class="modal fade" id="modalLogout" tabindex="-1" aria-labelledby="modalLogoutLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="../auth/logout.php" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLogoutLabel">Konfirmasi Logout</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        Apakah kamu yakin ingin logout dari sistem?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Logout</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="../assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/js/adminlte.min.js"></script>

    <!-- CUSTOM SCRIPT -->
    <?php echo $customJs ?? '' ?>
    <?php echo $bodyJs ?? '' ?>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('liveToast');
            if (toast) {
                toast.classList.remove('show');
                toast.classList.add('fade');
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
    </script>

    </body>

    </html>