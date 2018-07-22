<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Carbon\Carbon;

class UserCSVSeeder extends Seeder
{

    private $table;
    private $csv_path;

    public function __construct()
    {
      $this->table = 'users';
      $this->csv_path = 'database/fixtures/user_data.csv';
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table($this->table)->delete();
      $csv = Reader::createFromPath($this->csv_path)->setHeaderOffset(0);
      $now = Carbon::now()->toDateTimeString();
      foreach ($csv as $record) {
          DB::table($this->table)->insert([
            'first_name'  =>$record['first_name'],
            'last_name'   =>$record['last_name'],
            'email'       =>$record['email'],
            'gender'      =>$record['gender'],
            'ip_address'  =>$record['ip_address'],
            'created_at'  =>$now,
            'updated_at'  =>$now
          ]);
      }
    }

}
