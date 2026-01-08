
document.addEventListener('DOMContentLoaded', function() {
    var addUserForm = document.getElementById('addUserForm');
    
    if (addUserForm) {
        addUserForm.onsubmit = function(event) {
            event.preventDefault(); 

            var formData = new FormData(addUserForm); 
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText.trim() === 'success') {
                        var username = formData.get('newUsername');
                        var email = formData.get('newEmail');
                        var role = formData.get('newRole');
                        
                        var tableBody = document.getElementById('usersTableBody');
                        var newRow = tableBody.insertRow(); 
                        var roleText = (role === 'seeker') ? 'Job Seeker' : role.charAt(0).toUpperCase() + role.slice(1);

                        newRow.innerHTML = 
                            '<td class="user-name">' + username + '</td>' +
                            '<td class="user-email">' + email + '</td>' +
                            '<td><span class="role-badge ' + role + '">' + roleText + '</span></td>' +
                            '<td><span class="status-badge active">Verified</span></td>' +
                            '<td>' +
                                '<button class="action-btn edit" onclick="alert(\'Please refresh to edit newly added user\')">Edit</button>' +
                                '<button class="action-btn delete" onclick="deleteUser(this, 0)">Delete</button>' +
                            '</td>';

                        updateDashboardStats('add', role);
                        
                        addUserForm.reset(); 
                        alert('User added successfully!');
                    } else {
                        alert('Error: ' + this.responseText);
                    }
                }
            };

            xhttp.open("POST", "../controllers/AdminUserController.php", true);
            xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
            xhttp.send(formData);
        };
    }
});

function deleteUser(btn, id) {
    if (confirm('Are you sure you want to delete this user?')) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (this.responseText.trim() === 'success') {
                    var row = btn.parentNode.parentNode;
                    var roleBadge = row.querySelector('.role-badge');
                    var role = ""; 


                    if (roleBadge) {
                        role = roleBadge.textContent.toLowerCase(); 
                    }

                    row.parentNode.removeChild(row);
                    updateDashboardStats('delete', role);

                    alert('User deleted successfully!');
                } else {
                    alert('Failed to delete user.');
                }
            }
        };
        xhttp.open("POST", "../controllers/AdminUserController.php", true);             
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("action=delete&id=" + id);
    }
}
function editUser(id) {
    const row = document.querySelector(`tr[data-id="${id}"]`);
    if (!row) return;
    
    const name = row.querySelector('.user-name').textContent;
    const email = row.querySelector('.user-email').textContent;
    const role = row.querySelector('.role-badge').textContent;

    const newName = prompt('Edit Name:', name);
    const newEmail = prompt('Edit Email:', email);
    const newRole = prompt('Edit Role (admin, employer, seeker):', role.toLowerCase());

    if (newName && newEmail && newRole) {
        const formData = new FormData();
        formData.append('action', 'edit');
        formData.append('id', id);
        formData.append('username', newName);
        formData.append('email', newEmail);
        formData.append('role', newRole);
        fetch('../controllers/AdminUserController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === 'success') {
                row.querySelector('.user-name').textContent = newName;
                row.querySelector('.user-email').textContent = newEmail;
                const roleBadge = row.querySelector('.role-badge');
                roleBadge.textContent = newRole.charAt(0).toUpperCase() + newRole.slice(1);
                roleBadge.className = `role-badge ${newRole.toLowerCase()}`;
                alert('User updated successfully!');
            } else {
                alert('Failed to update user.');
            }
        });
    }
}
function updateDashboardStats(action, role) {
    var totalUsersEl = document.getElementById('totalUsersCount');
    var totalEmployersEl = document.getElementById('totalEmployersCount');

    if (totalUsersEl) {
        var currentTotal = parseInt(totalUsersEl.textContent);
        if (action === 'delete') {
            totalUsersEl.textContent = currentTotal - 1;
        } else if (action === 'add') {
            totalUsersEl.textContent = currentTotal + 1;
        }
    }
    if (role === 'employer' && totalEmployersEl) {
        var currentEmployers = parseInt(totalEmployersEl.textContent);
        if (action === 'delete') {
            totalEmployersEl.textContent = currentEmployers - 1;
        } else if (action === 'add') {
            totalEmployersEl.textContent = currentEmployers + 1;
        }
    }
}
