<?php

use App\Enums\InvitationGroupType;
use App\Enums\InvitationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('group_type')->comment(implode(',', InvitationGroupType::values()));
            $table->string('status')->default(InvitationStatus::SENT->value)
                ->comment(implode(',', InvitationStatus::values()));
            $table->string('token')->unique();
            $table->timestamp('sent_at')->nullable();
            $table->integer('send_count')->default(0);
            $table->foreignId('invited_by')->nullable()->constrained('users')
                ->onDelete('set null');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamps();
            $table->index(['email', 'group_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
