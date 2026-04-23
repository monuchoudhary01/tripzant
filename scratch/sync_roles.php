<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Role;

$users = User::all();
$count = 0;

foreach ($users as $user) {
    $role = Role::where('slug', $user->role)->first();
    if ($role) {
        $user->role_id = $role->id;
        $user->save();
        $count++;
    }
}

echo "Updated $count users with role_id.\n";
