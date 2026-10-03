<?php
require __DIR__ . '/includes/config.php';
require __DIR__ . '/includes/database.php';

if (is_learner_logged_in()) {
    redirect('/dashboard.php');
}

redirect('/index.php');
