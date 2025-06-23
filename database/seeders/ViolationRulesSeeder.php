<?php

namespace Database\Seeders;

use App\Models\ViolationRule;
use Illuminate\Database\Seeder;

class ViolationRulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $violationRules = [
            [
                'code' => 'Pasal 281',
                'description' => 'Setiap pengendara kendaraan bermotor yang tidak memiliki SIM A dan C akan dikenakan sanksi pidana kurungan paling lama 4 bulan atau denda paling banyak Rp1.000.000.',
                'fine_amount' => 1000000,
            ],
            [
                'code' => 'Pasal 291 ayat (1)',
                'description' => 'Setiap pengendara sepeda motor yang tidak mengenakan helm SNI akan dipidana dengan kurungan paling lama 1 bulan atau denda paling banyak Rp250.000.',
                'fine_amount' => 250000,
            ],
            [
                'code' => 'Pasal 292',
                'description' => 'Pengendara sepeda motor yang mengangkut penumpang lebih dari satu orang tanpa kereta samping akan dikenakan pidana kurungan paling lama 1 bulan atau denda paling banyak Rp250.000.',
                'fine_amount' => 250000,
            ],
            [
                'code' => 'Pasal 287 ayat (1)',
                'description' => 'Setiap pengendara yang melanggar rambu perintah atau larangan akan dipidana dengan kurungan paling lama 2 bulan atau denda paling banyak Rp500.000.',
                'fine_amount' => 500000,
            ],
            [
                'code' => 'Pasal 283',
                'description' => 'Setiap orang yang mengemudikan kendaraan bermotor secara tidak wajar dan melakukan kegiatan lain atau dipengaruhi oleh suatu keadaan yang mengakibatkan gangguan konsentrasi dalam mengemudi di jalan, akan dipidana dengan kurungan paling lama 3 bulan atau denda paling banyak Rp750.000.',
                'fine_amount' => 750000,
            ],
        ];

        foreach ($violationRules as $rule) {
            ViolationRule::create($rule);
        }
    }
}
