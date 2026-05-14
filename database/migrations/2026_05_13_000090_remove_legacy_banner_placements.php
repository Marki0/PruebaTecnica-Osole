<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Los heroes de sección usan placement fijos (section_*).
 * Se eliminan filas antiguas hero/home/promo para evitar duplicados al sembrar de nuevo.
 */
class RemoveLegacyBannerPlacements extends Migration
{
    public function up(): void
    {
        DB::table('banners')->whereIn('placement', ['hero', 'home', 'promo'])->delete();
    }

    public function down(): void
    {
        //
    }
}
