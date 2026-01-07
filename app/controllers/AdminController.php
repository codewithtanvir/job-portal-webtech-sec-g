<?php
require_once(__DIR__ . '/../models/userModel.php');

class AdminController
{
    public function getStats()
    {
        return getDashboardStats();
    }
}
