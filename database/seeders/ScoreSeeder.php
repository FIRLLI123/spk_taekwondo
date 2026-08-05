<?php

namespace Database\Seeders;

use App\Models\Athlete;
use App\Models\Criterion;
use App\Models\Period;
use App\Models\Score;
use App\Models\User;
use Illuminate\Database\Seeder;

class ScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Ensure the 5 criteria exist in the database
        $criteriaData = [
            'C1' => ['name' => 'Sikap', 'weight' => 0.20, 'attribute' => 'benefit', 'description' => 'Kriteria Sikap'],
            'C2' => ['name' => 'Fisik', 'weight' => 0.20, 'attribute' => 'benefit', 'description' => 'Kriteria Fisik'],
            'C3' => ['name' => 'Teknik', 'weight' => 0.20, 'attribute' => 'benefit', 'description' => 'Kriteria Teknik'],
            'C4' => ['name' => 'Prestasi', 'weight' => 0.20, 'attribute' => 'benefit', 'description' => 'Kriteria Prestasi'],
            'C5' => ['name' => 'Disiplin', 'weight' => 0.20, 'attribute' => 'benefit', 'description' => 'Kriteria Disiplin'],
        ];

        $criteria = [];
        foreach ($criteriaData as $code => $data) {
            $criteria[$code] = Criterion::updateOrCreate(
                ['code' => $code],
                [
                    'name' => $data['name'],
                    'weight' => $data['weight'],
                    'attribute' => $data['attribute'],
                    'description' => $data['description'],
                ]
            );
        }

        // 2. Get active period or create a default one
        $period = Period::where('status', 'aktif')->first() 
            ?? Period::where('status', 'selesai')->first()
            ?? Period::first()
            ?? Period::create([
                'name' => 'Semester 1 2026',
                'start_date' => '2026-01-01',
                'end_date' => '2026-06-30',
                'status' => 'aktif',
            ]);

        // 3. Get coach / user to associate with the scores
        $user = User::where('role', 'pelatih')->first()
            ?? User::where('role', 'admin')->first()
            ?? User::first();

        if (!$user) {
            $this->command->error('Tidak ada user/pelatih ditemukan di database. Silakan jalankan DemoDataSeeder terlebih dahulu.');
            return;
        }

        // 4. Data Nilai Atlet A001 s.d A140
        $scoresData = [
            'A001' => ['Sikap' => 80, 'Fisik' => 70, 'Teknik' => 94, 'Prestasi' => 84, 'Disiplin' => 74],
            'A002' => ['Sikap' => 85, 'Fisik' => 84, 'Teknik' => 61, 'Prestasi' => 73, 'Disiplin' => 81],
            'A003' => ['Sikap' => 80, 'Fisik' => 96, 'Teknik' => 77, 'Prestasi' => 98, 'Disiplin' => 66],
            'A004' => ['Sikap' => 80, 'Fisik' => 92, 'Teknik' => 86, 'Prestasi' => 85, 'Disiplin' => 85],
            'A005' => ['Sikap' => 85, 'Fisik' => 68, 'Teknik' => 71, 'Prestasi' => 64, 'Disiplin' => 79],
            'A006' => ['Sikap' => 85, 'Fisik' => 64, 'Teknik' => 100, 'Prestasi' => 61, 'Disiplin' => 65],
            'A007' => ['Sikap' => 85, 'Fisik' => 97, 'Teknik' => 83, 'Prestasi' => 87, 'Disiplin' => 67],
            'A008' => ['Sikap' => 85, 'Fisik' => 86, 'Teknik' => 74, 'Prestasi' => 96, 'Disiplin' => 99],
            'A009' => ['Sikap' => 85, 'Fisik' => 97, 'Teknik' => 78, 'Prestasi' => 83, 'Disiplin' => 100],
            'A010' => ['Sikap' => 85, 'Fisik' => 92, 'Teknik' => 90, 'Prestasi' => 100, 'Disiplin' => 79],
            'A011' => ['Sikap' => 85, 'Fisik' => 64, 'Teknik' => 99, 'Prestasi' => 91, 'Disiplin' => 72],
            'A012' => ['Sikap' => 85, 'Fisik' => 65, 'Teknik' => 95, 'Prestasi' => 86, 'Disiplin' => 66],
            'A013' => ['Sikap' => 85, 'Fisik' => 90, 'Teknik' => 84, 'Prestasi' => 73, 'Disiplin' => 62],
            'A014' => ['Sikap' => 85, 'Fisik' => 83, 'Teknik' => 69, 'Prestasi' => 83, 'Disiplin' => 74],
            'A015' => ['Sikap' => 85, 'Fisik' => 98, 'Teknik' => 94, 'Prestasi' => 64, 'Disiplin' => 66],
            'A016' => ['Sikap' => 85, 'Fisik' => 60, 'Teknik' => 68, 'Prestasi' => 79, 'Disiplin' => 68],
            'A017' => ['Sikap' => 85, 'Fisik' => 61, 'Teknik' => 76, 'Prestasi' => 81, 'Disiplin' => 96],
            'A018' => ['Sikap' => 85, 'Fisik' => 86, 'Teknik' => 76, 'Prestasi' => 84, 'Disiplin' => 87],
            'A019' => ['Sikap' => 85, 'Fisik' => 100, 'Teknik' => 73, 'Prestasi' => 75, 'Disiplin' => 62],
            'A020' => ['Sikap' => 85, 'Fisik' => 82, 'Teknik' => 78, 'Prestasi' => 95, 'Disiplin' => 84],
            'A021' => ['Sikap' => 85, 'Fisik' => 84, 'Teknik' => 99, 'Prestasi' => 93, 'Disiplin' => 80],
            'A022' => ['Sikap' => 85, 'Fisik' => 83, 'Teknik' => 92, 'Prestasi' => 94, 'Disiplin' => 96],
            'A023' => ['Sikap' => 77, 'Fisik' => 88, 'Teknik' => 81, 'Prestasi' => 79, 'Disiplin' => 87],
            'A024' => ['Sikap' => 68, 'Fisik' => 72, 'Teknik' => 67, 'Prestasi' => 60, 'Disiplin' => 76],
            'A025' => ['Sikap' => 85, 'Fisik' => 77, 'Teknik' => 86, 'Prestasi' => 71, 'Disiplin' => 64],
            'A026' => ['Sikap' => 85, 'Fisik' => 74, 'Teknik' => 61, 'Prestasi' => 67, 'Disiplin' => 81],
            'A027' => ['Sikap' => 78, 'Fisik' => 69, 'Teknik' => 71, 'Prestasi' => 64, 'Disiplin' => 79],
            'A028' => ['Sikap' => 61, 'Fisik' => 80, 'Teknik' => 99, 'Prestasi' => 68, 'Disiplin' => 73],
            'A029' => ['Sikap' => 93, 'Fisik' => 87, 'Teknik' => 79, 'Prestasi' => 73, 'Disiplin' => 79],
            'A030' => ['Sikap' => 75, 'Fisik' => 90, 'Teknik' => 94, 'Prestasi' => 88, 'Disiplin' => 66],
            'A031' => ['Sikap' => 80, 'Fisik' => 80, 'Teknik' => 60, 'Prestasi' => 73, 'Disiplin' => 99],
            'A032' => ['Sikap' => 83, 'Fisik' => 73, 'Teknik' => 97, 'Prestasi' => 85, 'Disiplin' => 83],
            'A033' => ['Sikap' => 86, 'Fisik' => 75, 'Teknik' => 97, 'Prestasi' => 86, 'Disiplin' => 89],
            'A034' => ['Sikap' => 66, 'Fisik' => 82, 'Teknik' => 80, 'Prestasi' => 89, 'Disiplin' => 91],
            'A035' => ['Sikap' => 71, 'Fisik' => 82, 'Teknik' => 67, 'Prestasi' => 63, 'Disiplin' => 81],
            'A036' => ['Sikap' => 95, 'Fisik' => 63, 'Teknik' => 82, 'Prestasi' => 91, 'Disiplin' => 81],
            'A037' => ['Sikap' => 60, 'Fisik' => 68, 'Teknik' => 71, 'Prestasi' => 88, 'Disiplin' => 80],
            'A038' => ['Sikap' => 63, 'Fisik' => 74, 'Teknik' => 90, 'Prestasi' => 90, 'Disiplin' => 100],
            'A039' => ['Sikap' => 60, 'Fisik' => 95, 'Teknik' => 71, 'Prestasi' => 82, 'Disiplin' => 100],
            'A040' => ['Sikap' => 72, 'Fisik' => 70, 'Teknik' => 88, 'Prestasi' => 79, 'Disiplin' => 81],
            'A041' => ['Sikap' => 84, 'Fisik' => 73, 'Teknik' => 85, 'Prestasi' => 90, 'Disiplin' => 74],
            'A042' => ['Sikap' => 87, 'Fisik' => 87, 'Teknik' => 65, 'Prestasi' => 76, 'Disiplin' => 94],
            'A043' => ['Sikap' => 94, 'Fisik' => 94, 'Teknik' => 77, 'Prestasi' => 88, 'Disiplin' => 77],
            'A044' => ['Sikap' => 89, 'Fisik' => 95, 'Teknik' => 87, 'Prestasi' => 81, 'Disiplin' => 96],
            'A045' => ['Sikap' => 70, 'Fisik' => 100, 'Teknik' => 91, 'Prestasi' => 88, 'Disiplin' => 93],
            'A046' => ['Sikap' => 83, 'Fisik' => 75, 'Teknik' => 78, 'Prestasi' => 87, 'Disiplin' => 70],
            'A047' => ['Sikap' => 75, 'Fisik' => 93, 'Teknik' => 89, 'Prestasi' => 82, 'Disiplin' => 70],
            'A048' => ['Sikap' => 91, 'Fisik' => 76, 'Teknik' => 98, 'Prestasi' => 76, 'Disiplin' => 94],
            'A049' => ['Sikap' => 77, 'Fisik' => 88, 'Teknik' => 68, 'Prestasi' => 97, 'Disiplin' => 77],
            'A050' => ['Sikap' => 70, 'Fisik' => 84, 'Teknik' => 78, 'Prestasi' => 96, 'Disiplin' => 66],
            'A051' => ['Sikap' => 71, 'Fisik' => 91, 'Teknik' => 84, 'Prestasi' => 94, 'Disiplin' => 85],
            'A052' => ['Sikap' => 88, 'Fisik' => 79, 'Teknik' => 83, 'Prestasi' => 64, 'Disiplin' => 68],
            'A053' => ['Sikap' => 64, 'Fisik' => 71, 'Teknik' => 61, 'Prestasi' => 69, 'Disiplin' => 91],
            'A054' => ['Sikap' => 93, 'Fisik' => 68, 'Teknik' => 70, 'Prestasi' => 64, 'Disiplin' => 86],
            'A055' => ['Sikap' => 61, 'Fisik' => 95, 'Teknik' => 83, 'Prestasi' => 78, 'Disiplin' => 96],
            'A056' => ['Sikap' => 97, 'Fisik' => 89, 'Teknik' => 63, 'Prestasi' => 74, 'Disiplin' => 73],
            'A057' => ['Sikap' => 63, 'Fisik' => 70, 'Teknik' => 99, 'Prestasi' => 61, 'Disiplin' => 67],
            'A058' => ['Sikap' => 91, 'Fisik' => 66, 'Teknik' => 81, 'Prestasi' => 76, 'Disiplin' => 83],
            'A059' => ['Sikap' => 74, 'Fisik' => 78, 'Teknik' => 98, 'Prestasi' => 94, 'Disiplin' => 90],
            'A060' => ['Sikap' => 98, 'Fisik' => 80, 'Teknik' => 92, 'Prestasi' => 83, 'Disiplin' => 95],
            'A061' => ['Sikap' => 100, 'Fisik' => 84, 'Teknik' => 70, 'Prestasi' => 62, 'Disiplin' => 88],
            'A062' => ['Sikap' => 85, 'Fisik' => 100, 'Teknik' => 72, 'Prestasi' => 93, 'Disiplin' => 65],
            'A063' => ['Sikap' => 79, 'Fisik' => 69, 'Teknik' => 80, 'Prestasi' => 97, 'Disiplin' => 81],
            'A064' => ['Sikap' => 85, 'Fisik' => 78, 'Teknik' => 62, 'Prestasi' => 77, 'Disiplin' => 70],
            'A065' => ['Sikap' => 84, 'Fisik' => 65, 'Teknik' => 82, 'Prestasi' => 78, 'Disiplin' => 83],
            'A066' => ['Sikap' => 71, 'Fisik' => 65, 'Teknik' => 66, 'Prestasi' => 69, 'Disiplin' => 94],
            'A067' => ['Sikap' => 75, 'Fisik' => 61, 'Teknik' => 93, 'Prestasi' => 60, 'Disiplin' => 75],
            'A068' => ['Sikap' => 95, 'Fisik' => 98, 'Teknik' => 86, 'Prestasi' => 87, 'Disiplin' => 63],
            'A069' => ['Sikap' => 92, 'Fisik' => 65, 'Teknik' => 72, 'Prestasi' => 76, 'Disiplin' => 95],
            'A070' => ['Sikap' => 97, 'Fisik' => 94, 'Teknik' => 65, 'Prestasi' => 87, 'Disiplin' => 84],
            'A071' => ['Sikap' => 84, 'Fisik' => 79, 'Teknik' => 79, 'Prestasi' => 88, 'Disiplin' => 67],
            'A072' => ['Sikap' => 95, 'Fisik' => 62, 'Teknik' => 93, 'Prestasi' => 92, 'Disiplin' => 76],
            'A073' => ['Sikap' => 89, 'Fisik' => 84, 'Teknik' => 91, 'Prestasi' => 69, 'Disiplin' => 98],
            'A074' => ['Sikap' => 94, 'Fisik' => 76, 'Teknik' => 97, 'Prestasi' => 66, 'Disiplin' => 85],
            'A075' => ['Sikap' => 82, 'Fisik' => 73, 'Teknik' => 80, 'Prestasi' => 89, 'Disiplin' => 82],
            'A076' => ['Sikap' => 67, 'Fisik' => 84, 'Teknik' => 69, 'Prestasi' => 68, 'Disiplin' => 76],
            'A077' => ['Sikap' => 85, 'Fisik' => 66, 'Teknik' => 68, 'Prestasi' => 62, 'Disiplin' => 66],
            'A078' => ['Sikap' => 78, 'Fisik' => 100, 'Teknik' => 72, 'Prestasi' => 90, 'Disiplin' => 84],
            'A079' => ['Sikap' => 78, 'Fisik' => 66, 'Teknik' => 78, 'Prestasi' => 84, 'Disiplin' => 63],
            'A080' => ['Sikap' => 79, 'Fisik' => 84, 'Teknik' => 62, 'Prestasi' => 98, 'Disiplin' => 72],
            'A081' => ['Sikap' => 92, 'Fisik' => 92, 'Teknik' => 77, 'Prestasi' => 99, 'Disiplin' => 63],
            'A082' => ['Sikap' => 75, 'Fisik' => 64, 'Teknik' => 72, 'Prestasi' => 84, 'Disiplin' => 82],
            'A083' => ['Sikap' => 60, 'Fisik' => 96, 'Teknik' => 83, 'Prestasi' => 63, 'Disiplin' => 88],
            'A084' => ['Sikap' => 66, 'Fisik' => 60, 'Teknik' => 74, 'Prestasi' => 89, 'Disiplin' => 76],
            'A085' => ['Sikap' => 100, 'Fisik' => 70, 'Teknik' => 61, 'Prestasi' => 85, 'Disiplin' => 84],
            'A086' => ['Sikap' => 97, 'Fisik' => 61, 'Teknik' => 71, 'Prestasi' => 77, 'Disiplin' => 99],
            'A087' => ['Sikap' => 74, 'Fisik' => 85, 'Teknik' => 70, 'Prestasi' => 90, 'Disiplin' => 84],
            'A088' => ['Sikap' => 81, 'Fisik' => 100, 'Teknik' => 95, 'Prestasi' => 76, 'Disiplin' => 71],
            'A089' => ['Sikap' => 88, 'Fisik' => 69, 'Teknik' => 95, 'Prestasi' => 85, 'Disiplin' => 92],
            'A090' => ['Sikap' => 72, 'Fisik' => 79, 'Teknik' => 99, 'Prestasi' => 67, 'Disiplin' => 80],
            'A091' => ['Sikap' => 72, 'Fisik' => 87, 'Teknik' => 100, 'Prestasi' => 95, 'Disiplin' => 67],
            'A092' => ['Sikap' => 91, 'Fisik' => 91, 'Teknik' => 92, 'Prestasi' => 78, 'Disiplin' => 96],
            'A093' => ['Sikap' => 77, 'Fisik' => 77, 'Teknik' => 89, 'Prestasi' => 60, 'Disiplin' => 85],
            'A094' => ['Sikap' => 77, 'Fisik' => 69, 'Teknik' => 70, 'Prestasi' => 62, 'Disiplin' => 77],
            'A095' => ['Sikap' => 65, 'Fisik' => 94, 'Teknik' => 77, 'Prestasi' => 87, 'Disiplin' => 62],
            'A096' => ['Sikap' => 89, 'Fisik' => 93, 'Teknik' => 77, 'Prestasi' => 62, 'Disiplin' => 63],
            'A097' => ['Sikap' => 60, 'Fisik' => 64, 'Teknik' => 73, 'Prestasi' => 63, 'Disiplin' => 61],
            'A098' => ['Sikap' => 82, 'Fisik' => 88, 'Teknik' => 73, 'Prestasi' => 62, 'Disiplin' => 91],
            'A099' => ['Sikap' => 78, 'Fisik' => 91, 'Teknik' => 95, 'Prestasi' => 97, 'Disiplin' => 86],
            'A100' => ['Sikap' => 62, 'Fisik' => 70, 'Teknik' => 62, 'Prestasi' => 98, 'Disiplin' => 72],
            'A101' => ['Sikap' => 84, 'Fisik' => 62, 'Teknik' => 68, 'Prestasi' => 60, 'Disiplin' => 70],
            'A102' => ['Sikap' => 81, 'Fisik' => 92, 'Teknik' => 97, 'Prestasi' => 72, 'Disiplin' => 62],
            'A103' => ['Sikap' => 94, 'Fisik' => 82, 'Teknik' => 93, 'Prestasi' => 85, 'Disiplin' => 92],
            'A104' => ['Sikap' => 81, 'Fisik' => 62, 'Teknik' => 98, 'Prestasi' => 88, 'Disiplin' => 70],
            'A105' => ['Sikap' => 92, 'Fisik' => 79, 'Teknik' => 94, 'Prestasi' => 87, 'Disiplin' => 82],
            'A106' => ['Sikap' => 96, 'Fisik' => 71, 'Teknik' => 91, 'Prestasi' => 98, 'Disiplin' => 70],
            'A107' => ['Sikap' => 67, 'Fisik' => 82, 'Teknik' => 80, 'Prestasi' => 84, 'Disiplin' => 98],
            'A108' => ['Sikap' => 69, 'Fisik' => 92, 'Teknik' => 63, 'Prestasi' => 70, 'Disiplin' => 81],
            'A109' => ['Sikap' => 78, 'Fisik' => 94, 'Teknik' => 65, 'Prestasi' => 62, 'Disiplin' => 69],
            'A110' => ['Sikap' => 98, 'Fisik' => 70, 'Teknik' => 84, 'Prestasi' => 72, 'Disiplin' => 61],
            'A111' => ['Sikap' => 77, 'Fisik' => 100, 'Teknik' => 86, 'Prestasi' => 60, 'Disiplin' => 72],
            'A112' => ['Sikap' => 82, 'Fisik' => 99, 'Teknik' => 100, 'Prestasi' => 69, 'Disiplin' => 91],
            'A113' => ['Sikap' => 88, 'Fisik' => 63, 'Teknik' => 92, 'Prestasi' => 64, 'Disiplin' => 83],
            'A114' => ['Sikap' => 99, 'Fisik' => 84, 'Teknik' => 99, 'Prestasi' => 62, 'Disiplin' => 61],
            'A115' => ['Sikap' => 71, 'Fisik' => 81, 'Teknik' => 77, 'Prestasi' => 98, 'Disiplin' => 86],
            'A116' => ['Sikap' => 85, 'Fisik' => 96, 'Teknik' => 64, 'Prestasi' => 73, 'Disiplin' => 95],
            'A117' => ['Sikap' => 85, 'Fisik' => 93, 'Teknik' => 94, 'Prestasi' => 76, 'Disiplin' => 74],
            'A118' => ['Sikap' => 60, 'Fisik' => 97, 'Teknik' => 73, 'Prestasi' => 79, 'Disiplin' => 84],
            'A119' => ['Sikap' => 85, 'Fisik' => 99, 'Teknik' => 99, 'Prestasi' => 86, 'Disiplin' => 78],
            'A120' => ['Sikap' => 74, 'Fisik' => 81, 'Teknik' => 76, 'Prestasi' => 87, 'Disiplin' => 64],
            'A121' => ['Sikap' => 70, 'Fisik' => 99, 'Teknik' => 80, 'Prestasi' => 87, 'Disiplin' => 95],
            'A122' => ['Sikap' => 98, 'Fisik' => 89, 'Teknik' => 87, 'Prestasi' => 76, 'Disiplin' => 75],
            'A123' => ['Sikap' => 96, 'Fisik' => 79, 'Teknik' => 73, 'Prestasi' => 78, 'Disiplin' => 98],
            'A124' => ['Sikap' => 97, 'Fisik' => 74, 'Teknik' => 68, 'Prestasi' => 88, 'Disiplin' => 98],
            'A125' => ['Sikap' => 79, 'Fisik' => 99, 'Teknik' => 90, 'Prestasi' => 82, 'Disiplin' => 97],
            'A126' => ['Sikap' => 89, 'Fisik' => 87, 'Teknik' => 63, 'Prestasi' => 65, 'Disiplin' => 79],
            'A127' => ['Sikap' => 84, 'Fisik' => 69, 'Teknik' => 92, 'Prestasi' => 95, 'Disiplin' => 76],
            'A128' => ['Sikap' => 87, 'Fisik' => 81, 'Teknik' => 69, 'Prestasi' => 90, 'Disiplin' => 73],
            'A129' => ['Sikap' => 73, 'Fisik' => 99, 'Teknik' => 66, 'Prestasi' => 93, 'Disiplin' => 68],
            'A130' => ['Sikap' => 73, 'Fisik' => 82, 'Teknik' => 96, 'Prestasi' => 92, 'Disiplin' => 61],
            'A131' => ['Sikap' => 78, 'Fisik' => 83, 'Teknik' => 66, 'Prestasi' => 70, 'Disiplin' => 62],
            'A132' => ['Sikap' => 93, 'Fisik' => 83, 'Teknik' => 98, 'Prestasi' => 95, 'Disiplin' => 91],
            'A133' => ['Sikap' => 80, 'Fisik' => 66, 'Teknik' => 97, 'Prestasi' => 100, 'Disiplin' => 66],
            'A134' => ['Sikap' => 74, 'Fisik' => 78, 'Teknik' => 95, 'Prestasi' => 83, 'Disiplin' => 82],
            'A135' => ['Sikap' => 80, 'Fisik' => 94, 'Teknik' => 95, 'Prestasi' => 72, 'Disiplin' => 84],
            'A136' => ['Sikap' => 64, 'Fisik' => 85, 'Teknik' => 81, 'Prestasi' => 88, 'Disiplin' => 71],
            'A137' => ['Sikap' => 84, 'Fisik' => 94, 'Teknik' => 99, 'Prestasi' => 76, 'Disiplin' => 85],
            'A138' => ['Sikap' => 71, 'Fisik' => 63, 'Teknik' => 100, 'Prestasi' => 80, 'Disiplin' => 71],
            'A139' => ['Sikap' => 87, 'Fisik' => 63, 'Teknik' => 65, 'Prestasi' => 80, 'Disiplin' => 90],
            'A140' => ['Sikap' => 69, 'Fisik' => 93, 'Teknik' => 87, 'Prestasi' => 68, 'Disiplin' => 94],
        ];

        $criteriaMap = [
            'Sikap' => 'C1',
            'Fisik' => 'C2',
            'Teknik' => 'C3',
            'Prestasi' => 'C4',
            'Disiplin' => 'C5',
        ];

        foreach ($scoresData as $athleteCode => $criterionScores) {
            $athlete = Athlete::where('code', $athleteCode)->first();
            
            if (!$athlete) {
                $this->command->warn("Atlet dengan kode {$athleteCode} tidak ditemukan, melewati.");
                continue;
            }

            foreach ($criterionScores as $criterionName => $scoreVal) {
                $critCode = $criteriaMap[$criterionName];
                $criterionObj = $criteria[$critCode];

                Score::updateOrCreate(
                    [
                        'period_id' => $period->id,
                        'athlete_id' => $athlete->id,
                        'criterion_id' => $criterionObj->id,
                        'user_id' => $user->id,
                    ],
                    [
                        'score' => $scoreVal,
                    ]
                );
            }
        }

        $this->command->info('Berhasil menginput seluruh nilai atlet (A001 - A140).');
    }
}
