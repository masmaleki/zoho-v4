<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('zoho_v3') && ! Schema::hasTable('zoho_v4')) {
            Schema::rename('zoho_v3', 'zoho_v4');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('zoho_v4') && ! Schema::hasTable('zoho_v3')) {
            Schema::rename('zoho_v4', 'zoho_v3');
        }
    }
};
