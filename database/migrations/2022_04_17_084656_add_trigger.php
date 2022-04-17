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

        DB::unprepared('
            CREATE TRIGGER tg_history
            BEFORE UPDATE ON asets FOR EACH ROW
            BEGIN
                INSERT INTO histories(id_pemindah, id_aset, lokasi_lama, lokasi_baru, keterangan, deleted_at, created_at, updated_at) VALUES
                (NEW.edited_by, OLD.id_aset, CONCAT(OLD.gedung,", ", OLD.ruangan), CONCAT(NEW.gedung, ", ", NEW.ruangan), NEW.keterangan, NULL, now(), now());
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
        DB::unprepared('DROP TRIGGER `tg_history`');
    }
}
