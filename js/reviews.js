// reviews.js
// Handles selecting a phone and showing the review form

// Wait until the whole page has loaded first
document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll('.compare-select'); // get all the phones you can click on
    const previewSection = document.getElementById('selected-phone-review'); // main section where the form + selected phone shows
    const phoneCard = document.getElementById('selectedPhoneCard'); // little card that shows what phone you picked
    const phoneIdInput = document.getElementById('selectedPhoneId'); // hidden field in the form to store selected phone ID
    const reviewFormWrapper = document.getElementById('reviewFormWrapper'); // the review form itself
    const recentReviews = document.getElementById('recentReviews'); // area that lists latest reviews (we'll hide this later)

    // Go through each card and set up what happens when you click one
    cards.forEach(card => {
        card.addEventListener('click', function() {
            const phoneId = this.getAttribute('data-id'); // get the ID from the card
            const phoneImage = this.querySelector('img').src; // get the phone image
            const phoneTitle = this.querySelector('.card-title').textContent; // get the phone name/title

           // Load up a little preview showing what phone they picked
            phoneCard.innerHTML = `
                <div class="d-flex align-items-center">
                    <img src="${phoneImage}" alt="${phoneTitle}" class="img-thumbnail me-3" style="width: 100px; height: 100px; object-fit: contain;">
                    <h5 class="mb-0">${phoneTitle}</h5>
                </div>
            `;

           // After picking a phone, fill the hidden ID field, show the form + preview, hide the old reviews list.
            phoneIdInput.value = phoneId;
            if (phoneCard) phoneCard.style.display = 'block';
            if (reviewFormWrapper) reviewFormWrapper.style.display = 'block';          
            if (recentReviews) recentReviews.style.display = 'none';         
            previewSection.scrollIntoView({ behavior: 'smooth' });
        });
    });
});