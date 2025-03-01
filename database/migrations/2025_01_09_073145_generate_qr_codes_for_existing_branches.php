<?php

use App\Models\Branch;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fetch all branches with their restaurant relation that don't have QR codes
        $branches = Branch::with('restaurant')->get()->filter(function ($branch) {
            return is_null($branch->qRCodeUrl);
        });

        info('Generating QR codes for ' . $branches->count() . ' branches');

        try {
            foreach ($branches as $branch) {
                // Generate the QR code only if it doesn't exist
                $branch->generateQrCode();
            }
        } catch (\Exception $e) {
            info('Error generating QR codes: ' . $e->getMessage());
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
