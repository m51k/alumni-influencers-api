function renderNavbar(role) {
    const alumnus = `
        <nav class="bg-white border-b border-gray-200 px-6 py-3 flex items-center space-x-6 text-sm">
            <span class="font-bold text-gray-800 mr-4">Alumni Platform</span>
            <a href="profile.html" class="text-gray-600 hover:text-blue-600 transition">Profile</a>
            <a href="bid.html" class="text-gray-600 hover:text-blue-600 transition">Bidding</a>
            <a href="today.html" class="text-gray-600 hover:text-blue-600 transition">Influencer of the Day</a>
            <a href="#" onclick="logout()" class="ml-auto text-red-500 hover:text-red-700 transition">Logout</a>
        </nav>`;

    const developer = `
        <nav class="bg-white border-b border-gray-200 px-6 py-3 flex items-center space-x-6 text-sm">
            <span class="font-bold text-gray-800 mr-4">Alumni Platform</span>
            <a href="keys.html" class="text-gray-600 hover:text-blue-600 transition">API Keys</a>
            <a href="today.html" class="text-gray-600 hover:text-blue-600 transition">Influencer of the Day</a>
            <a href="#" onclick="logout()" class="ml-auto text-red-500 hover:text-red-700 transition">Logout</a>
        </nav>`;

    document.getElementById('navbar').innerHTML = role === 'developer' ? developer : alumnus;
}

async function logout() {
    await fetch('/index.php/api/v1/auth/logout', {method: 'POST', credentials: 'same-origin'});
    window.location.href = 'login.html';
}

async function initNavbar() {
    const res = await fetch('/index.php/api/v1/auth/role', {credentials: 'same-origin'});
    if (res.status === 401) {
        window.location.href = 'login.html';
        return;
    }
    const data = await res.json();
    if (data.role === 'staff') {
        window.location.href = 'analytics.html';
        return;
    }
    renderNavbar(data.role);
}

initNavbar();