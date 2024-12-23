<?php

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

return new class {

    public function up(Builder $schema): void
    {
        $schema->create('permission_role', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->restrictOnUpdate()->cascadeOnDelete();
            $table->string('permission', length: 32);
            $table->datetimes();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('permission_role');
    }
};
