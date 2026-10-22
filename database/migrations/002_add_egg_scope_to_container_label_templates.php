<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('container_label_templates', function (Blueprint $table): void {
            $table->dropUnique('container_label_templates_key_unique');
            $table->index('key', 'container_label_templates_key_index');
        });

        Schema::create('container_label_template_egg', function (Blueprint $table): void {
            $table->unsignedInteger('container_label_template_id');
            $table->unsignedInteger('egg_id');
            $table->primary(['container_label_template_id', 'egg_id']);
            $table->foreign('container_label_template_id')
                ->references('id')
                ->on('container_label_templates')
                ->cascadeOnDelete();
            $table->foreign('egg_id')
                ->references('id')
                ->on('eggs')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('container_label_template_egg');
    }
};