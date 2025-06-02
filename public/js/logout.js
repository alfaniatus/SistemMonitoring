function toggleLogoutDropdown() {
    const dropdown = document.getElementById('logoutDropdown');
    dropdown.classList.toggle('hidden');
}

document.addEventListener('click', function (event) {
    const dropdown = document.getElementById('logoutDropdown');
    const button = event.target.closest('button');

    if (!event.target.closest('#logoutDropdown') && !button?.innerText.includes('Hai')) {
        dropdown.classList.add('hidden');
    }
});
