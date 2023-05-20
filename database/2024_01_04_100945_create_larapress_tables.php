<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->unique();
            $table->string('label')->default('');
            $table->text('description')->nullable()->default(null);
            $table->boolean('public')->default(false);
            $table->boolean('hierarchical')->default(false);
            $table->boolean('exclude_from_search')->default(false);
            $table->boolean('publicly_queryable')->default(false);
            $table->boolean('show_ui')->default(false);
            $table->boolean('show_in_menu')->default(false);
            $table->boolean('show_in_nav_menus')->default(false);
            $table->boolean('show_in_rest')->default(false);
            $table->string('rest_base', 20)->nullable()->default(null);
            $table->integer('menu_position')->nulable()->default(null);
            $table->string('menu_icon')->default('');
            $table->string('permission')->default('post');
            $table->json('supports')->nullable()->default(null);
            $table->boolean('has_archive')->default(false);
            $table->string('rewrite')->nullable();
            $table->boolean('can_export')->default(true);
            $table->boolean('delete_with_user')->default(true);
            $table->string('_builtin')->default(false);
            $table->timestamps();
        });

        Schema::create('post_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->unique();
            $table->string('label');
            $table->boolean('exclude_from_search')->default(false);
            $table->text('description')->nullable();
            $table->boolean('public')->default(false);
            $table->boolean('internal')->default(false);
            $table->boolean('protected')->default(false);
            $table->boolean('private')->default(false);
            $table->boolean('publicly_queryable')->default(false);
            $table->boolean('show_in_admin_all_list')->default(false);
            $table->boolean('show_in_admin_status_list')->default(false);
            $table->boolean('_builtin')->default(false);
            $table->timestamps();
        });

        Schema::create('post_type_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_type_id')->on('post_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('post_status_id')->on('post_statuses')->cascadeOnUpdate()->cascadeOnDelete();
        });        

        Schema::create('taxonomies', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20)->unique();
            $table->string('label');
            $table->text('description')->nullable();
            $table->boolean('public')->default(true);
            $table->boolean('publicly_queryable')->default(true);
            $table->boolean('hierarchical')->default(false);
            $table->boolean('show_ui')->default(true);
            $table->boolean('show_in_menu')->default(true);
            $table->boolean('show_in_nav_menus')->default(true);
            $table->boolean('show_in_rest')->default(true);
            $table->string('rest_base', 20)->nullable()->default(null);
            $table->boolean('show_tagcloud')->default(true);
            $table->boolean('show_in_quick_edit')->default(true);
            $table->boolean('show_admin_column')->default(false);
            $table->integer('menu_position')->default(0);
            $table->string('menu_icon')->default('bookmark');
            $table->string('permission')->default('term');
            $table->string('rewrite')->nullable()->default(null);
            $table->boolean('has_archive')->default(false);
            $table->boolean('is_multiple')->default(true);
            $table->string('_builtin')->default(false);
        });

        Schema::create('post_type_taxonomy', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_type_id')->on('post_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('taxonomy_id')->on('taxonomies')->cascadeOnUpdate()->cascadeOnDelete();
        });

        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->string('taxonomy_name')->nullable();
            $table->foreign('taxonomy_name')->references('name')->on('taxonomies')->cascadeOnUpdate()->default(null);
            $table->foreignId('parent_id')->on('terms')->cascadeOnUpdate()->nullOnDelete()->nullable();
            $table->integer('menu_order')->default(0);
            $table->timestamps();
        });


        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->on('users')->cascadeOnUpdate()->nullOnDelete()->nullable()->default(null);
            $table->string('title')->nullable()->default(null);
            $table->string('slug')->default('');
            $table->longText('content')->nullable()->default(null);
            $table->string('status');
            $table->foreign('status')->references('name')->on('post_statuses')->cascadeOnUpdate()->default('publish');
            $table->string('type')->nullable();
            $table->foreign('type')->references('name')->on('post_types')->cascadeOnUpdate()->nullOnDelete()->default(null);
            $table->foreignId('parent_id')->on('posts')->cascadeOnUpdate()->nullOnDelete()->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('metas', function (Blueprint $table) {
            $table->id();
            $table->morphs('object');
            $table->string('key')->default('');
            $table->longText('value')->nullable()->default(null);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('attachables', function (Blueprint $table) {
            $table->id();
            $table->morphs('attachable');
            $table->foreignId('media_id')->on('media')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->default('');
            $table->longText('value')->nullable()->default(null);
        });

        Schema::create('relationships', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->morphs('object');
            $table->morphs('related');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relationships');
        Schema::dropIfExists('settings');
        Schema::dropIfExists('attachables');
        Schema::dropIfExists('metas');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('terms');
        Schema::dropIfExists('post_type_taxonomy');
        Schema::dropIfExists('taxonomies');
        Schema::dropIfExists('post_type_status');
        Schema::dropIfExists('post_statuses');
        Schema::dropIfExists('post_types');
    }
};
