function showSection(section) {
    const sections = ['overview', 'manageUsers', 'manageJobs', 'applications', 'reports', 'notifications', 'activityLogs', 'dataExport'];
    
    sections.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.style.display = "none";
        }
    });

    const target = document.getElementById(section);
    if (target) {
        target.style.display = "block";
    }

    // Update active state in sidebar
    const sidebarItems = document.querySelectorAll('.sidebar ul li');
    sidebarItems.forEach(item => {
        if (item.getAttribute('onclick').includes(`'${section}'`)) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

window.onload = function() {
    showSection('overview');

    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.onclick = function() {
            if (confirm('Are you sure you want to logout?')) {
                alert('Logging out...');
            }
        };
    }
};