function confirmDelete() {
    return confirm("Are you sure you want to delete this category?");
}
document.addEventListener('DOMContentLoaded', function () {
    const addCategoryForm = document.getElementById('addCategoryForm');
    if (addCategoryForm) {
        addCategoryForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const categoryName = formData.get('name');

            fetch('', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const tableBody = document.getElementById('categoryTableBody');
                        const noDataRow = tableBody.querySelector('tr td[colspan="3"]');
                        if (noDataRow) {
                            tableBody.innerHTML = '';
                        }

                        const newRow = `
                        <tr id="category-row-${data.id}">
                            <td>${data.id}</td>
                            <td>${data.name}</td>
                            <td>
                                <button type="button" class="action-btn delete" onclick="deleteCategoryAjax(${data.id})">Delete</button>
                            </td>
                        </tr>`;
                        tableBody.insertAdjacentHTML('beforeend', newRow);
                        addCategoryForm.reset();
                    } else {
                        alert(data.message || 'Error adding category');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    }
});

function deleteCategoryAjax(id) {
    if (!confirmDelete()) return;

    const formData = new FormData();
    formData.append('action', 'deleteCategory');
    formData.append('id', id);

    fetch('', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const row = document.getElementById(`category-row-${id}`);
                if (row) {
                    row.remove();
                }
                const tableBody = document.getElementById('categoryTableBody');
                if (tableBody.children.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="3">No categories found.</td></tr>';
                }
            } else {
                alert(data.message || 'Error deleting category');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
}
