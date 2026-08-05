<?php

namespace Database\Seeders;

use App\Models\Athlete;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AthleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'Fathia Sheema Ainaya' => 'perempuan',
            'Alysa Farzana Ginting' => 'perempuan',
            'Valestin Yusevano' => 'laki-laki',
            'zevanaya raisa purwadi' => 'perempuan',
            'Annisa Faizal' => 'perempuan',
            'M.Ridwan Assajad' => 'laki-laki',
            'Basel khoir umam' => 'laki-laki',
            'Mohamad ghathfaan Al musyaffa\'' => 'laki-laki',
            'Asyifa Nazahra Nasution' => 'perempuan',
            'rhaisya rizkia a.p' => 'perempuan',
            'Aisya Zahwa Mulya' => 'perempuan',
            'Yasmin putri' => 'perempuan',
            'Aulia' => 'perempuan',
            'Afthan Ghiffari' => 'laki-laki',
            'Richie' => 'laki-laki',
            'Alika Ebrilia Setiawan' => 'perempuan',
            'Mirella Aprillia Marantika' => 'perempuan',
            'Oktaviani Putri' => 'perempuan',
            'Sheza Falichia' => 'perempuan',
            'Bayu Aulian basyri' => 'laki-laki',
            'Noureen Aqueena Sutabah' => 'perempuan',
            'Alula khazalea' => 'perempuan',
            'Edwin haidar arhab bahtiar' => 'laki-laki',
            'Muhammad Abdul Rasyid' => 'laki-laki',
            'Ahmad Ghofran Hadi' => 'laki-laki',
            'Azkia Ramadhani' => 'perempuan',
            'Muhammad Ar-Rasyid Habibie' => 'laki-laki',
            'Arka yudha rabbani' => 'laki-laki',
            'Ibrahim khaliq al basyir' => 'laki-laki',
            'Ilyas Hamizan Hasan' => 'laki-laki',
            'Dimas sanjaya' => 'laki-laki',
            'Salsabila Ayu Hanifa' => 'perempuan',
            'Alyza Faidha Zahwa' => 'perempuan',
            'Alula Kayyisa' => 'perempuan',
            'Ilham Zaidan el azzam' => 'laki-laki',
            'Farah Arrum Hapsari' => 'perempuan',
            'Aqilla Defitri Ristanto' => 'perempuan',
            'Ines Tarisa Hapsari' => 'perempuan',
            'AzaLea Faidha Azmi' => 'perempuan',
            'Nur Annisa' => 'perempuan',
            'Muhammad Aqeel Raffasya' => 'laki-laki',
            'Almahyra Rianka Fauzi' => 'perempuan',
            'Hafizah ananda' => 'perempuan',
            'Balqis callista Maharani' => 'perempuan',
            'Naurah Anindya' => 'perempuan',
            'Qyara Khalifa Sakhi' => 'perempuan',
            'Kamila nareswari' => 'perempuan',
            'Khedira Aretha Humairah' => 'perempuan',
            'Khanza Nada Syakirah' => 'perempuan',
            'Aqila Zahra Fadilah' => 'perempuan',
            'qeysah dilah' => 'perempuan',
            'Fahry Alfarizi' => 'laki-laki',
            'Angellista Dwi Aprilia' => 'perempuan',
            'Linda Rahmania Ardani' => 'perempuan',
            'Atiqka Fairuz Khalihza' => 'perempuan',
            'Adia Danesha Hamdani Putri' => 'perempuan',
            'Alrasyid Rizky Firdausi' => 'laki-laki',
            'Bilqis Adelia' => 'perempuan',
            'Arsya Fatih' => 'laki-laki',
            'Darrel Keyva Semesta' => 'laki-laki',
            'Arprisha Lituhayu Kusumo' => 'perempuan',
            'Nuraqila Putri' => 'perempuan',
            'Kalila Rifda' => 'perempuan',
            'Inayah Ramadhani Prasetyo' => 'perempuan',
            'M. Alfattahuddin' => 'laki-laki',
            'Naveen Azeem' => 'laki-laki',
            'Yumna Adilla Zayyani' => 'perempuan',
            'M.Khalifatul Muslim Ar Rauf' => 'laki-laki',
            'Zukhrufa Firdausa Adha' => 'perempuan',
            'Khansya nararya' => 'perempuan',
            'Nouvan adhitria' => 'laki-laki',
            'Kasandra putri arsyilla' => 'perempuan',
            'Eleya Herni Yanti' => 'perempuan',
            'Aldebaran' => 'laki-laki',
            'Nawal Salafiyah .M' => 'perempuan',
            'Muhammad Fattan Alif' => 'laki-laki',
            'Hannani Nismara. H' => 'perempuan',
            'Xavier Gaozhan P.' => 'laki-laki',
            'Kinanthi Mikaila H' => 'perempuan',
            'Adinda Kirana Dwi P.' => 'perempuan',
            'muhammad Najib A' => 'laki-laki',
            'zalfa Aqilah Azzahra' => 'perempuan',
            'Dalisha Lulu Mumtazah' => 'perempuan',
            'Razita Huraiyah' => 'perempuan',
            'Malaeka Ghassani' => 'perempuan',
            'Muhammad Bilal mirza' => 'laki-laki',
            'Devina Syarafana Saputra' => 'perempuan',
            'Rafardhan M Altafini Nugroho' => 'laki-laki',
            'Muhammad Athar Ramadhan' => 'laki-laki',
            'Kasandra Putri Arsyilla' => 'perempuan',
            'Aldy Saputra' => 'laki-laki',
            'Deva Syahroji' => 'laki-laki',
            'Azalfa Syauqia' => 'perempuan',
            'Zidni Zahirah' => 'perempuan',
            'Nur Maulidah Hasianta' => 'perempuan',
            'Annora Elysia' => 'perempuan',
            'Orlin Monccu' => 'perempuan',
            'Muhammad Izdihara Herliano' => 'laki-laki',
            'Oktadulas Harvidar' => 'laki-laki',
            'Reigantara Gamma Prastyo' => 'laki-laki',
            'Malikul Ihsan Huwaidi' => 'laki-laki',
            'M Bayudhanu' => 'laki-laki',
            'Siti Zahra Nur Oktaviani' => 'perempuan',
            'Alvaro Virendra Adi' => 'laki-laki',
            'Nagita Wihelmina Mondo' => 'perempuan',
            'Andzany Ramadhania' => 'perempuan',
            'Azhra Fadillah' => 'perempuan',
            'Nindya Anisa Sulistyo' => 'perempuan',
            'Aisyah Aulia Mukminah' => 'perempuan',
            'Alveren mazulka Kusuma' => 'laki-laki',
            'Akhtar Miladhafi Ibrahim' => 'laki-laki',
            'Jasmine Athaya Nijananda' => 'perempuan',
            'Arjuna Maalique Marzuki' => 'laki-laki',
            'Nafeeza Nahikari Jingga' => 'perempuan',
            'Adinda Mozzalea El Zatta' => 'perempuan',
            'Anninda Hadinata' => 'perempuan',
            'Jihan Kanza Marissa' => 'perempuan',
            'M. Devan Atharrazka Triatmojo' => 'laki-laki',
            'Muhammad Fadhil Alfatih' => 'laki-laki',
            'Ilham Hidayat' => 'laki-laki',
            'Sifa Khoirunnisa' => 'perempuan',
            'Shafira Putri Marchilla Darmawan' => 'perempuan',
            'M. Dastan Ar Razzaqu Triatmojo' => 'laki-laki',
            'Audy Syah' => 'perempuan',
            'Ariny Zain Miftah' => 'perempuan',
            'Keandra Alfarizki Iskandar' => 'laki-laki',
            'Delisha Putri Ardana' => 'perempuan',
            'Khansa Lioni' => 'perempuan',
            'Muhammad Fatih Alfarizqi' => 'laki-laki',
            'Fadil Gilang Ramadhan' => 'laki-laki',
            'Adzkiya Shalihah' => 'perempuan',
            'Ahmad Ibnu Abdillah' => 'laki-laki',
            'Khoirunnisa Azzalea Tiawan' => 'perempuan',
            'Ra\'ufa Lathif Mubarok' => 'laki-laki',
            'Mariam Hagia Shopia' => 'perempuan',
            'M. Arkan Aqila' => 'laki-laki',
            'Rendika Fakhrie Zhafran Khairy' => 'laki-laki',
            'Aisya Ayunindiya' => 'perempuan',
            'Karmelia Qaisya' => 'perempuan',
            'Aqeela Ramadhani' => 'perempuan',
            'Ran Minori' => 'perempuan',
            'Atikah Zulfa Ghanie' => 'perempuan',
            'Tasmira Tsani' => 'perempuan',
            'Adiba Zahwa Aqila Absor' => 'perempuan',
            'Aneira Zivana P.Prabowo' => 'perempuan',
            'Diandra Ishana Nareswari' => 'perempuan',
            'Aizan Alarik Habibie' => 'laki-laki',
            'Camila Fathiyya Azzahra' => 'perempuan',
            'Hanifah Putri' => 'perempuan',
            'Davina' => 'perempuan',
        ];

        $belts = ['Putih', 'Kuning', 'Hijau', 'Biru', 'Merah', 'Merah Hitam', 'Hitam'];
        
        $classesMale = ['Under 45 Kg', 'Under 48 Kg', 'Under 51 Kg', 'Under 55 Kg', 'Under 59 Kg', 'Under 63 Kg', 'Under 68 Kg', 'Under 73 Kg', 'Under 78 Kg', 'Over 78 Kg'];
        $classesFemale = ['Under 42 Kg', 'Under 44 Kg', 'Under 46 Kg', 'Under 49 Kg', 'Under 52 Kg', 'Under 55 Kg', 'Under 59 Kg', 'Under 63 Kg', 'Under 68 Kg', 'Over 68 Kg'];

        $index = 1;
        foreach ($names as $name => $gender) {
            // A001, A002, ..., A140
            $code = 'A' . str_pad($index, 3, '0', STR_PAD_LEFT);

            // Generate birth_date between age 14 and 20
            $age = rand(14, 20);
            $birthDate = Carbon::now()->subYears($age)->subMonths(rand(0, 11))->subDays(rand(0, 30))->format('Y-m-d');

            $belt = $belts[array_rand($belts)];
            $compClass = $gender === 'laki-laki' ? $classesMale[array_rand($classesMale)] : $classesFemale[array_rand($classesFemale)];

            Athlete::create([
                'code' => $code,
                'name' => $name,
                'gender' => $gender,
                'birth_date' => $birthDate,
                'age' => $age,
                'belt_level' => $belt,
                'competition_class' => $compClass,
                'status' => 'aktif',
            ]);

            $index++;
        }
    }
}
