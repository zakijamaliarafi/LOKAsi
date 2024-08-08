<?php

namespace Database\Seeders;

use App\Models\POI;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportPOISeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reports = [
            [
             'location_name' => 'SD Negeri 4 Rempoah',
             'latitude' => '-7.371532916666666',
             'longitude' => '109.23725127777777',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211113113847246.jpg',
             'input_time' => Carbon::create(2021, 11, 13, 11, 39, 15),
             'contributor_id' => '4',
            ],
            [
             'location_name' => 'TPST Rempoah',
             'latitude' => '-7.370072833333333',
             'longitude' => '109.2343978611111',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211113114722327.jpg',
             'input_time' => Carbon::create(2021, 11, 13, 11, 47, 40),
             'contributor_id' => '4',
            ],
            [
             'location_name' => 'Laqosta Farm RedDoorz',
             'latitude' => '-7.369262194444444',
             'longitude' => '109.23361966666667',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211113115638938.jpg',
             'input_time' => Carbon::create(2021, 11, 13, 11, 56, 45),
             'contributor_id' => '6',
            ],
            [
             'location_name' => 'Sekretariat NU Rating Rempoah',
             'latitude' => '-7.362123',
             'longitude' => '109.23503875',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211113120716007.jpg',
             'input_time' => Carbon::create(2021, 11, 13, 12, 7, 31),
             'contributor_id' => '4',
            ],
            [
             'location_name' => 'SMP PGRI Baturraden',
             'latitude' => '-7.362892138888888',
             'longitude' => '109.23847197222223',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211113121403370.jpg',
             'input_time' => Carbon::create(2021, 11, 13, 12, 14, 10),
             'contributor_id' => '6',
            ],
            [
             'location_name' => 'SMA Negeri 1 Baturraden',
             'latitude' => '-7.362655138888888',
             'longitude' => '109.23848722222222',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211113121601987.jpg',
             'input_time' => Carbon::create(2021, 11, 13, 12, 16, 8),
             'contributor_id' => '4',
            ],
            [
             'location_name' => 'Kuburan',
             'latitude' => '-7.346472222222222',
             'longitude' => '109.21718611111112',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115101117176.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 11, 40),
             'contributor_id' => '6',
            ],
            [
             'location_name' => 'Rumi Cell',
             'latitude' => '-7.347172222222222',
             'longitude' => '109.21821944444444',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115101523890.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 15, 35),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Pos Ronda',
             'latitude' => '-7.347144444444444',
             'longitude' => '109.21824444444445',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115101907547.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 19, 23),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Lestari Sandang',
             'latitude' => '-7.346816666666666',
             'longitude' => '109.21828888888889',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115102318511.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 23, 25),
             'contributor_id' => '6',
            ],
            [
             'location_name' => 'Jalan Rusak',
             'latitude' => '-7.346730555555555',
             'longitude' => '109.21824444444445',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115102543135.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 25, 47),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Jalan Rusak',
             'latitude' => '-7.346563888888888',
             'longitude' => '109.21822777777778',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115102726738.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 27, 33),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Masjid Baiturrohim',
             'latitude' => '-7.346458333333333',
             'longitude' => '109.21887222222223',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115103005288.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 30, 14),
             'contributor_id' => '6',
            ],
            [
             'location_name' => 'Jalan Rusak',
             'latitude' => '-7.346508333333333',
             'longitude' => '109.21854722222223',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115103405746.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 34, 9),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Toko Jenny',
             'latitude' => '-7.346466666666666',
             'longitude' => '109.21823333333333',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115103603336.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 36, 7),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Jalan',
             'latitude' => '-7.346402777777778',
             'longitude' => '109.21828611111111',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115103957019.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 40, 0),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Bakso Pak Aris',
             'latitude' => '-7.347344444444444',
             'longitude' => '109.21838055555556',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115104218430.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 42, 28),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Jalan Rusak',
             'latitude' => '-7.347530555555555',
             'longitude' => '109.21873611111111',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115104401748.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 44, 5),
             'contributor_id' => '6',
            ],
            [
             'location_name' => 'Majlis Ta`lim Baiturrohman',
             'latitude' => '-7.347325',
             'longitude' => '109.21935555555555',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115104758964.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 48, 2),
             'contributor_id' => '4',
            ],
            [
             'location_name' => 'Tempat Proyek?',
             'latitude' => '-7.346133222222222',
             'longitude' => '109.21284483333334',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115104858885.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 49, 11),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Pos Ronda',
             'latitude' => '-7.348252777777778',
             'longitude' => '109.21949444444445',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115105110929.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 51, 16),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Jalan Rusak',
             'latitude' => '-7.348252777777778',
             'longitude' => '109.21949722222223',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115105244520.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 52, 49),
             'contributor_id' => '6',
            ],
            [
             'location_name' => 'Leneng',
             'latitude' => '-7.343327972222222',
             'longitude' => '109.21238708333334',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115105254862.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 53, 9),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Jalan',
             'latitude' => '-7.348569444444444',
             'longitude' => '109.21961944444445',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115105427807.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 54, 37),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Kenangan Pelaku Perang',
             'latitude' => '-7.345405083333333',
             'longitude' => '109.21696469444444',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115105945192.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 10, 59, 52),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Jalan',
             'latitude' => '-7.349722222222222',
             'longitude' => '109.21935555555555',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115110016783.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 0, 27),
             'contributor_id' => '4',
            ],
            [
             'location_name' => 'Jual Ayam Potong dan Cabut Bulu',
             'latitude' => '-7.349869444444444',
             'longitude' => '109.21981666666667',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115110216758.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 2, 45),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Masjid',
             'latitude' => '-7.349975',
             'longitude' => '109.219975',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115110414138.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 4, 21),
             'contributor_id' => '4',
            ],
            [
             'location_name' => 'Rinangun Gemilang Sembada',
             'latitude' => '-7.3499',
             'longitude' => '109.21939166666667',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115110607421.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 6, 12),
             'contributor_id' => '6',
            ],
            [
             'location_name' => 'Sungai',
             'latitude' => '-7.34631775',
             'longitude' => '109.21706388888889',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115110609583.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 6, 21),
             'contributor_id' => '6',
            ],
            [
             'location_name' => 'Candi Prambanan',
             'latitude' => '-7.35025',
             'longitude' => '109.21945555555556',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115110732017.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 7, 34),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'AIN Laundry',
             'latitude' => '-7.350719444444444',
             'longitude' => '109.21939444444445',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115110927617.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 9, 53),
             'contributor_id' => '6',
            ],
            [
             'location_name' => 'Sungai',
             'latitude' => '-7.346632',
             'longitude' => '109.21649930555556',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115110946609.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 9, 59),
             'contributor_id' => '4',
            ],
            [
             'location_name' => 'Toko Susmi',
             'latitude' => '-7.350883333333333',
             'longitude' => '109.21941666666667',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115111057794.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 11, 2),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Flutter Clothing&Co',
             'latitude' => '-7.350933333333333',
             'longitude' => '109.21937222222222',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115111324482.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 13, 29),
             'contributor_id' => '5',
            ],
            [
             'location_name' => 'Rumah Ketua RT 04 RW 07',
             'latitude' => '-7.346097944444444',
             'longitude' => '109.21697233333333',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115111331464.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 13, 40),
             'contributor_id' => '4',
            ],
            [
             'location_name' => 'Pos Ronda',
             'latitude' => '-7.351066666666666',
             'longitude' => '109.21935555555555',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115111519383.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 15, 29),
             'contributor_id' => '4',
            ],
            [
             'location_name' => 'SD Negeri 3 Kutaliman',
             'latitude' => '-7.351677777777778',
             'longitude' => '109.21929722222222',
             'image_path' => 'poi_image/poi-kutaliman-12112021_20211115111734018.jpg',
             'input_time' => Carbon::create(2021, 11, 15, 11, 17, 37),
             'contributor_id' => '4',
            ],
           ];

        foreach ($reports as $report) {
            POI::create($report);
        }
    }
}