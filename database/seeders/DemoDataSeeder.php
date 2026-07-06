<?php

namespace Database\Seeders;

use App\Models\Athlete;
use App\Models\Criterion;
use App\Models\Period;
use App\Models\Score;
use App\Models\TopsisResult;
use App\Models\User;
use App\Services\TopsisService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@espa.test'],
            [
                'name' => 'Administrator ESPA',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $coaches = collect([
            [
                'name' => 'Pelatih Andi',
                'email' => 'pelatih.andi@espa.test',
                'role' => 'pelatih',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Pelatih Sinta',
                'email' => 'pelatih.sinta@espa.test',
                'role' => 'pelatih',
                'password' => Hash::make('password'),
            ],
        ])->map(function ($data) {
            return User::updateOrCreate(['email' => $data['email']], $data);
        });

        $criteria = collect([
            [
                'code' => 'C1',
                'name' => 'Teknik',
                'weight' => 0.30,
                'attribute' => 'benefit',
                'description' => 'Kemampuan teknik dasar dan eksekusi gerakan.',
            ],
            [
                'code' => 'C2',
                'name' => 'Disiplin Latihan',
                'weight' => 0.20,
                'attribute' => 'benefit',
                'description' => 'Konsistensi hadir, kepatuhan program, dan sikap latihan.',
            ],
            [
                'code' => 'C3',
                'name' => 'Stamina',
                'weight' => 0.25,
                'attribute' => 'benefit',
                'description' => 'Daya tahan fisik selama latihan dan simulasi tanding.',
            ],
            [
                'code' => 'C4',
                'name' => 'Pelanggaran',
                'weight' => 0.25,
                'attribute' => 'cost',
                'description' => 'Jumlah kesalahan atau pelanggaran saat sparring dan latihan.',
            ],
        ])->map(function ($data) {
            return Criterion::updateOrCreate(['code' => $data['code']], $data);
        })->keyBy('code');

        $athletes = collect([
            [
                'code' => 'ATL-001',
                'name' => 'Ahmad Fauzan',
                'gender' => 'laki-laki',
                'birth_date' => '2008-04-12',
                'age' => 17,
                'belt_level' => 'Merah Hitam',
                'competition_class' => 'Under 55 Kg',
                'status' => 'aktif',
            ],
            [
                'code' => 'ATL-002',
                'name' => 'Budi Santoso',
                'gender' => 'laki-laki',
                'birth_date' => '2007-09-03',
                'age' => 17,
                'belt_level' => 'Merah',
                'competition_class' => 'Under 59 Kg',
                'status' => 'aktif',
            ],
            [
                'code' => 'ATL-003',
                'name' => 'Citra Lestari',
                'gender' => 'perempuan',
                'birth_date' => '2008-01-20',
                'age' => 17,
                'belt_level' => 'Merah Hitam',
                'competition_class' => 'Under 49 Kg',
                'status' => 'aktif',
            ],
            [
                'code' => 'ATL-004',
                'name' => 'Dewi Anggraini',
                'gender' => 'perempuan',
                'birth_date' => '2009-02-15',
                'age' => 16,
                'belt_level' => 'Merah',
                'competition_class' => 'Under 53 Kg',
                'status' => 'aktif',
            ],
            [
                'code' => 'ATL-005',
                'name' => 'Eko Prasetyo',
                'gender' => 'laki-laki',
                'birth_date' => '2007-11-28',
                'age' => 17,
                'belt_level' => 'Biru Merah',
                'competition_class' => 'Under 63 Kg',
                'status' => 'aktif',
            ],
        ])->map(function ($data) {
            return Athlete::updateOrCreate(['code' => $data['code']], $data);
        })->keyBy('code');

        $period = Period::updateOrCreate(
            ['name' => 'Semester 1 2026'],
            [
                'start_date' => '2026-01-01',
                'end_date' => '2026-06-30',
                'status' => 'selesai',
            ]
        );

        Score::where('period_id', $period->id)->delete();
        TopsisResult::where('period_id', $period->id)->delete();

        $scoreMatrix = [
            'pelatih.andi@espa.test' => [
                'ATL-001' => ['C1' => 92, 'C2' => 88, 'C3' => 90, 'C4' => 10],
                'ATL-002' => ['C1' => 84, 'C2' => 82, 'C3' => 80, 'C4' => 18],
                'ATL-003' => ['C1' => 90, 'C2' => 91, 'C3' => 87, 'C4' => 8],
                'ATL-004' => ['C1' => 86, 'C2' => 89, 'C3' => 84, 'C4' => 12],
                'ATL-005' => ['C1' => 80, 'C2' => 78, 'C3' => 83, 'C4' => 22],
            ],
            'pelatih.sinta@espa.test' => [
                'ATL-001' => ['C1' => 94, 'C2' => 90, 'C3' => 91, 'C4' => 9],
                'ATL-002' => ['C1' => 82, 'C2' => 84, 'C3' => 81, 'C4' => 17],
                'ATL-003' => ['C1' => 91, 'C2' => 92, 'C3' => 89, 'C4' => 7],
                'ATL-004' => ['C1' => 85, 'C2' => 88, 'C3' => 85, 'C4' => 13],
                'ATL-005' => ['C1' => 81, 'C2' => 79, 'C3' => 82, 'C4' => 21],
            ],
        ];

        $rows = [];

        foreach ($scoreMatrix as $coachEmail => $athleteScores) {
            $coach = $coaches->firstWhere('email', $coachEmail);

            foreach ($athleteScores as $athleteCode => $criterionScores) {
                $athlete = $athletes->get($athleteCode);

                foreach ($criterionScores as $criterionCode => $score) {
                    $criterion = $criteria->get($criterionCode);

                    $rows[] = [
                        'period_id' => $period->id,
                        'athlete_id' => $athlete->id,
                        'criterion_id' => $criterion->id,
                        'user_id' => $coach->id,
                        'score' => $score,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        Score::insert($rows);

        app(TopsisService::class)->calculateForPeriod($period);

        $this->command->info('Demo data siap dipakai.');
        $this->command->line('Admin   : admin@espa.test / password');
        $this->command->line('Pelatih : pelatih.andi@espa.test / password');
        $this->command->line('Pelatih : pelatih.sinta@espa.test / password');
        $this->command->line('Periode contoh: Semester 1 2026');
        $this->command->line('Jumlah atlet aktif: ' . $athletes->count());
        $this->command->line('Jumlah kriteria: ' . $criteria->count());
        $this->command->line('Jumlah nilai: ' . count($rows));
        $this->command->line('Hasil TOPSIS telah dibuat untuk kebutuhan ranking dan laporan.');
    }
}
