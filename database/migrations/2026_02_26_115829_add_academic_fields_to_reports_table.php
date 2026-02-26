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
        if (!Schema::hasColumn('reports', 'campus')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->string('campus')->nullable();
            });
        }

        if (!Schema::hasColumn('reports', 'discipline')) {
            Schema::table('reports', function (Blueprint $table) {
                $table->string('discipline')->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            if (Schema::hasColumn('reports', 'campus')) {
                $table->dropColumn('campus');
            }
            if (Schema::hasColumn('reports', 'discipline')) {
                $table->dropColumn('discipline');
            }
        });
    }
};
