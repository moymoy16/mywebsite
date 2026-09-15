// public/assets/js/app.js
async function loadUsers() {
    const res = await fetch('/api/users');
    const users = await res.json();
    // render dynamically...
}