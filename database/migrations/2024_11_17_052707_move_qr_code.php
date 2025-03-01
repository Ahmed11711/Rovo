<?php

use App\Models\Table;
use App\Scopes\BranchScope;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = Table::withoutGlobalScopes([BranchScope::class])->get();

        // Re-generate QR code for exiting tables for user-uploads folder
        foreach ($tables as $table) {
            try {
                $table->generateQrCode();
            } catch (\Exception $e) {

            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }

};
