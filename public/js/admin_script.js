function showSection(sectionId) {
    const sectionIds = ['overview', 'manageUsers', 'categories'];
    for (let i = 0; i < sectionIds.length; i++) {
        let id = sectionIds[i];
        let el = document.getElementById(id); 

        if (el) {
           
            if (id === sectionId) {
                el.style.display = "block";
            } else {
                el.style.display = "none"; 
            }
        }
    }
    const sidebarItems = document.querySelectorAll('.sidebar ul li');
    for (let i = 0; i < sidebarItems.length; i++) {
        let item = sidebarItems[i];
        let onclickAttr = item.getAttribute('onclick'); 
        if (onclickAttr && onclickAttr.includes("'" + sectionId + "'")) {
            item.classList.add('active'); 
        } else {
            item.classList.remove('active'); 
        }
    }
    localStorage.setItem('currentAdminSection', sectionId);
}

document.addEventListener('DOMContentLoaded', function() {
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