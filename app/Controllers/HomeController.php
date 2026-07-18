<?php
// app/Controllers/HomeController.php

class HomeController
{
    // Hien thi trang chu Dashboard
    public function index(): void
    {
        view('dashboard');
    }
}
