<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h5 class="mb-1">Settings</h5>
        <p class="text-muted small mb-0">Manage your application settings</p>
    </div>
</div>

<form action="<?= $base_url ?>admin/settings/update" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <ul class="nav nav-tabs mb-4" id="settingsTabs" role="tablist">
        <?php $first = true; $groupLabels = ['general' => 'General Settings', 'payment' => 'Payment Settings']; ?>
        <?php foreach ($groups as $group => $items): ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= $first ? 'active' : '' ?>"
                        id="<?= $group ?>-tab"
                        data-bs-toggle="tab"
                        data-bs-target="#<?= $group ?>"
                        type="button" role="tab">
                    <i class="fas fa-<?= $group === 'general' ? 'cog' : 'credit-card' ?> me-2"></i>
                    <?= $groupLabels[$group] ?? ucfirst($group) ?>
                </button>
            </li>
            <?php $first = false; ?>
        <?php endforeach; ?>
    </ul>

    <div class="tab-content" id="settingsTabsContent">
        <?php $first = true; ?>
        <?php foreach ($groups as $group => $items): ?>
            <div class="tab-pane fade <?= $first ? 'show active' : '' ?>"
                 id="<?= $group ?>"
                 role="tabpanel">

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <?php foreach ($items as $setting): ?>
                            <?php
                                $label = ucwords(str_replace('_', ' ', $setting['key']));
                                $key = $setting['key'];
                                $val = sanitize($setting['value'] ?? '');
                            ?>

                            <?php if ($key === 'site_logo'): ?>
                                <div class="mb-3">
                                    <label class="form-label">Site Logo</label>
                                    <?php if (!empty($val)): ?>
                                        <div class="mb-2">
                                            <img src="<?= $uploads_url . $val ?>"
                                                 alt="Site Logo"
                                                 class="rounded border"
                                                 style="max-width: 200px; max-height: 80px; object-fit: contain;">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control" name="site_logo" accept="image/*">
                                    <div class="form-text">Leave empty to keep current logo.</div>
                                </div>

                            <?php elseif ($key === 'currency'): ?>
                                <div class="mb-3">
                                    <label for="settings_<?= $key ?>" class="form-label"><?= $label ?></label>
                                    <select class="form-select" id="settings_<?= $key ?>" name="settings[<?= $key ?>]">
                                        <?php foreach (['USD' => 'USD ($)', 'EUR' => 'EUR (€)', 'GBP' => 'GBP (£)', 'CAD' => 'CAD (CA$)'] as $code => $display): ?>
                                            <option value="<?= $code ?>" <?= $val === $code ? 'selected' : '' ?>><?= $display ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            <?php elseif (strpos($key, 'secret') !== false || strpos($key, 'stripe_secret') !== false): ?>
                                <div class="mb-3">
                                    <label for="settings_<?= $key ?>" class="form-label"><?= $label ?></label>
                                    <input type="password" class="form-control" id="settings_<?= $key ?>" name="settings[<?= $key ?>]" value="<?= $val ?>">
                                </div>

                            <?php elseif (strpos($key, 'email') !== false): ?>
                                <div class="mb-3">
                                    <label for="settings_<?= $key ?>" class="form-label"><?= $label ?></label>
                                    <input type="email" class="form-control" id="settings_<?= $key ?>" name="settings[<?= $key ?>]" value="<?= $val ?>">
                                </div>

                            <?php elseif (in_array($key, ['tax_rate', 'shipping_fee'])): ?>
                                <div class="mb-3">
                                    <label for="settings_<?= $key ?>" class="form-label"><?= $label ?></label>
                                    <input type="number" step="any" class="form-control" id="settings_<?= $key ?>" name="settings[<?= $key ?>]" value="<?= $val ?>">
                                </div>

                            <?php else: ?>
                                <div class="mb-3">
                                    <label for="settings_<?= $key ?>" class="form-label"><?= $label ?></label>
                                    <input type="text" class="form-control" id="settings_<?= $key ?>" name="settings[<?= $key ?>]" value="<?= $val ?>">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php $first = false; ?>
        <?php endforeach; ?>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Save Settings
        </button>
    </div>
</form>
