<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP FUNCTION IF EXISTS getNextCustomSeq');
        DB::unprepared('
        CREATE FUNCTION getNextCustomSeq
        (
            sSeqName VARCHAR(50),
            sSeqGroup VARCHAR(50)
        ) RETURNS VARCHAR(50)
        BEGIN
            DECLARE nLast_val BIGINT;
            SET nLast_val =  (SELECT seq_val
                                FROM _sequence
                                WHERE seq_name = sSeqName
                                        AND seq_group = sSeqGroup);
            IF nLast_val IS NULL THEN
                SET nLast_val = 10000;
                INSERT INTO _sequence (seq_name,seq_group,seq_val)
                VALUES (sSeqName,sSeqGroup,nLast_Val);
            ELSE
                SET nLast_val = nLast_val + 1;
                UPDATE _sequence SET seq_val = nLast_val
                WHERE seq_name = sSeqName AND seq_group = sSeqGroup;
            END IF;
            SET @ret = (SELECT concat(sSeqGroup,nLast_val));
            RETURN @ret;
        END
        ');

        DB::unprepared('
        CREATE TRIGGER staff_auto BEFORE INSERT ON users
        FOR each ROW
        BEGIN
           SET NEW.id = getNextCustomSeq("user","BKS");
        END
        ');

        DB::unprepared('
        CREATE TRIGGER student_auto BEFORE INSERT ON students
        FOR each ROW
        BEGIN
           SET NEW.id = getNextCustomSeq("student","BKC");
        END
        ');
        DB::unprepared('
        CREATE TRIGGER room_auto BEFORE INSERT ON classes
        FOR each ROW
        BEGIN
           SET NEW.id = getNextCustomSeq("room","C");
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
        //
    }
}
