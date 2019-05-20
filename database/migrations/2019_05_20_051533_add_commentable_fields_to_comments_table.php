<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentableFieldsToCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->string('commentable_type');
            $table->string('commentable_id');
            $table->dropForeign('comments_postId_foreign');
            $table->dropColumn('postId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn(['commentable_type', 'commentable_id']);
            $table->string('postId');
            $table->foreign('postId')->references('id')->on('posts');
        });
    }
}
