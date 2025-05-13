document.addEventListener('DOMContentLoaded', function() {
    const filterSelect = document.getElementById('filterSelect');
    const phoneTableBody = document.getElementById('phoneTableBody');

    if (filterSelect && phoneTableBody) {
        filterSelect.addEventListener('change', function() {
            const selected = this.value;

            if (selected) {
                fetch(`/Phone_CompareSite/scripts/process_filter.php?sort=${selected}`)
                    .then(res => res.text())
                    .then(html => {
                        phoneTableBody.innerHTML = html;
                    })
                    .catch(err => {
                        console.error('Failed to load filtered phones:', err);
                    });
            }
        });
    }
});