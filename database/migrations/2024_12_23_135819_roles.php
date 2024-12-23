<?php

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

return new class {

    public function up(Builder $schema): void
    {
        $schema->create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 32)->unique();
            $table->string('description', length: 128);
            $table->datetimes();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('roles');
    }
};
