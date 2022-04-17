<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER tg_idBarang
            BEFORE INSERT ON asets FOR EACH ROW
            BEGIN
                DECLARE tempKode VARCHAR(15);
                DECLARE tempCount INT DEFAULT 0;
                DECLARE i INT DEFAULT 1;

                SET tempKode := CONCAT(NEW.id_aset, NEW.id_kategori);
                SELECT COUNT(id_aset) INTO tempCount FROM asets WHERE LEFT(id_aset,6) = tempKode;
                SELECT LENGTH(tempCount) INTO i;

                loopnol: WHILE i < 4 DO
                    SET tempKode = CONCAT(tempKode, "0");
                    SET i = i+1;
                END WHILE loopnol;
                SET tempKode =  CONCAT(tempKode, tempCount+1);

                SET NEW.id_aset = tempKode;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tg_idBarang`');
    }
}
