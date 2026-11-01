<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

$columns = Schema::getColumnListing('news_details');
print_r($columns);

// Check if publication_date exists, if not create it
if (!Schema::hasColumn('news_details', 'publication_date')) {
    Schema::table('news_details', function (Blueprint $table) {
        $table->date('publication_date')->nullable()->after('supplement_id');
    });
    echo "Column publication_date added successfully.\n";
} else {
    echo "Column publication_date already exists.\n";
}
