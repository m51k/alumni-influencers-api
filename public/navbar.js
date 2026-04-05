function renderNavbar(role) {
    const alumnus = `
        <nav>
            <a href="profile.html">Profile</a> |
            <a href="bid.html">Bidding</a> |
            <a href="today.html">Influencer of the Day</a> |
            <a href="#" onclick="logout()">Logout</a>
        </nav>`;

    const developer = `
        <nav>
            <a href="keys.html">API Keys</a> |
            <a href="today.html">Influencer of the Day</a> |
            <a href="#" onclick="logout()">Logout</a>
        </nav>`;

    document.getElementById('navbar').innerHTML = role === 'developer' ? developer : alumnus;
}

async function logout() {
    await fetch('/index.php/api/v1/auth/logout', {method: 'POST', credentials: 'same-origin'});
    window.location.href = 'login.html';
}

async function initNavbar() {
    const res = await fetch('/index.php/api/v1/alumnus/profile', {credentials: 'same-origin'});
    if (res.status === 401) {
        window.location.href = 'login.html';
        return;
    }
    if (res.status === 403) {
        renderNavbar('developer');
    } else {
        renderNavbar('alumnus');
    }
}

initNavbar();