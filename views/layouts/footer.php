    </main>
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved.</p>
        </div>
    </footer>

    <script src="<?php echo BASE_URL; ?>public/js/main.js"></script>
    <?php if (isset($extra_js)): ?>
        <?php foreach ($extra_js as $js): ?>
            <script src="<?php echo BASE_URL . $js; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    </body>

    </html>
