<script id="specsRowTemplate" type="text/template">
    <tr>
        <td>
            <input type="text" class="form-control form-control-sm" name="specs[__INDEX__][attribute_name]" placeholder="Attribute name">
        </td>
        <td>
            <input type="text" class="form-control form-control-sm" name="specs[__INDEX__][attribute_value]" placeholder="Attribute value">
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</script>

<script>
let specIndex = <?= isset($specs) && !empty($specs) ? count($specs) * 1000 : 0 ?>;

function addSpecRow() {
    const tbody = document.getElementById('specsBody');
    const template = document.getElementById('specsRowTemplate');
    const html = template.innerHTML.replace(/__INDEX__/g, specIndex++);
    const tr = document.createElement('tr');
    tr.innerHTML = html;
    tbody.appendChild(tr);
}
</script>
