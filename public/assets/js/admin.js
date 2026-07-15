$(document).ready(function () {
    initSidebar();
    initDeleteConfirmation();
    initImagePreview();
    initAutoSlug();
    initDynamicSpecs();
    initSearchForm();
    initTooltips();

    setTimeout(function () {
        $('.alert-dismissible').fadeOut(500, function () {
            $(this).remove();
        });
    }, 5000);
});

function initSidebar() {
    $('.sidebar .nav-link').each(function () {
        if ($(this).attr('href') === window.location.pathname) {
            $(this).addClass('active');
            $(this).closest('.nav-item').parents('.collapse').addClass('show');
        }
    });
}

function initDeleteConfirmation() {
    $(document).on('click', '[data-delete]', function (e) {
        e.preventDefault();
        var url = $(this).data('url');
        var message = $(this).data('message') || 'Are you sure you want to delete this item?';
        $('#deleteModal .modal-body p').text(message);
        $('#deleteModal .btn-danger').off('click').on('click', function () {
            $('<form>', {
                method: 'POST',
                action: url,
                style: 'display:none'
            }).append(
                $('<input>', {
                    type: 'hidden',
                    name: '_csrf_token',
                    value: $('meta[name="csrf-token"]').attr('content') || ''
                })
            ).appendTo('body').submit();
        });
        $('#deleteModal').modal('show');
    });
}

function initImagePreview() {
    $(document).on('change', 'input[type="file"][data-preview]', function () {
        var target = $(this).data('preview');
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(target).attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        }
    });
}

function initAutoSlug() {
    $(document).on('input', '[data-slug-source]', function () {
        var target = $(this).data('slug-source');
        var text = $(this).val();
        var slug = text.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        $(target).val(slug);
    });
}

function initDynamicSpecs() {
    $(document).on('click', '.add-spec-row', function () {
        var container = $(this).closest('.specs-container');
        var index = container.find('.specs-row').length;
        var template = container.data('template') || '';
        var newRow = $('<div class="specs-row row g-2 mb-2"> \
            <div class="col-md-5"> \
                <input type="text" name="specs[' + index + '][attribute_name]" class="form-control form-control-sm" placeholder="Attribute Name"> \
            </div> \
            <div class="col-md-5"> \
                <input type="text" name="specs[' + index + '][attribute_value]" class="form-control form-control-sm" placeholder="Attribute Value"> \
            </div> \
            <div class="col-md-2"> \
                <button type="button" class="btn btn-outline-danger btn-sm remove-spec-row"><i class="fas fa-times"></i></button> \
            </div> \
        </div>');
        container.find('.specs-list').append(newRow);
    });

    $(document).on('click', '.remove-spec-row', function () {
        $(this).closest('.specs-row').remove();
    });
}

function initSearchForm() {
    var searchTimeout;
    $(document).on('keyup', '.search-box input', function () {
        var form = $(this).closest('form');
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function () {
            form.submit();
        }, 500);
    });
}

function initTooltips() {
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (el) {
            return new bootstrap.Tooltip(el);
        });
    }
}

function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#' + previewId).attr('src', e.target.result).show();
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function confirmDelete(url, message) {
    if (confirm(message || 'Are you sure?')) {
        $('<form>', {
            method: 'POST',
            action: url,
            style: 'display:none'
        }).append(
            $('<input>', {
                type: 'hidden',
                name: '_csrf_token',
                value: $('meta[name="csrf-token"]').attr('content') || ''
            })
        ).appendTo('body').submit();
    }
    return false;
}
