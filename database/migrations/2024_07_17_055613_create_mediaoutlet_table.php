<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mediaoutlet', function (Blueprint $table) {
            $table->integer('gidMediaOutlet_id', true);
            $table->string('gidMediaOutlet', 45)->nullable();
            $table->string('MediaOutlet', 45)->nullable();
            $table->string('ShortName', 45);
            $table->string('gidMediaType', 45)->nullable();
            $table->string('gidPublicationType', 45)->nullable();
            $table->string('gidTier', 45)->nullable();
            $table->string('Masthead', 500)->nullable();
            $table->string('Language', 45)->nullable();
            $table->dateTime('CreatedOn')->nullable();
            $table->string('CreatedBy', 45)->nullable();
            $table->dateTime('UpdatedOn')->nullable();
            $table->string('UpdatedBy', 45)->nullable();
            $table->integer('Status');
            $table->decimal('Priority', 10, 3)->default(0);
            $table->integer('IsCorrected')->nullable()->default(0)->comment('This field is introduced so as to identify which all mediaoutlets along with their details has been corrected.0 means not corrected 1 means corrected');
            $table->integer('MediaOutletCorrections');
            $table->integer('ImpMediaOutlet')->default(0);
            $table->integer('Country')->nullable()->default(77);

            $table->unique(['MediaOutlet', 'gidMediaType'], 'index2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mediaoutlet');
    }
};
