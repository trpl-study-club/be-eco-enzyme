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
        Schema::table('about_section_cards', function (Blueprint $table) {
            $table->renameColumn('order', 'steps');
        });

        Schema::table('about_section_cards', function (Blueprint $table) {
            $table->string('icon_name')->nullable()->after('description');
            $table->string('icon_image')->nullable()->after('icon_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_section_cards', function (Blueprint $table) {
            $table->dropColumn(['icon_name', 'icon_image']);
        });

        Schema::table('about_section_cards', function (Blueprint $table) {
            $table->renameColumn('steps', 'order');
        });
    }
};
