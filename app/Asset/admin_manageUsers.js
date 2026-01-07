function deleteUser(btn, id) {
    if (confirm('Are you sure you want to delete this user?')) {
        const formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);

        fetch('../../controllers/userController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === 'success') {
                const row = btn.closest('tr');
                row.remove();
                alert('User deleted successfully!');
            } else {
                alert('Failed to delete user.');
            }
        });
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

        fetch('../../controllers/userController.php', {
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
