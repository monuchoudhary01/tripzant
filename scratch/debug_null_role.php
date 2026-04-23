<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::whereNull('role_id')->first();
if ($user) {
    echo "User Email: " . $user->email . "\n";
    echo "User Role String: '" . $user->role . "'\n";
} else {
    echo "No users with null role_id found.\n";
}
