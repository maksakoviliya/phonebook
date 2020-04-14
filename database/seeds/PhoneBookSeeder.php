<?php

use App\PhoneBook;
use Illuminate\Database\Seeder;

class PhoneBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      PhoneBook::create([
        'title'       => 'АГРОПРОМЫШЛЕННЫЙ КОМПЛЕКС РОССИИ',
        'full_name'   => 'АГРОПРОМЫШЛЕННЫЙ КОМПЛЕКС РОССИИ',
        'description' => 'Описание',
        'parent_id'   => 0,
        'contacts'    => [],
        'site'        => 'website.ru',
        'address'     => 'г. Москва, ул. Красная площадь, д.2',
        'email'       => 'rusagro@mail.ru',
      ]);
      PhoneBook::create([
        'title'       => 'ФЕДЕРАЛЬНЫЕ ОРГАНЫ ВЛАСТИ РОССИЙСКОЙ ФЕДЕРАЦИИ',
        'full_name'   => 'ФЕДЕРАЛЬНЫЕ ОРГАНЫ ВЛАСТИ РОССИЙСКОЙ ФЕДЕРАЦИИ',
        'description' => 'Описание',
        'parent_id'   => 0,
        'contacts'    => [],
        'site'        => 'goverment.ru',
        'address'     => 'г. Москва, ул. Красная площадь, д.1',
        'email'       => 'rusfov@mail.ru',
      ]);
      PhoneBook::create([
        'title'       => 'СОВЕТ ФЕДЕРАЦИИ ФЕДЕРАЛЬНОГО СОБРАНИЯ РОССИЙСКОЙ ФЕДЕРАЦИИ',
        'full_name'   => 'СОВЕТ ФЕДЕРАЦИИ ФЕДЕРАЛЬНОГО СОБРАНИЯ РОССИЙСКОЙ ФЕДЕРАЦИИ',
        'description' => 'Описание',
        'parent_id'   => 2,
        'contacts'    => [],
        'site'        => 'fedsobr.ru',
        'address'     => 'г. Москва, ул. Большая Дмитровка, д.15',
        'email'       => 'fedsobr@mail.ru',
      ]);
      PhoneBook::create([
        'title'       => 'ГОСУДАРСТВЕННАЯ ДУМА ФЕДЕРАЛЬНОГО СОБРАНИЯ РОССИЙСКОЙ ФЕДЕРАЦИИ',
        'full_name'   => 'СОВЕТ ФЕДЕРАЦИИ ФЕДЕРАЛЬНОГО СОБРАНИЯ РОССИЙСКОЙ ФЕДЕРАЦИИ',
        'description' => 'Описание',
        'parent_id'   => 2,
        'contacts'    => [],
        'site'        => 'fedsobr.ru',
        'address'     => 'г. Москва, ул. Большая Дмитровка, д.15',
        'email'       => 'fedsobr@mail.ru',
      ]);
      PhoneBook::create([
        'title'       => 'ГОСУДАРСТВЕННАЯ ДУМА ФЕДЕРАЛЬНОГО СОБРАНИЯ РОССИЙСКОЙ ФЕДЕРАЦИИ',
        'full_name'   => 'МИНИСТЕРСТВО СЕЛЬСКОГО ХОЗЯЙСТВА РОССИЙСКОЙ ФЕДЕРАЦИИ',
        'description' => 'Описание',
        'parent_id'   => 2,
        'contacts'    => [],
        'site'        => 'fedsobr.ru',
        'address'     => 'г. Москва, ул. Большая Дмитровка, д.15',
        'email'       => 'fedsobr@mail.ru',
      ]);
      PhoneBook::create([
        'title'       => 'ФЕДЕРАЛЬНАЯ СЛУЖБА ПО ВЕТЕРИНАРНОМУ И ФИТОСАНИТАРНОМУ НАДЗОРУ (РОССЕЛЬХОЗНАДЗОР)',
        'full_name'   => 'ФЕДЕРАЛЬНАЯ СЛУЖБА ПО ВЕТЕРИНАРНОМУ И ФИТОСАНИТАРНОМУ НАДЗОРУ (РОССЕЛЬХОЗНАДЗОР)',
        'description' => 'Описание',
        'parent_id'   => 2,
        'contacts'    => [],
        'site'        => 'fedsobr.ru',
        'address'     => 'г. Москва, ул. Большая Дмитровка, д.15',
        'email'       => 'fedsobr@mail.ru',
      ]);
    }
}
