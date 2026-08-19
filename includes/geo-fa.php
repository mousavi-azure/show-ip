<?php
declare(strict_types=1);

/**
 * Persian display names for geo values ipdata.co always returns in English
 * (country_name, continent_name, region, city). Used only when $lang==='fa'
 * (see geoLocalize() in helpers.php). Anything not listed here falls back to
 * the original API string — better to show true English than hide data.
 *
 * - 'countries'/'continents' are keyed by the API's *_code fields (stable,
 *   unambiguous ISO codes).
 * - 'places' covers Iranian provinces/cities (the primary audience) plus a
 *   curated set of major world/VPN-hub cities, keyed by lowercase English
 *   name. It intentionally does not attempt full global region coverage
 *   (US states, German Länder, etc.) — that's a much larger dataset with
 *   little payoff for this site's audience; add entries here as needed.
 *
 * @return array{countries:array<string,string>,continents:array<string,string>,places:array<string,string>}
 */
return [

    'continents' => [
        'AF' => 'آفریقا',
        'AN' => 'جنوبگان',
        'AS' => 'آسیا',
        'EU' => 'اروپا',
        'NA' => 'آمریکای شمالی',
        'OC' => 'اقیانوسیه',
        'SA' => 'آمریکای جنوبی',
    ],

    'countries' => [
        // --- Asia ---
        'AF' => 'افغانستان', 'AM' => 'ارمنستان', 'AZ' => 'آذربایجان', 'BH' => 'بحرین',
        'BD' => 'بنگلادش', 'BT' => 'بوتان', 'BN' => 'برونئی', 'KH' => 'کامبوج',
        'CN' => 'چین', 'CY' => 'قبرس', 'GE' => 'گرجستان', 'HK' => 'هنگ‌کنگ',
        'IN' => 'هند', 'ID' => 'اندونزی', 'IR' => 'ایران', 'IQ' => 'عراق',
        'IL' => 'اسرائیل', 'JP' => 'ژاپن', 'JO' => 'اردن', 'KZ' => 'قزاقستان',
        'KW' => 'کویت', 'KG' => 'قرقیزستان', 'LA' => 'لائوس', 'LB' => 'لبنان',
        'MO' => 'ماکائو', 'MY' => 'مالزی', 'MV' => 'مالدیو', 'MN' => 'مغولستان',
        'MM' => 'میانمار', 'NP' => 'نپال', 'KP' => 'کره شمالی', 'OM' => 'عمان',
        'PK' => 'پاکستان', 'PS' => 'فلسطین', 'PH' => 'فیلیپین', 'QA' => 'قطر',
        'SA' => 'عربستان سعودی', 'SG' => 'سنگاپور', 'KR' => 'کره جنوبی', 'LK' => 'سری‌لانکا',
        'SY' => 'سوریه', 'TW' => 'تایوان', 'TJ' => 'تاجیکستان', 'TH' => 'تایلند',
        'TL' => 'تیمور شرقی', 'TR' => 'ترکیه', 'TM' => 'ترکمنستان', 'AE' => 'امارات متحده عربی',
        'UZ' => 'ازبکستان', 'VN' => 'ویتنام', 'YE' => 'یمن',

        // --- Europe ---
        'AL' => 'آلبانی', 'AD' => 'آندورا', 'AT' => 'اتریش', 'BY' => 'بلاروس',
        'BE' => 'بلژیک', 'BA' => 'بوسنی و هرزگوین', 'BG' => 'بلغارستان', 'HR' => 'کرواسی',
        'CZ' => 'جمهوری چک', 'DK' => 'دانمارک', 'EE' => 'استونی', 'FO' => 'جزایر فارو',
        'FI' => 'فنلاند', 'FR' => 'فرانسه', 'DE' => 'آلمان', 'GI' => 'جبل‌الطارق',
        'GR' => 'یونان', 'HU' => 'مجارستان', 'IS' => 'ایسلند', 'IE' => 'ایرلند',
        'IT' => 'ایتالیا', 'XK' => 'کوزوو', 'LV' => 'لتونی', 'LI' => 'لیختن‌اشتاین',
        'LT' => 'لیتوانی', 'LU' => 'لوکزامبورگ', 'MT' => 'مالت', 'MD' => 'مولداوی',
        'MC' => 'موناکو', 'ME' => 'مونته‌نگرو', 'NL' => 'هلند', 'MK' => 'مقدونیه شمالی',
        'NO' => 'نروژ', 'PL' => 'لهستان', 'PT' => 'پرتغال', 'RO' => 'رومانی',
        'RU' => 'روسیه', 'SM' => 'سان‌مارینو', 'RS' => 'صربستان', 'SK' => 'اسلواکی',
        'SI' => 'اسلوونی', 'ES' => 'اسپانیا', 'SE' => 'سوئد', 'CH' => 'سوئیس',
        'UA' => 'اوکراین', 'GB' => 'بریتانیا', 'VA' => 'واتیکان', 'AX' => 'جزایر الند',

        // --- Africa ---
        'DZ' => 'الجزایر', 'AO' => 'آنگولا', 'BJ' => 'بنین', 'BW' => 'بوتسوانا',
        'BF' => 'بورکینافاسو', 'BI' => 'بوروندی', 'CV' => 'کیپ ورد', 'CM' => 'کامرون',
        'CF' => 'جمهوری آفریقای مرکزی', 'TD' => 'چاد', 'KM' => 'کومور', 'CG' => 'کنگو',
        'CD' => 'کنگوی دموکراتیک', 'CI' => 'ساحل عاج', 'DJ' => 'جیبوتی', 'EG' => 'مصر',
        'GQ' => 'گینه استوایی', 'ER' => 'اریتره', 'SZ' => 'اسواتینی', 'ET' => 'اتیوپی',
        'GA' => 'گابن', 'GM' => 'گامبیا', 'GH' => 'غنا', 'GN' => 'گینه',
        'GW' => 'گینه بیسائو', 'KE' => 'کنیا', 'LS' => 'لسوتو', 'LR' => 'لیبریا',
        'LY' => 'لیبی', 'MG' => 'ماداگاسکار', 'MW' => 'مالاوی', 'ML' => 'مالی',
        'MR' => 'موریتانی', 'MU' => 'موریس', 'YT' => 'مایوت', 'MA' => 'مراکش',
        'MZ' => 'موزامبیک', 'NA' => 'نامیبیا', 'NE' => 'نیجر', 'NG' => 'نیجریه',
        'RE' => 'رئونیون', 'RW' => 'رواندا', 'SH' => 'سنت هلن', 'ST' => 'سائوتومه و پرینسیپ',
        'SN' => 'سنگال', 'SC' => 'سیشل', 'SL' => 'سیرالئون', 'SO' => 'سومالی',
        'ZA' => 'آفریقای جنوبی', 'SS' => 'سودان جنوبی', 'SD' => 'سودان', 'TZ' => 'تانزانیا',
        'TG' => 'توگو', 'TN' => 'تونس', 'UG' => 'اوگاندا', 'EH' => 'صحرای غربی',
        'ZM' => 'زامبیا', 'ZW' => 'زیمبابوه',

        // --- Americas ---
        'AI' => 'آنگویلا', 'AG' => 'آنتیگوا و باربودا', 'AR' => 'آرژانتین', 'AW' => 'آروبا',
        'BS' => 'باهاما', 'BB' => 'باربادوس', 'BZ' => 'بلیز', 'BM' => 'برمودا',
        'BO' => 'بولیوی', 'BR' => 'برزیل', 'VG' => 'جزایر ویرجین بریتانیا', 'CA' => 'کانادا',
        'KY' => 'جزایر کیمن', 'CL' => 'شیلی', 'CO' => 'کلمبیا', 'CR' => 'کاستاریکا',
        'CU' => 'کوبا', 'CW' => 'کوراسائو', 'DM' => 'دومینیکا', 'DO' => 'جمهوری دومینیکن',
        'EC' => 'اکوادور', 'SV' => 'السالوادور', 'FK' => 'جزایر فالکلند', 'GF' => 'گویان فرانسه',
        'GL' => 'گرینلند', 'GD' => 'گرنادا', 'GP' => 'گوادلوپ', 'GT' => 'گواتمالا',
        'GY' => 'گویان', 'HT' => 'هائیتی', 'HN' => 'هندوراس', 'JM' => 'جامائیکا',
        'MQ' => 'مارتینیک', 'MX' => 'مکزیک', 'MS' => 'مونتسرات', 'NI' => 'نیکاراگوئه',
        'PA' => 'پاناما', 'PY' => 'پاراگوئه', 'PE' => 'پرو', 'PR' => 'پورتوریکو',
        'BL' => 'سن بارتلمی', 'KN' => 'سنت کیتس و نویس', 'LC' => 'سنت لوسیا', 'MF' => 'سنت مارتین',
        'PM' => 'سن‌پیر و میکلن', 'VC' => 'سنت وینسنت و گرنادین‌ها', 'SX' => 'سینت مارتن', 'SR' => 'سورینام',
        'TT' => 'ترینیداد و توباگو', 'TC' => 'جزایر تورکس و کایکوس', 'US' => 'ایالات متحده آمریکا', 'UY' => 'اروگوئه',
        'VE' => 'ونزوئلا', 'VI' => 'جزایر ویرجین آمریکا',

        // --- Oceania ---
        'AS' => 'ساموآی آمریکا', 'AU' => 'استرالیا', 'CX' => 'جزیره کریسمس', 'CC' => 'جزایر کوکوس',
        'CK' => 'جزایر کوک', 'FJ' => 'فیجی', 'PF' => 'پلی‌نزی فرانسه', 'GU' => 'گوام',
        'KI' => 'کیریباتی', 'MH' => 'جزایر مارشال', 'FM' => 'میکرونزی', 'NR' => 'نائورو',
        'NC' => 'کالدونیای جدید', 'NZ' => 'نیوزیلند', 'NU' => 'نیوئه', 'NF' => 'جزیره نورفولک',
        'MP' => 'جزایر ماریانای شمالی', 'PW' => 'پالائو', 'PG' => 'پاپوآ گینه نو', 'PN' => 'پیتکرن',
        'WS' => 'ساموآ', 'SB' => 'جزایر سلیمان', 'TK' => 'توکلائو', 'TO' => 'تونگا',
        'TV' => 'تووالو', 'VU' => 'وانواتو', 'WF' => 'والیس و فوتونا',

        // --- Other / polar territories occasionally seen in GeoIP data ---
        'AQ' => 'جنوبگان', 'BV' => 'جزیره بووه', 'IO' => 'قلمرو بریتانیا در اقیانوس هند',
        'GS' => 'جورجیای جنوبی', 'HM' => 'جزایر هرد و مک‌دونالد', 'SJ' => 'سوالبارد و یان ماین',
        'TF' => 'سرزمین‌های جنوبی فرانسه', 'UM' => 'جزایر کوچک حاشیه‌ای آمریکا',
    ],

    'places' => [
        // ===== Iran — 31 provinces (ostans), incl. common alternate spellings =====
        'tehran' => 'تهران', 'alborz' => 'البرز', 'qom' => 'قم', 'markazi' => 'مرکزی',
        'qazvin' => 'قزوین', 'gilan' => 'گیلان', 'ardabil' => 'اردبیل', 'zanjan' => 'زنجان',
        'east azerbaijan' => 'آذربایجان شرقی', 'west azerbaijan' => 'آذربایجان غربی',
        'kurdistan' => 'کردستان', 'kordestan' => 'کردستان', 'hamadan' => 'همدان', 'hamedan' => 'همدان',
        'kermanshah' => 'کرمانشاه', 'ilam' => 'ایلام', 'lorestan' => 'لرستان', 'khuzestan' => 'خوزستان',
        'chaharmahal and bakhtiari' => 'چهارمحال و بختیاری', 'chaharmahal va bakhtiari' => 'چهارمحال و بختیاری',
        'kohgiluyeh and boyer-ahmad' => 'کهگیلویه و بویراحمد', 'kohgiluyeh and boyerahmad' => 'کهگیلویه و بویراحمد',
        'bushehr' => 'بوشهر', 'fars' => 'فارس', 'hormozgan' => 'هرمزگان',
        'sistan and baluchestan' => 'سیستان و بلوچستان', 'sistan va baluchestan' => 'سیستان و بلوچستان',
        'kerman' => 'کرمان', 'yazd' => 'یزد', 'isfahan' => 'اصفهان', 'esfahan' => 'اصفهان',
        'semnan' => 'سمنان', 'mazandaran' => 'مازندران', 'golestan' => 'گلستان',
        'north khorasan' => 'خراسان شمالی', 'razavi khorasan' => 'خراسان رضوی', 'south khorasan' => 'خراسان جنوبی',

        // ===== Iran — major cities =====
        'mashhad' => 'مشهد', 'karaj' => 'کرج', 'shiraz' => 'شیراز', 'tabriz' => 'تبریز',
        'ahvaz' => 'اهواز', 'ahwaz' => 'اهواز', 'urmia' => 'ارومیه', 'orumiyeh' => 'ارومیه',
        'rasht' => 'رشت', 'zahedan' => 'زاهدان', 'bandar abbas' => 'بندرعباس', 'arak' => 'اراک',
        'eslamshahr' => 'اسلام‌شهر', 'islamshahr' => 'اسلام‌شهر', 'sanandaj' => 'سنندج',
        'khorramabad' => 'خرم‌آباد', 'gorgan' => 'گرگان', 'sari' => 'ساری', 'birjand' => 'بیرجند',
        'bojnurd' => 'بجنورد', 'bojnord' => 'بجنورد', 'yasuj' => 'یاسوج', 'shahrekord' => 'شهرکرد',
        'shahriar' => 'شهریار', 'varamin' => 'ورامین', 'sabzevar' => 'سبزوار', 'neyshabur' => 'نیشابور',
        'nishapur' => 'نیشابور', 'malayer' => 'ملایر', 'marivan' => 'مریوان', 'saqqez' => 'سقز',
        'khoy' => 'خوی', 'maragheh' => 'مراغه', 'najafabad' => 'نجف‌آباد', 'kashan' => 'کاشان',
        'dezful' => 'دزفول', 'andimeshk' => 'اندیمشک', 'abadan' => 'آبادان', 'khorramshahr' => 'خرمشهر',
        'bandar-e anzali' => 'بندر انزلی', 'anzali' => 'بندر انزلی', 'amol' => 'آمل', 'babol' => 'بابل',
        'qaemshahr' => 'قائم‌شهر', 'torbat-e heydarieh' => 'تربت حیدریه', 'pakdasht' => 'پاکدشت',
        'robat karim' => 'رباط کریم', 'malard' => 'ملارد', 'qods' => 'قدس', 'ahar' => 'اهر',
        'mahabad' => 'مهاباد', 'bukan' => 'بوکان', 'piranshahr' => 'پیرانشهر', 'marand' => 'مرند',
        'miandoab' => 'میاندوآب', 'khomeyni shahr' => 'خمینی‌شهر', 'shahin shahr' => 'شاهین‌شهر',
        'fasa' => 'فسا', 'jahrom' => 'جهرم', 'marvdasht' => 'مرودشت', 'kazerun' => 'کازرون',
        'lar' => 'لار', 'minab' => 'میناب', 'jiroft' => 'جیرفت', 'rafsanjan' => 'رفسنجان',
        'sirjan' => 'سیرجان', 'bam' => 'بم', 'zabol' => 'زابل', 'chabahar' => 'چابهار',
        'iranshahr' => 'ایرانشهر', 'gonbad-e kavus' => 'گنبد کاووس', 'behshahr' => 'بهشهر',
        'nowshahr' => 'نوشهر', 'chalus' => 'چالوس', 'ramsar' => 'رامسر', 'lahijan' => 'لاهیجان',
        'langarud' => 'لنگرود', 'astara' => 'آستارا', 'talesh' => 'تالش', 'naghadeh' => 'نقده',
        'sarab' => 'سراب', 'shabestar' => 'شبستر', 'damavand' => 'دماوند', 'firuzkuh' => 'فیروزکوه',
        'pardis' => 'پردیس', 'qarchak' => 'قرچک', 'nasimshahr' => 'نسیم‌شهر', 'baharestan' => 'بهارستان',
        'fardis' => 'فردیس', 'hashtgerd' => 'هشتگرد', 'bandar-e mahshahr' => 'بندر ماهشهر',
        'mahshahr' => 'بندر ماهشهر', 'behbahan' => 'بهبهان', 'susangerd' => 'سوسنگرد',
        'ramhormoz' => 'رامهرمز', 'shadegan' => 'شادگان',

        // ===== Common global cities (VPN/datacenter hubs & major capitals) =====
        'frankfurt' => 'فرانکفورت', 'frankfurt am main' => 'فرانکفورت', 'amsterdam' => 'آمستردام',
        'paris' => 'پاریس', 'london' => 'لندن', 'berlin' => 'برلین', 'munich' => 'مونیخ',
        'vienna' => 'وین', 'zurich' => 'زوریخ', 'geneva' => 'ژنو', 'stockholm' => 'استکهلم',
        'oslo' => 'اسلو', 'copenhagen' => 'کپنهاگ', 'helsinki' => 'هلسینکی', 'warsaw' => 'ورشو',
        'prague' => 'پراگ', 'budapest' => 'بوداپست', 'bucharest' => 'بخارست', 'sofia' => 'صوفیه',
        'athens' => 'آتن', 'istanbul' => 'استانبول', 'ankara' => 'آنکارا', 'izmir' => 'ازمیر',
        'moscow' => 'مسکو', 'saint petersburg' => 'سن‌پترزبورگ', 'kyiv' => 'کی‌یف', 'minsk' => 'مینسک',
        'dublin' => 'دوبلین', 'brussels' => 'بروکسل', 'madrid' => 'مادرید', 'barcelona' => 'بارسلونا',
        'lisbon' => 'لیسبون', 'rome' => 'رم', 'milan' => 'میلان', 'dubai' => 'دبی',
        'abu dhabi' => 'ابوظبی', 'doha' => 'دوحه', 'riyadh' => 'ریاض', 'jeddah' => 'جده',
        'muscat' => 'مسقط', 'manama' => 'منامه', 'kuwait city' => 'کویت', 'baghdad' => 'بغداد',
        'erbil' => 'اربیل', 'beirut' => 'بیروت', 'yerevan' => 'ایروان', 'baku' => 'باکو',
        'tbilisi' => 'تفلیس', 'almaty' => 'آلماتی', 'tashkent' => 'تاشکند', 'new york' => 'نیویورک',
        'los angeles' => 'لس‌آنجلس', 'chicago' => 'شیکاگو', 'dallas' => 'دالاس', 'miami' => 'میامی',
        'san francisco' => 'سان‌فرانسیسکو', 'seattle' => 'سیاتل', 'washington' => 'واشنگتن',
        'ashburn' => 'اشبرن', 'toronto' => 'تورنتو', 'montreal' => 'مونترال', 'vancouver' => 'ونکوور',
        'mexico city' => 'مکزیکوسیتی', 'sao paulo' => 'سائوپائولو', 'buenos aires' => 'بوینس‌آیرس',
        'singapore' => 'سنگاپور', 'tokyo' => 'توکیو', 'osaka' => 'اوزاکا', 'seoul' => 'سئول',
        'hong kong' => 'هنگ‌کنگ', 'shanghai' => 'شانگهای', 'beijing' => 'پکن', 'mumbai' => 'بمبئی',
        'new delhi' => 'دهلی‌نو', 'delhi' => 'دهلی', 'bangkok' => 'بانکوک', 'kuala lumpur' => 'کوالالامپور',
        'jakarta' => 'جاکارتا', 'manila' => 'مانیل', 'sydney' => 'سیدنی', 'melbourne' => 'ملبورن',
        'auckland' => 'اوکلند', 'cairo' => 'قاهره', 'casablanca' => 'کازابلانکا',
        'johannesburg' => 'ژوهانسبورگ', 'lagos' => 'لاگوس', 'nairobi' => 'نایروبی',
    ],
];
