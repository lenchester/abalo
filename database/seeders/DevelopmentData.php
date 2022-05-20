<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ab_article_has_articlecategory;
use App\Models\ab_articlecategory;
use Illuminate\Database\Seeder;
use App\Models\ab_user;
use App\Models\ab_article;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class DevelopmentData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seed_ab_users();
        $this->seed_ab_articles();
        $this->seed_ab_articlecategory();
        $this->seed_article_has_articlecategory();
    }

    private function seed_ab_articlecategory()
    {
        $csvFile = fopen(base_path("data/articlecategory.csv"), 'r');

        DB::table('ab_articlecategories')->truncate();

        $firstline = true;
        $salt = "DBWT";

        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                if ($data['2'] == 'NULL') {             //ab_parent == NULL
                    ab_articlecategory::create([
                        "id" => $data['0'],
                        "ab_name" => $data['1'],
                    ]);
                } else {
                    ab_articlecategory::create([
                        "id" => $data['0'],
                        "ab_name" => $data['1'],
                        "ab_parent" => $data['2']
                    ]);
                }
            }
            $firstline = false;
        }

        fclose($csvFile);
    }

    private function seed_ab_users()
    {
        $csvFile = fopen(base_path("data/user.csv"), 'r');

        DB::table('ab_users')->truncate();

        $firstline = true;
        $salt = "DBWT";

        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                ab_user::create([
                    "id" => $data['0'],
                    "ab_name" => $data['1'],
                    "ab_password" => sha1($data['2'] . $salt),
                    "ab_mail" => $data['3']
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }

    private function seed_ab_articles()
    {
        $csvFile = fopen(base_path("data/articles.csv"), 'r');

        DB::table('ab_articles')->truncate();

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                $orgDate = $data['5'];
                $newDate = date("Y-m-d H:i:s", strtotime($orgDate));

                ab_article::create([
                    "id" => $data['0'],
                    "ab_name" => $data['1'],
                    "ab_price" => intval($data['2']),
                    "ab_description" => $data['3'],
                    "ab_creator_id" => $data['4'],
                    "ab_createdate" => $newDate
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);
    }

    public function seed_article_has_articlecategory()
    {
        $csvFile = fopen(base_path("data/article_has_articlecategory.csv"), 'r');

        DB::table('ab_article_has_articlecategories')->truncate();

        $firstline = true;

        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            if (!$firstline) {

                ab_article_has_articlecategory::create([
                    "ab_articlecategory_id" => $data['0'],
                    "ab_article_id" => $data['1'],
                ]);
            }
            $firstline = false;
        }
    }
}


    /*
    private function seed_universal($path){
        $csvFile = fopen(base_path("$path"),'r');

        $firstline = true;
        $salt = "DBWT";
        $columnNames = array();


        while (($data = fgetcsv($csvFile, 2000, ";")) !== FALSE) {
            if (!$firstline) {
                foreach ($columnNames as $columnName) {
                    $user = new ab_user();
                    for($i = 0; $i<sizeof($data); $i++) {
                        $user->$columnName = $data["$i"];
                    }
                }

            }
            else {
                foreach ($data as $value) {
                    $columnNames[] = $value;
                }
                $firstline = false;
            }
        }

        fclose($csvFile);
    }
    */

