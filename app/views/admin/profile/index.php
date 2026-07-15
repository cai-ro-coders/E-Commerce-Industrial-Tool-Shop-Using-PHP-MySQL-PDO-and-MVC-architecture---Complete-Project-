<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">My Profile</h5>
        <p class="text-muted small mb-0">Manage your account information</p>
    </div>
    <a href="<?= $base_url ?>admin/change-password" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-key me-1"></i>Change Password
    </a>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center p-4">
                <div class="avatar-wrapper mb-3">
                    <?php if (!empty($profile['avatar'])): ?>
                        <img src="<?= $uploads_url . $profile['avatar'] ?>"
                             alt="<?= $profile['name'] ?>"
                             class="rounded-circle img-thumbnail"
                             style="width: 140px; height: 140px; object-fit: cover;"
                             id="avatarPreview">
                    <?php else: ?>
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center"
                             style="width: 140px; height: 140px;"
                             id="avatarPreview">
                            <i class="fas fa-user fa-4x text-secondary"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <h6 class="mb-0"><?= $profile['name'] ?></h6>
                <small class="text-muted"><?= $profile['email'] ?></small>
                <div class="mt-2">
                    <span class="badge bg-<?= $profile['role'] === 'admin' ? 'danger' : 'primary' ?>">
                        <?= ucfirst($profile['role']) ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="<?= $base_url ?>admin/profile" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="<?= $profile['name'] ?>" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="<?= $profile['email'] ?>" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="phone" class="form-label">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" class="form-control" id="phone" name="phone"
                                       value="<?= $profile['phone'] ?? '' ?>" placeholder="+1 (555) 123-4567">
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="avatar" class="form-label">Profile Avatar</label>
                            <input type="file" class="form-control" id="avatar" name="avatar"
                                   accept="image/jpeg,image/png,image/gif,image/webp">
                            <div class="form-text">Allowed: JPG, PNG, GIF, WebP. Max: 2MB.</div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Save Changes
                        </button>
                        <a href="<?= $base_url ?>admin/dashboard" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('avatar')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const preview = document.getElementById('avatarPreview');
            if (preview.tagName === 'IMG') {
                preview.src = ev.target.result;
            } else {
                preview.innerHTML = '<img src="' + ev.target.result + '" class="rounded-circle img-thumbnail" style="width: 140px; height: 140px; object-fit: cover;">';
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
