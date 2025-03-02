<?php

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

return new class {

    public function up(Builder $schema): void
    {
        $schema->create('settings', function (Blueprint $table) {
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->text('default_value')->nullable();
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('settings');
    }
};
