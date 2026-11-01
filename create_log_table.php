<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

if (!Schema::hasTable('mail_send_logs')) {
    Schema::create('mail_send_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('client_id');
        $table->integer('emails_sent_count')->default(1);
        $table->date('sent_date');
        $table->timestamps();
    });
    echo "Table mail_send_logs created successfully.\n";
} else {
    echo "Table already exists.\n";
}
