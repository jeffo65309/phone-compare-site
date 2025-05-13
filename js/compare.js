// Checks if the first compare box has a phone in it yet
let firstPhoneSelected = null;

// If you pick a phone somewhere else (like search), this sends you over to phone.php and loads it
window.loadPhoneToCompare = function(phoneId, slot = 1) {
    window.location.href = `/Phone_CompareSite/phone_comparison_site/phone.php?compare=${phoneId}&slot=${slot}`;
};

// Only for phone.php: loads a phone straight into one of the compare boxes without moving pages
window.loadCompareSlot = function(phoneId, slot = 1) {
    fetch(`/Phone_CompareSite/scripts/process_compare.php?id=${phoneId}`)
        .then(res => res.json())
        .then(phone => {
            const phoneHtml = `
                <h5>${phone.manufacturer} ${phone.model}</h5>
                <img src="${phone.image}" alt="${phone.model}" style="width:100%; max-height:200px; object-fit:contain;">
                <ul class="list-unstyled">
                    <li><strong>Price:</strong> ${phone.price}</li>
                    <li><strong>OS:</strong> ${phone.os}</li>
                    <li><strong>Battery:</strong> ${phone.battery}</li>
                    <li><strong>Storage:</strong> ${phone.storage}</li>
                    <li><strong>Rating:</strong> ${phone.customer_rating}</li>
                </ul>
            `;

            const targetBox = document.getElementById(`phone${slot}`);
            if (targetBox) {
                targetBox.innerHTML = phoneHtml;
                if (slot === 1) firstPhoneSelected = phone.id;
            }
        });
};

// When page loads, get search working + compare clicks working
document.addEventListener('DOMContentLoaded', () => {
    const searchBox = document.getElementById('search-box');
    const results = document.getElementById('search-results');

      // If search elements aren't there, just skip
    if (!searchBox || !results) return;

    // Listen for typing in the search bar
    searchBox.addEventListener('input', () => {
        const query = searchBox.value.trim();

        // Clear suggestions if the input is empty
        if (query.length === 0) {
            results.innerHTML = '';
            return;
        }

         // Otherwise go fetch some suggestions
        fetch(`/Phone_CompareSite/scripts/process_search.php?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                results.innerHTML = '';

                if (data.length === 0) {
                    results.innerHTML = '<div class="list-group-item">No results found</div>';
                } else {
                    // Loop through suggestions and create clickable options
                    data.forEach(phone => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.className = 'list-group-item list-group-item-action';
                        item.textContent = `${phone.manufacturer} ${phone.model}`;

                       // Clicking a suggestion fills it into compare
                        item.addEventListener('click', (e) => {
                            e.preventDefault();
                            window.loadPhoneToCompare(phone.id);
                            results.innerHTML = '';
                            searchBox.value = '';
                        });

                        results.appendChild(item);
                    });
                }
            });
    });

   
    // When someone clicks a phone from the main carousel or grid
    // If already on phone.php, load directly into compare box. Else, redirect to phone.php
    document.querySelectorAll('.compare-select').forEach(card => {
        card.addEventListener('click', () => {
            const phoneId = card.getAttribute('data-id');

            if (window.location.pathname.includes('phone.php')) {
                const slot = firstPhoneSelected ? 2 : 1;
                loadCompareSlot(phoneId, slot);
            } else {
                loadPhoneToCompare(phoneId);
            }
        });
    });

    // Button to clear out the compare section
    const resetBtn = document.getElementById('resetCompareBtn');
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            const phone1 = document.getElementById('phone1');
            const phone2 = document.getElementById('phone2');

            if (phone1) phone1.innerHTML = '';
            if (phone2) phone2.innerHTML = '';
            firstPhoneSelected = null;
        });
    }
});