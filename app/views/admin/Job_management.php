<?php
?>
<h3>job Approval System</h3>
<?php if ($success): ?>
    <div class="notice" style="background:#e7f7ee;border-color:#b7ebc6;color:#14532d;">✅ <?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="notice" style="background:#fdecec;border-color:#fecaca;color:#7f1d1d;">❌ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>
<div class="simple-card">
    <h4>Pending Jobs</h4>
    <div class="table-container" style="overflow:auto;">
        <table class="simple-table">
            <thead>
                <tr>
                    <th>Job ID</th>
                    <th>Title</th>
                    <th>employer</th>
                    <th>Location</th>
                    <th>Salary</th>
                    <th>Posted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($jobs) === 0): ?>
                    <tr>
                        <td colspan="7"><em>No pending jobs</em></td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($jobs as $job): ?>
                        <tr>
                            <td><?= htmlspecialchars($job['id']) ?></td>
                            <td><?= htmlspecialchars($job['title']) ?></td>
                            <td><?= htmlspecialchars($job['employer']) ?></td>
                            <td><?= htmlspecialchars($job['location']) ?></td>
                            <td><?= htmlspecialchars($job['salary']) ?></td>
                            <td><?= htmlspecialchars($job['posted']) ?></td>
                            <td>
                                <!-- Actions like Approve or Reject can be added here -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>