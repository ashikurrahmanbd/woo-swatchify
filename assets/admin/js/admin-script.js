jQuery(document).ready(function ($) {
    // Append a custom input field after the slug field in the attributes table
    $('#attributes-table tbody tr').each(function () {
        const $slugRow = $(this).find('.slug');

        // Check if the row contains the slug field
        if ($slugRow.length) {
            // Add the custom input field
            const customInputField = `
                <td class="custom-field">
                    <label for="custom_field">
                        <strong>Custom Field</strong>
                    </label>
                    <input type="text" name="custom_field[]" class="custom-field-input" placeholder="Enter custom data" />
                </td>
            `;

            // Append it to the row
            $slugRow.after(customInputField);
        }
    });
});