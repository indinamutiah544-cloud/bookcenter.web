<!-- Penutup container dari header.php -->
</div>

<?php if (isset($_SESSION['user_id']) && isset($koneksi)): 
    $user_id_modal = $_SESSION['user_id'];
    $query_modal = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$user_id_modal'");
    $user_data = mysqli_fetch_assoc($query_modal);
?>
<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0">
                <h5 class="modal-title" id="profileModalLabel"><i class="bi bi-person-lines-fill me-2"></i>Edit Profil</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= (strpos($_SERVER['PHP_SELF'], '/admin/') !== false) ? '../' : '' ?>update_profile.php" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="bi bi-person text-muted"></i></span>
                            <input type="text" name="name" class="form-control border-start-0" value="<?= htmlspecialchars($user_data['name']) ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="bi bi-envelope text-muted"></i></span>
                            <input type="email" class="form-control border-start-0 text-muted" value="<?= htmlspecialchars($user_data['email']) ?>" readonly>
                        </div>
                        <small class="form-text text-muted">Email tidak dapat diubah.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. HP</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="bi bi-telephone text-muted"></i></span>
                            <input type="text" name="phone" class="form-control border-start-0" value="<?= htmlspecialchars($user_data['phone'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent align-items-start pt-2"><i class="bi bi-geo-alt text-muted"></i></span>
                            <textarea name="address" class="form-control border-start-0" rows="2"><?= htmlspecialchars($user_data['address'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-2">
                        <label class="form-label fw-semibold">Ubah Password <small class="text-muted fw-normal">(Opsional)</small></label>
                        <div class="input-group">
                            <span class="input-group-text bg-transparent"><i class="bi bi-lock text-muted"></i></span>
                            <input type="password" name="password" id="profile_password" class="form-control border-start-0 border-end-0" placeholder="Kosongkan jika tidak ingin mengubah">
                            <button class="btn btn-outline-secondary border-start-0 toggle-password-modal" type="button" data-target="#profile_password">
                                <i class="bi bi-eye-slash text-muted"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="update_profile" class="btn btn-primary px-4 fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password-modal').forEach(button => {
        button.addEventListener('click', function() {
            const input = document.querySelector(this.getAttribute('data-target'));
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            }
        });
    });
</script>
<?php endif; ?>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    <p class="mb-0">&copy; <?= date('Y'); ?> Book Store Center. All Rights Reserved.</p>
</footer>

<!-- Bootstrap 5 JS Bundle (Include Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>