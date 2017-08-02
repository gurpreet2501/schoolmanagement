<?php

use Phinx\Seed\AbstractSeed;

class ImportLabourCategoriesAndPartes extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $partes = [
            ['name' => 'Pathrala'], 
            ['name' => 'Samanta'],
            ['name' => 'Rajendra'],
            ['name' => 'Chatni'],
            ['name' => 'Rafu'],
        ];

        $resp = $this->table('labour_partes')->insert($partes)->save();
        

        $categories = [
            ['name' => 'Paddy Unload'],
            ['name' => 'Paddy Issue'],
            ['name' => 'Rice Load 50kgs'],
            ['name' => 'Finished Product Recipt'],
            ['name' => 'Bags chatni'],
            ['name' => 'Rafu Work'],
            ['name' => 'Rice Load 20-25 kgs'],
            ['name' => 'Bran, Broken etc. load'],
            ['name' => 'Rice bag movement'],
        ];

        $resp = $this->table('labour_job_categories')->insert($categories)->save();
    }
}
