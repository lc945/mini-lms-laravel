<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sous_chapitres', function (Blueprint $table) {
            $table->string('lien_ressource')->nullable()->after('contenu');
        });
    }

    public function down(): void
    {
        Schema::table('sous_chapitres', function (Blueprint $table) {
            $table->dropColumn('lien_ressource');
        });
    }
};
