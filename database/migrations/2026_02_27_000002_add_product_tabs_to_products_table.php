<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->longText('description_html')->nullable()->after('description');
            $table->json('specs_json')->nullable()->after('description_html');
            $table->json('compat_json')->nullable()->after('specs_json');
            $table->json('docs_json')->nullable()->after('compat_json');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['description_html', 'specs_json', 'compat_json', 'docs_json']);
        });
    }
};
