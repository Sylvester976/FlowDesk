<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                ->constrained('travel_applications')
                ->cascadeOnDelete();
            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->restrictOnDelete();

            // Doc types per travel type:
            // foreign_official: invitation_letter | program | accountant_letter
            //                   | procurement_letter | delegate_list
            // foreign_private:  leave_approval
            // local:            assignment_brief
            $table->string('doc_type');

            $table->string('original_name');   // original filename for display
            $table->string('file_path');       // storage path
            $table->string('mime_type')->nullable();
            $table->unsignedInteger('file_size')->nullable(); // bytes

            // Soft delete only — files never physically removed (audit)
            $table->softDeletes();
            $table->timestamps();

            $table->index(['application_id', 'doc_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_documents');
    }
};
