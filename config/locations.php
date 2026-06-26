<?php
/**
 * Hierarchical location data: Country → Province → District
 * Each name array: ['ar' => '...', 'en' => '...', 'tr' => '...']
 */
return [

    'TR' => [
        'name' => ['ar' => 'تركيا', 'en' => 'Turkey', 'tr' => 'Türkiye'],
        'provinces' => [
            'istanbul'     => ['name' => ['ar' => 'إسطنبول',     'en' => 'Istanbul',     'tr' => 'İstanbul'],
                'districts' => [
                    'besiktas'     => ['ar' => 'بشيكتاش',     'en' => 'Beşiktaş',     'tr' => 'Beşiktaş'],
                    'sisli'        => ['ar' => 'شيشلي',        'en' => 'Şişli',         'tr' => 'Şişli'],
                    'beyoglu'      => ['ar' => 'بيوغلو',       'en' => 'Beyoğlu',       'tr' => 'Beyoğlu'],
                    'kadikoy'      => ['ar' => 'كاديكوي',      'en' => 'Kadıköy',       'tr' => 'Kadıköy'],
                    'uskudar'      => ['ar' => 'أوسكودار',     'en' => 'Üsküdar',       'tr' => 'Üsküdar'],
                    'fatih'        => ['ar' => 'الفاتح',        'en' => 'Fatih',         'tr' => 'Fatih'],
                    'bakirkoy'     => ['ar' => 'باكيركوي',     'en' => 'Bakırköy',      'tr' => 'Bakırköy'],
                    'bayrampasa'   => ['ar' => 'بايرامباشا',   'en' => 'Bayrampaşa',    'tr' => 'Bayrampaşa'],
                    'zeytinburnu'  => ['ar' => 'زيتون بورنو',  'en' => 'Zeytinburnu',   'tr' => 'Zeytinburnu'],
                    'eyupsultan'   => ['ar' => 'إيوب سلطان',   'en' => 'Eyüpsultan',    'tr' => 'Eyüpsultan'],
                    'gaziosmanpasa'=> ['ar' => 'غازي عثمان باشا','en'=>'Gaziosmanpaşa', 'tr' => 'Gaziosmanpaşa'],
                    'kagithane'    => ['ar' => 'كاغيثهانه',    'en' => 'Kâğıthane',     'tr' => 'Kâğıthane'],
                    'sariyer'      => ['ar' => 'ساريير',        'en' => 'Sarıyer',       'tr' => 'Sarıyer'],
                    'avcilar'      => ['ar' => 'أفجيلار',      'en' => 'Avcılar',       'tr' => 'Avcılar'],
                    'bahcelievler' => ['ar' => 'باهشيلييفلر',  'en' => 'Bahçelievler',  'tr' => 'Bahçelievler'],
                    'bagcilar'     => ['ar' => 'باغجيلار',     'en' => 'Bağcılar',      'tr' => 'Bağcılar'],
                    'basaksehir'   => ['ar' => 'باشاك شهير',   'en' => 'Başakşehir',    'tr' => 'Başakşehir'],
                    'esenyurt'     => ['ar' => 'إيسن يورت',    'en' => 'Esenyurt',      'tr' => 'Esenyurt'],
                    'buyukcekmece' => ['ar' => 'بيوك شكمجه',   'en' => 'Büyükçekmece',  'tr' => 'Büyükçekmece'],
                    'kucukcekmece' => ['ar' => 'كيوتشوك شكمجه','en'=>'Küçükçekmece',   'tr' => 'Küçükçekmece'],
                    'pendik'       => ['ar' => 'بندك',          'en' => 'Pendik',        'tr' => 'Pendik'],
                    'maltepe'      => ['ar' => 'مالتبه',        'en' => 'Maltepe',       'tr' => 'Maltepe'],
                    'kartal'       => ['ar' => 'كارتال',        'en' => 'Kartal',        'tr' => 'Kartal'],
                    'tuzla'        => ['ar' => 'توزلا',          'en' => 'Tuzla',         'tr' => 'Tuzla'],
                    'sultanbeyli'  => ['ar' => 'سلطان بيلي',    'en' => 'Sultanbeyli',   'tr' => 'Sultanbeyli'],
                    'cekmekoy'     => ['ar' => 'شكمكوي',        'en' => 'Çekmeköy',      'tr' => 'Çekmeköy'],
                    'sancaktepe'   => ['ar' => 'سانجاكتبه',    'en' => 'Sancaktepe',    'tr' => 'Sancaktepe'],
                    'umraniye'     => ['ar' => 'أومرانيه',      'en' => 'Ümraniye',      'tr' => 'Ümraniye'],
                    'catalca'      => ['ar' => 'شاتالجا',       'en' => 'Çatalca',       'tr' => 'Çatalca'],
                    'silivri'      => ['ar' => 'سيليفري',       'en' => 'Silivri',       'tr' => 'Silivri'],
                    'arnavutkoy'   => ['ar' => 'أرناووت كوي',   'en' => 'Arnavutköy',    'tr' => 'Arnavutköy'],
                    'sultangazi'   => ['ar' => 'سلطان غازي',    'en' => 'Sultangazi',    'tr' => 'Sultangazi'],
                    'esenler'      => ['ar' => 'إيسنلر',        'en' => 'Esenler',       'tr' => 'Esenler'],
                    'gungoren'     => ['ar' => 'غونغورن',       'en' => 'Güngören',      'tr' => 'Güngören'],
                    'bayrampasa'   => ['ar' => 'بايرامباشا',    'en' => 'Bayrampaşa',    'tr' => 'Bayrampaşa'],
                    'adalar'       => ['ar' => 'الجزر',          'en' => 'Adalar',        'tr' => 'Adalar'],
                ]],

            'ankara'       => ['name' => ['ar' => 'أنقرة',      'en' => 'Ankara',       'tr' => 'Ankara'],
                'districts' => [
                    'cankaya'      => ['ar' => 'تشانكايا',     'en' => 'Çankaya',       'tr' => 'Çankaya'],
                    'kecioren'     => ['ar' => 'كيتشيورن',     'en' => 'Keçiören',      'tr' => 'Keçiören'],
                    'mamak'        => ['ar' => 'مامق',          'en' => 'Mamak',         'tr' => 'Mamak'],
                    'yenimahalle'  => ['ar' => 'ينيماهله',      'en' => 'Yenimahalle',   'tr' => 'Yenimahalle'],
                    'sincan'       => ['ar' => 'سينجان',        'en' => 'Sincan',        'tr' => 'Sincan'],
                    'etimesgut'    => ['ar' => 'إتيمسغوت',     'en' => 'Etimesgut',     'tr' => 'Etimesgut'],
                    'altindag'     => ['ar' => 'ألتينداغ',      'en' => 'Altındağ',      'tr' => 'Altındağ'],
                    'golbasi'      => ['ar' => 'غولباشي',       'en' => 'Gölbaşı',       'tr' => 'Gölbaşı'],
                ]],

            'izmir'        => ['name' => ['ar' => 'إزمير',      'en' => 'Izmir',        'tr' => 'İzmir'],
                'districts' => [
                    'konak'        => ['ar' => 'كوناق',         'en' => 'Konak',         'tr' => 'Konak'],
                    'karsiyaka'    => ['ar' => 'كارشياكا',      'en' => 'Karşıyaka',     'tr' => 'Karşıyaka'],
                    'bornova'      => ['ar' => 'بورنوفا',       'en' => 'Bornova',       'tr' => 'Bornova'],
                    'buca'         => ['ar' => 'بوجا',          'en' => 'Buca',          'tr' => 'Buca'],
                    'bayrakli'     => ['ar' => 'بايراكلي',      'en' => 'Bayraklı',      'tr' => 'Bayraklı'],
                    'cigli'        => ['ar' => 'تشيغلي',        'en' => 'Çiğli',         'tr' => 'Çiğli'],
                    'cesme'        => ['ar' => 'تشيشمه',        'en' => 'Çeşme',         'tr' => 'Çeşme'],
                    'menderes'     => ['ar' => 'مندريس',        'en' => 'Menderes',      'tr' => 'Menderes'],
                ]],

            'antalya'      => ['name' => ['ar' => 'أنطاليا',    'en' => 'Antalya',      'tr' => 'Antalya'],
                'districts' => [
                    'muratpasa'    => ['ar' => 'مراد باشا',     'en' => 'Muratpaşa',     'tr' => 'Muratpaşa'],
                    'kepez'        => ['ar' => 'كبز',           'en' => 'Kepez',         'tr' => 'Kepez'],
                    'konyaalti'    => ['ar' => 'قونيا ألتي',    'en' => 'Konyaaltı',     'tr' => 'Konyaaltı'],
                    'alanya'       => ['ar' => 'ألانيا',         'en' => 'Alanya',        'tr' => 'Alanya'],
                    'manavgat'     => ['ar' => 'مانافغات',      'en' => 'Manavgat',      'tr' => 'Manavgat'],
                    'serik'        => ['ar' => 'سريك',          'en' => 'Serik',         'tr' => 'Serik'],
                    'akseki'       => ['ar' => 'أكسكي',         'en' => 'Akseki',        'tr' => 'Akseki'],
                    'kas'          => ['ar' => 'كاش',           'en' => 'Kaş',           'tr' => 'Kaş'],
                    'kemer'        => ['ar' => 'كيمر',          'en' => 'Kemer',         'tr' => 'Kemer'],
                    'side'         => ['ar' => 'سيده',          'en' => 'Side',          'tr' => 'Side'],
                ]],

            'bursa'        => ['name' => ['ar' => 'بورصة',      'en' => 'Bursa',        'tr' => 'Bursa'],
                'districts' => [
                    'nilufer'      => ['ar' => 'نيلوفر',        'en' => 'Nilüfer',       'tr' => 'Nilüfer'],
                    'osmangazi'    => ['ar' => 'عثمان غازي',    'en' => 'Osmangazi',     'tr' => 'Osmangazi'],
                    'yildirim'     => ['ar' => 'يلدريم',        'en' => 'Yıldırım',      'tr' => 'Yıldırım'],
                    'mudanya'      => ['ar' => 'مودانيا',       'en' => 'Mudanya',       'tr' => 'Mudanya'],
                    'gemlik'       => ['ar' => 'جيمليك',        'en' => 'Gemlik',        'tr' => 'Gemlik'],
                ]],

            'trabzon'      => ['name' => ['ar' => 'طرابزون',    'en' => 'Trabzon',      'tr' => 'Trabzon'],
                'districts' => [
                    'ortahisar'    => ['ar' => 'أورتاهيصار',    'en' => 'Ortahisar',     'tr' => 'Ortahisar'],
                    'akcaabat'     => ['ar' => 'أكتشاآباد',     'en' => 'Akçaabat',      'tr' => 'Akçaabat'],
                    'of'           => ['ar' => 'أوف',           'en' => 'Of',            'tr' => 'Of'],
                    'arsin'        => ['ar' => 'أرسين',         'en' => 'Arsin',         'tr' => 'Arsin'],
                ]],

            'mersin'       => ['name' => ['ar' => 'مرسين',      'en' => 'Mersin',       'tr' => 'Mersin'],
                'districts' => [
                    'yenisehir'    => ['ar' => 'ينيشهير',       'en' => 'Yenişehir',     'tr' => 'Yenişehir'],
                    'mezitli'      => ['ar' => 'مزيطلي',        'en' => 'Mezitli',       'tr' => 'Mezitli'],
                    'toroslar'     => ['ar' => 'طوروسلار',      'en' => 'Toroslar',      'tr' => 'Toroslar'],
                    'akdeniz'      => ['ar' => 'أكدنيز',        'en' => 'Akdeniz',       'tr' => 'Akdeniz'],
                    'tarsus'       => ['ar' => 'طرسوس',         'en' => 'Tarsus',        'tr' => 'Tarsus'],
                ]],

            'gaziantep'    => ['name' => ['ar' => 'غازي عنتاب', 'en' => 'Gaziantep',    'tr' => 'Gaziantep'],
                'districts' => [
                    'sahinbey'     => ['ar' => 'شاهين بيه',     'en' => 'Şahinbey',      'tr' => 'Şahinbey'],
                    'sehitkamil'   => ['ar' => 'شهيت كاميل',   'en' => 'Şehitkamil',    'tr' => 'Şehitkamil'],
                    'islahiye'     => ['ar' => 'إصلاحية',       'en' => 'İslahiye',      'tr' => 'İslahiye'],
                ]],

            'konya'        => ['name' => ['ar' => 'قونية',      'en' => 'Konya',        'tr' => 'Konya'],
                'districts' => [
                    'selcuklu'     => ['ar' => 'سلجوق لو',      'en' => 'Selçuklu',      'tr' => 'Selçuklu'],
                    'meram'        => ['ar' => 'ميرام',          'en' => 'Meram',         'tr' => 'Meram'],
                    'karatay'      => ['ar' => 'قراطاي',        'en' => 'Karatay',       'tr' => 'Karatay'],
                ]],

            'bodrum'       => ['name' => ['ar' => 'بودروم',     'en' => 'Bodrum (Muğla)','tr'=> 'Bodrum'],
                'districts' => [
                    'bodrum_merkez'=> ['ar' => 'بودروم المركز', 'en' => 'Bodrum Center', 'tr' => 'Bodrum Merkez'],
                    'yalikavak'    => ['ar' => 'يالي كافاك',    'en' => 'Yalıkavak',     'tr' => 'Yalıkavak'],
                    'turgutreis'   => ['ar' => 'تورغوت ريس',    'en' => 'Turgutreis',    'tr' => 'Turgutreis'],
                    'gumbet'       => ['ar' => 'غومبيت',        'en' => 'Gümbet',        'tr' => 'Gümbet'],
                ]],

            'fethiye'      => ['name' => ['ar' => 'فتحيه (موغلا)','en'=>'Fethiye (Muğla)','tr'=>'Fethiye'],
                'districts' => [
                    'fethiye_merkez'=>['ar' => 'فتحيه المركز', 'en' => 'Fethiye Center','tr' => 'Fethiye Merkez'],
                    'oludeniz'     => ['ar' => 'أولودنيز',      'en' => 'Ölüdeniz',      'tr' => 'Ölüdeniz'],
                    'calis'        => ['ar' => 'جاليش',         'en' => 'Çalış',         'tr' => 'Çalış'],
                    'hisaronu'     => ['ar' => 'حصار أونو',     'en' => 'Hisarönü',      'tr' => 'Hisarönü'],
                ]],

            'yalova'       => ['name' => ['ar' => 'يالوفا',     'en' => 'Yalova',       'tr' => 'Yalova'],
                'districts' => [
                    'merkez'       => ['ar' => 'المركز',         'en' => 'Center',        'tr' => 'Merkez'],
                    'cinarcik'     => ['ar' => 'تشينارجيك',     'en' => 'Çınarcık',      'tr' => 'Çınarcık'],
                    'altinova'     => ['ar' => 'ألتينوفا',      'en' => 'Altınova',      'tr' => 'Altınova'],
                ]],

            'sakarya'      => ['name' => ['ar' => 'سكاريا',     'en' => 'Sakarya',      'tr' => 'Sakarya'],
                'districts' => [
                    'adapazari'    => ['ar' => 'آدابازاري',     'en' => 'Adapazarı',     'tr' => 'Adapazarı'],
                    'serdivan'     => ['ar' => 'سرديفان',       'en' => 'Serdivan',      'tr' => 'Serdivan'],
                    'erenler'      => ['ar' => 'إيرنلر',        'en' => 'Erenler',       'tr' => 'Erenler'],
                ]],

            'kocaeli'      => ['name' => ['ar' => 'كوجايلي',   'en' => 'Kocaeli',      'tr' => 'Kocaeli'],
                'districts' => [
                    'izmit'        => ['ar' => 'إزميت',         'en' => 'İzmit',         'tr' => 'İzmit'],
                    'gebze'        => ['ar' => 'غبزه',          'en' => 'Gebze',         'tr' => 'Gebze'],
                    'golcuk'       => ['ar' => 'غولجوك',        'en' => 'Gölcük',        'tr' => 'Gölcük'],
                    'darica'       => ['ar' => 'داريجا',        'en' => 'Darıca',        'tr' => 'Darıca'],
                ]],
        ],
    ],

    'IQ' => [
        'name' => ['ar' => 'العراق', 'en' => 'Iraq', 'tr' => 'Irak'],
        'provinces' => [
            'baghdad'    => ['name' => ['ar' => 'بغداد',          'en' => 'Baghdad',       'tr' => 'Bağdat'],
                'districts' => [
                    'karkh'        => ['ar' => 'الكرخ',           'en' => 'Karkh',         'tr' => 'Karkh'],
                    'rusafa'       => ['ar' => 'الرصافة',          'en' => 'Rusafa',        'tr' => 'Rusafa'],
                    'adhamiya'     => ['ar' => 'الأعظمية',         'en' => 'Adhamiya',      'tr' => 'Adhamiya'],
                    'karada'       => ['ar' => 'الكرادة',          'en' => 'Karada',        'tr' => 'Karada'],
                    'mansour'      => ['ar' => 'المنصور',          'en' => 'Mansour',       'tr' => 'Mansour'],
                    'dora'         => ['ar' => 'الدورة',           'en' => 'Dora',          'tr' => 'Dora'],
                    'sadr'         => ['ar' => 'مدينة الصدر',      'en' => 'Sadr City',     'tr' => 'Sadr City'],
                    'jadriya'      => ['ar' => 'الجادرية',         'en' => 'Jadriya',       'tr' => 'Jadriya'],
                ]],
            'erbil'      => ['name' => ['ar' => 'أربيل',           'en' => 'Erbil',         'tr' => 'Erbil'],
                'districts' => [
                    'erbil_merkez' => ['ar' => 'أربيل المركز',     'en' => 'Erbil Center',  'tr' => 'Erbil Merkez'],
                    'ainkawa'      => ['ar' => 'عينكاوة',          'en' => 'Ainkawa',       'tr' => 'Ainkawa'],
                    'shaqlawa'     => ['ar' => 'شقلاوة',           'en' => 'Shaqlawa',      'tr' => 'Shaqlawa'],
                    'soran'        => ['ar' => 'صوران',            'en' => 'Soran',         'tr' => 'Soran'],
                ]],
            'sulaymaniyah'=> ['name' => ['ar' => 'السليمانية',     'en' => 'Sulaymaniyah', 'tr' => 'Süleymaniye'],
                'districts' => [
                    'sulaymaniyah_merkez'=>['ar'=>'السليمانية المركز','en'=>'Sulaymaniyah Center','tr'=>'Süleymaniye Merkez'],
                    'ranya'        => ['ar' => 'رانية',            'en' => 'Ranya',         'tr' => 'Ranya'],
                    'halabja'      => ['ar' => 'حلبجة',            'en' => 'Halabja',       'tr' => 'Halabja'],
                ]],
            'najaf'      => ['name' => ['ar' => 'النجف',           'en' => 'Najaf',         'tr' => 'Necef'],
                'districts' => [
                    'najaf_merkez' => ['ar' => 'النجف المركز',     'en' => 'Najaf Center',  'tr' => 'Necef Merkez'],
                    'kufa'         => ['ar' => 'الكوفة',           'en' => 'Kufa',          'tr' => 'Kufa'],
                ]],
            'basra'      => ['name' => ['ar' => 'البصرة',          'en' => 'Basra',         'tr' => 'Basra'],
                'districts' => [
                    'basra_merkez' => ['ar' => 'البصرة المركز',    'en' => 'Basra Center',  'tr' => 'Basra Merkez'],
                    'zubair'       => ['ar' => 'الزبير',           'en' => 'Zubair',        'tr' => 'Zubair'],
                    'qurna'        => ['ar' => 'القرنة',           'en' => 'Qurna',         'tr' => 'Qurna'],
                ]],
            'kirkuk'     => ['name' => ['ar' => 'كركوك',           'en' => 'Kirkuk',        'tr' => 'Kerkük'],
                'districts' => [
                    'kirkuk_merkez'=> ['ar' => 'كركوك المركز',     'en' => 'Kirkuk Center', 'tr' => 'Kerkük Merkez'],
                ]],
        ],
    ],

    'AE' => [
        'name' => ['ar' => 'الإمارات', 'en' => 'UAE', 'tr' => 'BAE'],
        'provinces' => [
            'dubai'      => ['name' => ['ar' => 'دبي',             'en' => 'Dubai',         'tr' => 'Dubai'],
                'districts' => [
                    'downtown'     => ['ar' => 'وسط المدينة',      'en' => 'Downtown Dubai','tr' => 'Downtown Dubai'],
                    'marina'       => ['ar' => 'مارينا',            'en' => 'Dubai Marina',  'tr' => 'Dubai Marina'],
                    'jvc'          => ['ar' => 'قرية الجميرا',     'en' => 'JVC',           'tr' => 'JVC'],
                    'palm'         => ['ar' => 'نخلة الجميرا',     'en' => 'Palm Jumeirah', 'tr' => 'Palm Jumeirah'],
                    'deira'        => ['ar' => 'ديرة',             'en' => 'Deira',         'tr' => 'Deira'],
                    'bur_dubai'    => ['ar' => 'بر دبي',           'en' => 'Bur Dubai',     'tr' => 'Bur Dubai'],
                    'business_bay' => ['ar' => 'الخليج التجاري',   'en' => 'Business Bay',  'tr' => 'Business Bay'],
                    'jumeirah'     => ['ar' => 'الجميرا',          'en' => 'Jumeirah',      'tr' => 'Jumeirah'],
                    'mirdif'       => ['ar' => 'مردف',             'en' => 'Mirdif',        'tr' => 'Mirdif'],
                ]],
            'abudhabi'   => ['name' => ['ar' => 'أبوظبي',          'en' => 'Abu Dhabi',     'tr' => 'Abu Dabi'],
                'districts' => [
                    'corniche'     => ['ar' => 'الكورنيش',         'en' => 'Corniche',      'tr' => 'Corniche'],
                    'khalidiyah'   => ['ar' => 'الخالدية',         'en' => 'Al Khalidiyah', 'tr' => 'Al Khalidiyah'],
                    'reem'         => ['ar' => 'جزيرة الريم',      'en' => 'Reem Island',   'tr' => 'Reem Island'],
                    'yas'          => ['ar' => 'جزيرة ياس',        'en' => 'Yas Island',    'tr' => 'Yas Island'],
                ]],
            'sharjah'    => ['name' => ['ar' => 'الشارقة',          'en' => 'Sharjah',       'tr' => 'Şarika'],
                'districts' => [
                    'sharjah_merkez'=>['ar' => 'الشارقة المركز',   'en' => 'Sharjah Center','tr' => 'Şarika Merkez'],
                    'al_nahda'     => ['ar' => 'النهضة',           'en' => 'Al Nahda',      'tr' => 'Al Nahda'],
                ]],
            'ajman'      => ['name' => ['ar' => 'عجمان',            'en' => 'Ajman',         'tr' => 'Acman'],
                'districts' => [
                    'ajman_merkez' => ['ar' => 'عجمان المركز',     'en' => 'Ajman Center',  'tr' => 'Acman Merkez'],
                ]],
            'ras_al_khaimah'=>['name' => ['ar' => 'رأس الخيمة',    'en' => 'Ras Al Khaimah','tr'=> 'Ras Al Khaimah'],
                'districts' => [
                    'rak_merkez'   => ['ar' => 'رأس الخيمة المركز','en' => 'RAK Center',    'tr' => 'RAK Merkez'],
                ]],
        ],
    ],

    'SA' => [
        'name' => ['ar' => 'السعودية', 'en' => 'Saudi Arabia', 'tr' => 'Suudi Arabistan'],
        'provinces' => [
            'riyadh'     => ['name' => ['ar' => 'الرياض',           'en' => 'Riyadh',        'tr' => 'Riyad'],
                'districts' => [
                    'olaya'        => ['ar' => 'العليا',            'en' => 'Olaya',         'tr' => 'Olaya'],
                    'malaz'        => ['ar' => 'الملز',             'en' => 'Al Malaz',      'tr' => 'Al Malaz'],
                    'nakheel'      => ['ar' => 'النخيل',            'en' => 'Al Nakheel',    'tr' => 'Al Nakheel'],
                    'diplomatic'   => ['ar' => 'الحي الدبلوماسي',  'en' => 'Diplomatic Quarter','tr'=>'Diplomatik Mahalle'],
                ]],
            'jeddah'     => ['name' => ['ar' => 'جدة',              'en' => 'Jeddah',        'tr' => 'Cidde'],
                'districts' => [
                    'corniche'     => ['ar' => 'الكورنيش',         'en' => 'Corniche',      'tr' => 'Corniche'],
                    'balad'        => ['ar' => 'البلد التاريخي',    'en' => 'Al Balad',      'tr' => 'Al Balad'],
                    'hamra'        => ['ar' => 'الحمراء',           'en' => 'Al Hamra',      'tr' => 'Al Hamra'],
                ]],
            'mecca'      => ['name' => ['ar' => 'مكة المكرمة',      'en' => 'Mecca',         'tr' => 'Mekke'],
                'districts' => [
                    'haram'        => ['ar' => 'الحرم المكي',      'en' => 'Al Haram',      'tr' => 'El Haram'],
                    'aziziyah'     => ['ar' => 'العزيزية',         'en' => 'Al Aziziyah',   'tr' => 'Al Aziziyah'],
                ]],
            'medina'     => ['name' => ['ar' => 'المدينة المنورة',   'en' => 'Medina',        'tr' => 'Medine'],
                'districts' => [
                    'nabawi'       => ['ar' => 'المسجد النبوي',    'en' => 'Nabawi Area',   'tr' => 'Nebevi Bölge'],
                ]],
            'dammam'     => ['name' => ['ar' => 'الدمام',            'en' => 'Dammam',        'tr' => 'Dammam'],
                'districts' => [
                    'dammam_merkez'=> ['ar' => 'الدمام المركز',    'en' => 'Dammam Center', 'tr' => 'Dammam Merkez'],
                ]],
        ],
    ],

    'JO' => [
        'name' => ['ar' => 'الأردن', 'en' => 'Jordan', 'tr' => 'Ürdün'],
        'provinces' => [
            'amman'      => ['name' => ['ar' => 'عمّان',             'en' => 'Amman',         'tr' => 'Amman'],
                'districts' => [
                    'abdali'       => ['ar' => 'العبدلي',           'en' => 'Abdali',        'tr' => 'Abdali'],
                    'sweifieh'     => ['ar' => 'الصويفية',          'en' => 'Sweifieh',      'tr' => 'Sweifieh'],
                    'jabal_amman'  => ['ar' => 'جبل عمان',          'en' => 'Jabal Amman',   'tr' => 'Jabal Amman'],
                    'khalda'       => ['ar' => 'خلدا',              'en' => 'Khalda',        'tr' => 'Khalda'],
                ]],
            'irbid'      => ['name' => ['ar' => 'إربد',              'en' => 'Irbid',         'tr' => 'İrbid'],
                'districts' => [
                    'irbid_merkez' => ['ar' => 'إربد المركز',       'en' => 'Irbid Center',  'tr' => 'İrbid Merkez'],
                ]],
            'aqaba'      => ['name' => ['ar' => 'العقبة',            'en' => 'Aqaba',         'tr' => 'Akabe'],
                'districts' => [
                    'aqaba_merkez' => ['ar' => 'العقبة المركز',     'en' => 'Aqaba Center',  'tr' => 'Akabe Merkez'],
                ]],
        ],
    ],

    'EG' => [
        'name' => ['ar' => 'مصر', 'en' => 'Egypt', 'tr' => 'Mısır'],
        'provinces' => [
            'cairo'      => ['name' => ['ar' => 'القاهرة',           'en' => 'Cairo',         'tr' => 'Kahire'],
                'districts' => [
                    'zamalek'      => ['ar' => 'الزمالك',           'en' => 'Zamalek',       'tr' => 'Zamalek'],
                    'maadi'        => ['ar' => 'المعادي',            'en' => 'Maadi',         'tr' => 'Maadi'],
                    'heliopolis'   => ['ar' => 'مصر الجديدة',        'en' => 'Heliopolis',    'tr' => 'Heliopolis'],
                    'nasr_city'    => ['ar' => 'مدينة نصر',         'en' => 'Nasr City',     'tr' => 'Nasr City'],
                    'new_cairo'    => ['ar' => 'القاهرة الجديدة',    'en' => 'New Cairo',     'tr' => 'Yeni Kahire'],
                    'october'      => ['ar' => 'مدينة أكتوبر',      'en' => '6th October',   'tr' => '6 Ekim'],
                ]],
            'alexandria' => ['name' => ['ar' => 'الإسكندرية',        'en' => 'Alexandria',    'tr' => 'İskenderiye'],
                'districts' => [
                    'montaza'      => ['ar' => 'المنتزه',            'en' => 'Montaza',       'tr' => 'Montaza'],
                    'smouha'       => ['ar' => 'سموحة',              'en' => 'Smouha',        'tr' => 'Smouha'],
                ]],
            'hurghada'   => ['name' => ['ar' => 'الغردقة',            'en' => 'Hurghada',      'tr' => 'Hurghada'],
                'districts' => [
                    'hurghada_merkez'=>['ar'=>'الغردقة المركز',     'en' => 'Hurghada Center','tr'=> 'Hurghada Merkez'],
                    'sahl_hashish'  => ['ar' => 'سهل حشيش',         'en' => 'Sahl Hashish',  'tr' => 'Sahl Hashish'],
                ]],
            'sharm'      => ['name' => ['ar' => 'شرم الشيخ',          'en' => 'Sharm El Sheikh','tr'=> 'Şarm El Şeyh'],
                'districts' => [
                    'naama_bay'    => ['ar' => 'خليج نعمة',          'en' => 'Naama Bay',     'tr' => 'Naama Bay'],
                ]],
        ],
    ],

    'KW' => [
        'name' => ['ar' => 'الكويت', 'en' => 'Kuwait', 'tr' => 'Kuveyt'],
        'provinces' => [
            'kuwait_city'=> ['name' => ['ar' => 'مدينة الكويت',      'en' => 'Kuwait City',   'tr' => 'Kuveyt Şehri'],
                'districts' => [
                    'salmiya'      => ['ar' => 'السالمية',           'en' => 'Salmiya',       'tr' => 'Salmiya'],
                    'sharq'        => ['ar' => 'شرق',                'en' => 'Sharq',         'tr' => 'Sharq'],
                    'rumaithiya'   => ['ar' => 'الرميثية',           'en' => 'Rumaithiya',    'tr' => 'Rumaithiya'],
                ]],
            'hawalli'    => ['name' => ['ar' => 'حولي',               'en' => 'Hawalli',       'tr' => 'Havalli'],
                'districts' => [
                    'hawalli_merkez'=>['ar' => 'حولي المركز',        'en' => 'Hawalli Center','tr' => 'Havalli Merkez'],
                ]],
        ],
    ],

    'QA' => [
        'name' => ['ar' => 'قطر', 'en' => 'Qatar', 'tr' => 'Katar'],
        'provinces' => [
            'doha'       => ['name' => ['ar' => 'الدوحة',             'en' => 'Doha',          'tr' => 'Doha'],
                'districts' => [
                    'west_bay'     => ['ar' => 'الخليج الغربي',      'en' => 'West Bay',      'tr' => 'West Bay'],
                    'pearl'        => ['ar' => 'اللؤلؤة',             'en' => 'The Pearl',     'tr' => 'The Pearl'],
                    'msheireb'     => ['ar' => 'مشيرب',              'en' => 'Msheireb',      'tr' => 'Msheireb'],
                ]],
            'al_rayyan'  => ['name' => ['ar' => 'الريان',             'en' => 'Al Rayyan',     'tr' => 'Al Rayyan'],
                'districts' => [
                    'rayyan_merkez'=> ['ar' => 'الريان المركز',      'en' => 'Al Rayyan Center','tr'=>'Al Rayyan Merkez'],
                ]],
        ],
    ],

    'OTHER' => [
        'name' => ['ar' => 'أخرى', 'en' => 'Other', 'tr' => 'Diğer'],
        'provinces' => [],
    ],
];
