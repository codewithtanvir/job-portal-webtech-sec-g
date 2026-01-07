<h3>Category Management</h3>
<div class="manage-users-grid">
    <div class="add-user-card">
        <h4>Add Category</h4>
        <form id="addCategoryForm" action="" method="POST">
            <input type="hidden" name="action" value="createCategory">
            <div class="input-group">
                <label for="name">Category Name:</label>
                <input type="text" id="name" name="name" required placeholder="Enter category name">
            </div>
            <button class="submit-btn" type="submit">Add Category</button>
        </form>
    </div>

    <div class="user-list-card">
        <h4>Existing Categories</h4>
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="categoryTableBody">
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="3">No categories found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($categories as $cat): ?>
                        <tr id="category-row-<?php echo $cat['id']; ?>">
                            <td><?php echo $cat['id']; ?></td>
                            <td><?php echo htmlspecialchars($cat['name']); ?></td>
                            <td>
                                <button type="button" class="action-btn delete" onclick="deleteCategoryAjax(<?php echo $cat['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>