<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('systems', function (Blueprint $table) {
            // Composite Primary Key (tanpa "id")
            $table->string('system_type');
            $table->string('system_sub_type');
            $table->string('system_cd');

            $table->string('value');
            $table->text('remark')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->string('created_by')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->string('updated_by')->nullable();

            $table->primary(['system_type', 'system_sub_type', 'system_cd']);
        });

        // Seed awal
        DB::table('systems')->insert([
            [
                'system_type' => 'combo',
                'system_sub_type' => 'role',
                'system_cd' => '1',
                'value' => 'Polantas',
                'remark' => null,
                'created_by' => 'migrate',
                'updated_at' => null,
                'updated_by' => null,
            ],
            [
                'system_type' => 'combo',
                'system_sub_type' => 'role',
                'system_cd' => '2',
                'value' => 'Pelapor',
                'remark' => null,
                'created_by' => 'migrate',
                'updated_at' => null,
                'updated_by' => null,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('systems');
    }
}


