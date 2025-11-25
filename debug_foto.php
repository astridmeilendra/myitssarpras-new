<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$user = App\Models\AppUser::find(7);
if ($user) {
    echo "User ID 7 foto_profile: " . ($user->foto_profile ?? 'NULL') . "\n";
    echo "Is full URL: " . (str_starts_with($user->foto_profile ?? '', 'http') ? 'YES' : 'NO') . "\n";
} else {
    echo "User not found\n";
}
