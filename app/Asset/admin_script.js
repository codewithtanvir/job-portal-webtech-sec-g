function showSection(sectionId) {
    const sectionIds = ['overview', 'manageUsers', 'catagories', 'reports', 'notifications', 'activityLogs', 'dataExport'];
    
    sectionIds.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.style.display = (id === sectionId) ? "block" : "none";
        }
    });

    const sidebarItems = document.querySelectorAll('.sidebar ul li');
    sidebarItems.forEach(item => {
        const onclickAttr = item.getAttribute('onclick');
        if (onclickAttr && onclickAttr.includes(`'${sectionId}'`)) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });

    // Save current section to localStorage to persist across refreshes
    localStorage.setItem('currentAdminSection', sectionId);
}

document.addEventListener('DOMContentLoaded', function() {
    // Restore previous section or default to overview
    const savedSection = localStorage.getItem('currentAdminSection') || 'overview';
    showSection(savedSection);

    const logoutBtn = document.querySelector('.logout-btn');
    if (logoutBtn) {
        logoutBtn.onclick = function(e) {
            if (!confirm('Are you sure you want to logout?')) {
                e.preventDefault();
            }
        };
    }
});