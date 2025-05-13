document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('search-box'); // Updated ID here
    const results = document.getElementById('search-results');

    input.addEventListener('input', () => {
        const query = input.value.trim();

        if (query.length < 2) {
            results.innerHTML = '';
            return;
        }

        fetch(`/Phone_CompareSite/scripts/process_search.php?q=${encodeURIComponent(query)}`)
        .then(res => res.json())
        .then(data => {
            results.innerHTML = '';
            if (data.length === 0) {
                results.innerHTML = '<div class="list-group-item">No results found</div>';
            } else {
                data.forEach(phone => {
                    const item = document.createElement('a');
                    item.href = `/Phone_CompareSite/phone_comparison_site/phone.php?id=${phone.id}`;
                    item.className = 'list-group-item list-group-item-action';
                    item.textContent = `${phone.manufacturer} ${phone.model}`;
                    results.appendChild(item);
                });
            }
        });

    });

    // Hide dropdown when clicking outside
    document.addEventListener('click', e => {
        if (!results.contains(e.target) && e.target !== input) {
            results.innerHTML = '';
        }
    });
});