<?php

use Illuminate\Database\Seeder;
use App\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call('UsersTableSeeder');
        $arrayUsers = [
            ['username' => '11825106', 'name' => 'RIZKI FIRMANSYAH'],
            ['username' => '11925710', 'name' => 'ABDURRAHMAN FAIZ KARIEM'],
            ['username' => '11925711', 'name' => 'ADITYA YUSEPTA KRISTIADI'],
            ['username' => '11925712', 'name' => 'ARRAFIQ NURRAHMAN'],
            ['username' => '11925713', 'name' => 'AULIA RHAMAYANI AFIFAH'],
            ['username' => '11925714', 'name' => 'AZHAR HAFIZH ABDULLAH'],
            ['username' => '11925715', 'name' => 'ENZO RAMABAYAZID'],
            ['username' => '11925716', 'name' => 'ERINA ZUWITA'],
            ['username' => '11925717', 'name' => 'FAUZI ISMAIL'],
            ['username' => '11925718', 'name' => 'HENDRA SATRIO'],
            ['username' => '11925719', 'name' => 'ILHAM ANGGA KUSUMAH'],
            ['username' => '11925720', 'name' => 'INDRA AGUSTIN'],
            ['username' => '11925721', 'name' => 'KINARYA SAKA LANGIT RAYA'],
            ['username' => '11925722', 'name' => 'MOCHAMAD ARIE RAZWANI'],
            ['username' => '11925723', 'name' => 'MUHAMMAD AHADAN NUR FAUZAN'],
            ['username' => '11925724', 'name' => 'MUHAMMAD FAUZAN ARYAWARDHANA'],
            ['username' => '11925725', 'name' => 'MUHAMMAD FAUZAN DWI PUTERA'],
            ['username' => '11925726', 'name' => 'MUHAMMAD IBNU HASYIM ASSHIDIQ BACHDAR'],
            ['username' => '11925727', 'name' => 'MUHAMMAD LIBRAN RESTU WIBAWA'],
            ['username' => '11925728', 'name' => 'NADILA AMELIA PUTRI PRATAMA'],
            ['username' => '11925729', 'name' => 'NAUFAL DAFFA WIRAWAN'],
            ['username' => '11925730', 'name' => 'NURUL PUTRI'],
            ['username' => '11925731', 'name' => 'PUJI NUGRAHA'],
            ['username' => '11925732', 'name' => 'RAEHAN NAJMUDIN'],
            ['username' => '11925733', 'name' => 'RAFLY NAUFAL ARDYANSYAH'],
            ['username' => '11925734', 'name' => 'RAKA DZAFAR SHIDDIQ'],
            ['username' => '11925735', 'name' => 'RANI NURDIANI PUTRI'],
            ['username' => '11925736', 'name' => 'RISKA HIKMAH WANTI'],
            ['username' => '11925737', 'name' => 'RIZKY FAJAR UTAMA'],
            ['username' => '11925738', 'name' => 'RIZKY KUSRAMDANI'],
            ['username' => '11925739', 'name' => 'SANY MH PAUZI'],
            ['username' => '11925740', 'name' => 'SITI ASIYAH'],
            ['username' => '11925741', 'name' => 'SYAHRIL RASYID YURISTA'],
            ['username' => '11925742', 'name' => 'TEDY SUKMA PERMANA'],
            ['username' => '11925743', 'name' => 'VALENTINO CATUR FEBRIANTO STANIA'],
            ['username' => '11925744', 'name' => 'YOGA AVISENA YAZID']
        ];
        foreach ($arrayUsers as $item) {
            $user = new User();
            $user->username = $item['username'];
            $user->name = $item['name'];
            $user->password = password_hash($item['username'], PASSWORD_BCRYPT);
            $user->roles = 'siswa';
            $user->save();
        }
    }
}
