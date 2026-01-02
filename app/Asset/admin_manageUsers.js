function validateAddUser(){
    const username = document.getElementById('newUsername').value.trim();
    const email = document.getElementById('newEmail').value.trim();
    const password = document.getElementById('newPassword').value.trim();
    const role = document.getElementById('newRole').value;
    let valid = true;

    document.getElementById('usernameError').textContent = '';
    document.getElementById('emailError').textContent = '';
    document.getElementById('passwordError').textContent = '';
    document.getElementById('roleError').textContent = '';
    if(username === ''){
        document.getElementById('usernameError').textContent = 'Username is required.';
        valid = false;
    }
    if(email === ''){
        document.getElementById('emailError').textContent = 'Email is required.';
        valid = false;
    }
    if(password === ''){
        document.getElementById('passwordError').textContent = 'Password is required.';
        valid = false;
    }
    if(role === ''){
        document.getElementById('roleError').textContent = 'Role is required.';
        valid = false;
    }
    return valid;
}
function handleAddUser(event){
    event.preventDefault();
    if (!validateAddUser()) return false
    const name = document.getElementById('newUsername').value.trim();
    const email = document.getElementById('newEmail').value.trim();
    const password = document.getElementById('newPassword').value.trim();
    const role = document.getElementById('newRole').value;
    const id= Date.now();

    const tbody = document.getElementById('usersTableBody');
    const tr = document.createElement('tr');
    tr.setAttribute('data-id', id);
    tr.innerHTML=`
        <td class="user-name">${name}</td>
        <td class="user-email">${email}</td>
        <td><span class="role-badge ${role.toLowerCase()}">${role}</span></td>
        <td><span class="status-badge active">Active</span></td>
        <td>
            <button class="action-btn edit" onclick="editUser(${id})">Edit</button>
            <button class="action-btn delete" onclick="deleteUser(this, ${id})">Delete</button>
        </td>
    `;

    tbody.appendChild(tr);
    document.getElementById('addUserForm').reset();
    alert('User added successfully!');
    return false;
}
function handleEditUser(event){
    event.preventDefault();
    const id = document.getElementById('editUserId').value;
    const name = document.getElementById('editUsername').value.trim();
    const email = document.getElementById('editEmail').value.trim();
    const role = document.getElementById('editRole').value;
    const row = document.querySelector(`tr[data-id='${id}']`);

    if(row){
        row.querySelector('.user-name').textContent = username;
        row.querySelector('.user-email').textContent = email;
        row.querySelector('.role-badge').textContent = role;
        row.querySelector('.role-badge').className = `role-badge ${role.toLowerCase()}`;
        alert('User updated successfully!');
    }
    closeEditModal();
    alert('User updated successfully!');
    return false;
}