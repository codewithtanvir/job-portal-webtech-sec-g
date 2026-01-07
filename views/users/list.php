<?php require_once ROOT_PATH . 'views/layouts/header.php'; ?>

<div class="container">
    <div class="card-header mb-4 flex justify-between align-center">
        <div>
            <h1 class="card-title">User Management</h1>
            <p>Manage and monitor all system users</p>
        </div>
    </div>
    
    <?php if(isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <!-- Filters -->
    <div class="card mb-4">
        <form method="GET" action="" class="flex gap-2 align-center">
            <input type="hidden" name="page" value="users">
            
            <div class="form-group" style="flex: 1; margin: 0;">
                <input type="text" name="search" class="form-control" placeholder="Search by username, email, or name" 
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </div>
            
            <div class="form-group" style="margin: 0;">
                <select name="filter" class="form-control">
                    <option value="all">All Users</option>
                    <option value="pending" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'approved') ? 'selected' : ''; ?>>Approved</option>
                    <option value="banned" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'banned') ? 'selected' : ''; ?>>Banned</option>
                    <option value="admin" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'admin') ? 'selected' : ''; ?>>Admins</option>
                    <option value="employer" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'employer') ? 'selected' : ''; ?>>Employers</option>
                    <option value="jobseeker" <?php echo (isset($_GET['filter']) && $_GET['filter'] == 'jobseeker') ? 'selected' : ''; ?>>Job Seekers</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="<?php echo BASE_URL; ?>?page=users" class="btn btn-secondary">Reset</a>
        </form>
    </div>
    
    <!-- Users Table -->
    <div class="card">
        <?php if(empty($users)): ?>
            <p>No users found</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Full Name</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td>
                                <?php
                                $type_class = $user['user_type'] == 'admin' ? 'badge-danger' : 
                                            ($user['user_type'] == 'employer' ? 'badge-info' : 'badge-secondary');
                                ?>
                                <span class="badge <?php echo $type_class; ?>">
                                    <?php echo ucfirst($user['user_type']); ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                $status_class = $user['status'] == 'approved' ? 'badge-success' : 
                                              ($user['status'] == 'pending' ? 'badge-warning' : 'badge-danger');
                                ?>
                                <span class="badge <?php echo $status_class; ?>">
                                    <?php echo ucfirst($user['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <div class="flex gap-1">
                                    <a href="<?php echo BASE_URL; ?>?page=users&action=view&id=<?php echo $user['id']; ?>" 
                                       class="btn btn-sm btn-primary">View</a>
                                    
                                    <?php if($user['status'] == 'pending'): ?>
                                        <a href="<?php echo BASE_URL; ?>?page=users&action=approve&id=<?php echo $user['id']; ?>" 
                                           class="btn btn-sm btn-success" 
                                           data-confirm="Are you sure you want to approve this user?">Approve</a>
                                    <?php endif; ?>
                                    
                                    <?php if($user['status'] != 'banned'): ?>
                                        <a href="<?php echo BASE_URL; ?>?page=users&action=ban&id=<?php echo $user['id']; ?>" 
                                           class="btn btn-sm btn-warning"
                                           data-confirm="Are you sure you want to ban this user?">Ban</a>
                                    <?php else: ?>
                                        <a href="<?php echo BASE_URL; ?>?page=users&action=unban&id=<?php echo $user['id']; ?>" 
                                           class="btn btn-sm btn-success"
                                           data-confirm="Are you sure you want to unban this user?">Unban</a>
                                    <?php endif; ?>
                                    
                                    <?php if($user['id'] != $_SESSION['user_id']): ?>
                                        <a href="<?php echo BASE_URL; ?>?page=users&action=delete&id=<?php echo $user['id']; ?>" 
                                           class="btn btn-sm btn-danger"
                                           data-confirm="Are you sure you want to delete this user? This action cannot be undone.">Delete</a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<?php require_once ROOT_PATH . 'views/layouts/footer.php'; ?>
