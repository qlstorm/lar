<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::select("
            CREATE TABLE parameters (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title VARCHAR,
                type INTEGER,
                icon VARCHAR,
                icon_gray VARCHAR
            )
        ");
        
        $i = 0;

        while ($i < 20) {
            $rows[] = '(' . implode(', ', [
                rand(100, 1000),
                rand(1, 2)
            ]) . ')';

            $i++;
        }

        $rowsString = implode(', ', $rows);

        DB::select('insert into parameters (title, type) values ' . $rowsString);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::select("drop table parameters");
    }
};
