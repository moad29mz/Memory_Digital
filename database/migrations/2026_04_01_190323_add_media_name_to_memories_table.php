<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('memories', function (Blueprint $table) {
            // نضيف فقط media_name لأن media_path و media_type موجودين
            if (!Schema::hasColumn('memories', 'media_name')) {
                $table->string('media_name')->nullable()->after('media_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('memories', function (Blueprint $table) {
            if (Schema::hasColumn('memories', 'media_name')) {
                $table->dropColumn('media_name');
            }
        });
    }
};