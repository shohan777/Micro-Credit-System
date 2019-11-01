-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2018 at 06:54 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `new-uttara-shanchoi`
--

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(10) UNSIGNED NOT NULL,
  `iso` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nicename` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `iso3` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `numcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phonecode` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `iso`, `name`, `nicename`, `iso3`, `numcode`, `phonecode`) VALUES
(1, 'AF', 'AFGHANISTAN', 'Afghanistan', 'AFG', '4', '93'),
(2, 'AL', 'ALBANIA', 'Albania', 'ALB', '8', '355'),
(3, 'DZ', 'ALGERIA', 'Algeria', 'DZA', '12', '213'),
(4, 'AS', 'AMERICAN SAMOA', 'American Samoa', 'ASM', '16', '168'),
(6, 'AO', 'ANGOLA', 'Angola', 'AGO', '24', '244'),
(7, 'AI', 'ANGUILLA', 'Anguilla', 'AIA', '660', '126'),
(8, 'AQ', 'ANTARCTICA', 'Antarctica', NULL, NULL, '0'),
(9, 'AG', 'ANTIGUA AND BARBUDA', 'Antigua and Barbuda', 'ATG', '28', '126'),
(10, 'AR', 'ARGENTINA', 'Argentina', 'ARG', '32', '54'),
(11, 'AM', 'ARMENIA', 'Armenia', 'ARM', '51', '374'),
(12, 'AW', 'ARUBA', 'Aruba', 'ABW', '533', '297'),
(13, 'AU', 'AUSTRALIA', 'Australia', 'AUS', '36', '61'),
(14, 'AT', 'AUSTRIA', 'Austria', 'AUT', '40', '43'),
(15, 'AZ', 'AZERBAIJAN', 'Azerbaijan', 'AZE', '31', '994'),
(16, 'BS', 'BAHAMAS', 'Bahamas', 'BHS', '44', '124'),
(17, 'BH', 'BAHRAIN', 'Bahrain', 'BHR', '48', '973'),
(18, 'BD', 'BANGLADESH', 'Bangladesh', 'BGD', '50', '880'),
(19, 'BB', 'BARBADOS', 'Barbados', 'BRB', '52', '124'),
(20, 'BY', 'BELARUS', 'Belarus', 'BLR', '112', '375'),
(21, 'BE', 'BELGIUM', 'Belgium', 'BEL', '56', '32'),
(22, 'BZ', 'BELIZE', 'Belize', 'BLZ', '84', '501'),
(23, 'BJ', 'BENIN', 'Benin', 'BEN', '204', '229'),
(24, 'BM', 'BERMUDA', 'Bermuda', 'BMU', '60', '144'),
(25, 'BT', 'BHUTAN', 'Bhutan', 'BTN', '64', '975'),
(26, 'BO', 'BOLIVIA', 'Bolivia', 'BOL', '68', '591'),
(27, 'BA', 'BOSNIA AND HERZEGOVINA', 'Bosnia and Herzegovina', 'BIH', '70', '387'),
(28, 'BW', 'BOTSWANA', 'Botswana', 'BWA', '72', '267'),
(29, 'BV', 'BOUVET ISLAND', 'Bouvet Island', NULL, NULL, '0'),
(30, 'BR', 'BRAZIL', 'Brazil', 'BRA', '76', '55'),
(31, 'IO', 'BRITISH INDIAN OCEAN TERRITORY', 'British Indian Ocean Territory', NULL, NULL, '246'),
(32, 'BN', 'BRUNEI DARUSSALAM', 'Brunei Darussalam', 'BRN', '96', '673'),
(33, 'BG', 'BULGARIA', 'Bulgaria', 'BGR', '100', '359'),
(34, 'BF', 'BURKINA FASO', 'Burkina Faso', 'BFA', '854', '226'),
(35, 'BI', 'BURUNDI', 'Burundi', 'BDI', '108', '257'),
(36, 'KH', 'CAMBODIA', 'Cambodia', 'KHM', '116', '855'),
(37, 'CM', 'CAMEROON', 'Cameroon', 'CMR', '120', '237'),
(38, 'CA', 'CANADA', 'Canada', 'CAN', '124', '1'),
(39, 'CV', 'CAPE VERDE', 'Cape Verde', 'CPV', '132', '238'),
(40, 'KY', 'CAYMAN ISLANDS', 'Cayman Islands', 'CYM', '136', '134'),
(41, 'CF', 'CENTRAL AFRICAN REPUBLIC', 'Central African Republic', 'CAF', '140', '236'),
(42, 'TD', 'CHAD', 'Chad', 'TCD', '148', '235'),
(43, 'CL', 'CHILE', 'Chile', 'CHL', '152', '56'),
(44, 'CN', 'CHINA', 'China', 'CHN', '156', '86'),
(45, 'CX', 'CHRISTMAS ISLAND', 'Christmas Island', NULL, NULL, '61'),
(46, 'CC', 'COCOS (KEELING) ISLANDS', 'Cocos (Keeling) Islands', NULL, NULL, '672'),
(47, 'CO', 'COLOMBIA', 'Colombia', 'COL', '170', '57'),
(48, 'KM', 'COMOROS', 'Comoros', 'COM', '174', '269'),
(49, 'CG', 'CONGO', 'Congo', 'COG', '178', '242'),
(50, 'CD', 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'Congo, the Democratic Republic of the', 'COD', '180', '242'),
(51, 'CK', 'COOK ISLANDS', 'Cook Islands', 'COK', '184', '682'),
(52, 'CR', 'COSTA RICA', 'Costa Rica', 'CRI', '188', '506'),
(53, 'CI', 'COTE D`IVOIRE', 'Cote D`Ivoire', 'CIV', '384', '225'),
(54, 'HR', 'CROATIA', 'Croatia', 'HRV', '191', '385'),
(55, 'CU', 'CUBA', 'Cuba', 'CUB', '192', '53'),
(56, 'CY', 'CYPRUS', 'Cyprus', 'CYP', '196', '357'),
(57, 'CZ', 'CZECH REPUBLIC', 'Czech Republic', 'CZE', '203', '420'),
(58, 'DK', 'DENMARK', 'Denmark', 'DNK', '208', '45'),
(59, 'DJ', 'DJIBOUTI', 'Djibouti', 'DJI', '262', '253'),
(60, 'DM', 'DOMINICA', 'Dominica', 'DMA', '212', '176'),
(61, 'DO', 'DOMINICAN REPUBLIC', 'Dominican Republic', 'DOM', '214', '180'),
(62, 'EC', 'ECUADOR', 'Ecuador', 'ECU', '218', '593'),
(63, 'EG', 'EGYPT', 'Egypt', 'EGY', '818', '20'),
(64, 'SV', 'EL SALVADOR', 'El Salvador', 'SLV', '222', '503'),
(65, 'GQ', 'EQUATORIAL GUINEA', 'Equatorial Guinea', 'GNQ', '226', '240'),
(66, 'ER', 'ERITREA', 'Eritrea', 'ERI', '232', '291'),
(67, 'EE', 'ESTONIA', 'Estonia', 'EST', '233', '372'),
(68, 'ET', 'ETHIOPIA', 'Ethiopia', 'ETH', '231', '251'),
(69, 'FK', 'FALKLAND ISLANDS (MALVINAS)', 'Falkland Islands (Malvinas)', 'FLK', '238', '500'),
(70, 'FO', 'FAROE ISLANDS', 'Faroe Islands', 'FRO', '234', '298'),
(71, 'FJ', 'FIJI', 'Fiji', 'FJI', '242', '679'),
(72, 'FI', 'FINLAND', 'Finland', 'FIN', '246', '358'),
(73, 'FR', 'FRANCE', 'France', 'FRA', '250', '33'),
(74, 'GF', 'FRENCH GUIANA', 'French Guiana', 'GUF', '254', '594'),
(75, 'PF', 'FRENCH POLYNESIA', 'French Polynesia', 'PYF', '258', '689'),
(76, 'TF', 'FRENCH SOUTHERN TERRITORIES', 'French Southern Territories', NULL, NULL, '0'),
(77, 'GA', 'GABON', 'Gabon', 'GAB', '266', '241'),
(78, 'GM', 'GAMBIA', 'Gambia', 'GMB', '270', '220'),
(79, 'GE', 'GEORGIA', 'Georgia', 'GEO', '268', '995'),
(80, 'DE', 'GERMANY', 'Germany', 'DEU', '276', '49'),
(81, 'GH', 'GHANA', 'Ghana', 'GHA', '288', '233'),
(82, 'GI', 'GIBRALTAR', 'Gibraltar', 'GIB', '292', '350'),
(83, 'GR', 'GREECE', 'Greece', 'GRC', '300', '30'),
(84, 'GL', 'GREENLAND', 'Greenland', 'GRL', '304', '299'),
(85, 'GD', 'GRENADA', 'Grenada', 'GRD', '308', '147'),
(86, 'GP', 'GUADELOUPE', 'Guadeloupe', 'GLP', '312', '590'),
(87, 'GU', 'GUAM', 'Guam', 'GUM', '316', '167'),
(88, 'GT', 'GUATEMALA', 'Guatemala', 'GTM', '320', '502'),
(89, 'GN', 'GUINEA', 'Guinea', 'GIN', '324', '224'),
(90, 'GW', 'GUINEA-BISSAU', 'Guinea-Bissau', 'GNB', '624', '245'),
(91, 'GY', 'GUYANA', 'Guyana', 'GUY', '328', '592'),
(92, 'HT', 'HAITI', 'Haiti', 'HTI', '332', '509'),
(93, 'HM', 'HEARD ISLAND AND MCDONALD ISLANDS', 'Heard Island and Mcdonald Islands', NULL, NULL, '0'),
(94, 'VA', 'HOLY SEE (VATICAN CITY STATE)', 'Holy See (Vatican City State)', 'VAT', '336', '39'),
(95, 'HN', 'HONDURAS', 'Honduras', 'HND', '340', '504'),
(96, 'HK', 'HONG KONG', 'Hong Kong', 'HKG', '344', '852'),
(97, 'HU', 'HUNGARY', 'Hungary', 'HUN', '348', '36'),
(98, 'IS', 'ICELAND', 'Iceland', 'ISL', '352', '354'),
(99, 'IN', 'INDIA', 'India', 'IND', '356', '91'),
(100, 'ID', 'INDONESIA', 'Indonesia', 'IDN', '360', '62'),
(101, 'IR', 'IRAN, ISLAMIC REPUBLIC OF', 'Iran, Islamic Republic of', 'IRN', '364', '98'),
(102, 'IQ', 'IRAQ', 'Iraq', 'IRQ', '368', '964'),
(103, 'IE', 'IRELAND', 'Ireland', 'IRL', '372', '353'),
(104, 'IL', 'ISRAEL', 'Israel', 'ISR', '376', '972'),
(105, 'IT', 'ITALY', 'Italy', 'ITA', '380', '39'),
(106, 'JM', 'JAMAICA', 'Jamaica', 'JAM', '388', '187'),
(107, 'JP', 'JAPAN', 'Japan', 'JPN', '392', '81'),
(108, 'JO', 'JORDAN', 'Jordan', 'JOR', '400', '962'),
(109, 'KZ', 'KAZAKHSTAN', 'Kazakhstan', 'KAZ', '398', '7'),
(110, 'KE', 'KENYA', 'Kenya', 'KEN', '404', '254'),
(111, 'KI', 'KIRIBATI', 'Kiribati', 'KIR', '296', '686'),
(112, 'KP', 'KOREA, DEMOCRATIC PEOPLE`S REPUBLIC OF', 'Korea, Democratic People`s Republic of', 'PRK', '408', '850'),
(113, 'KR', 'KOREA, REPUBLIC OF', 'Korea, Republic of', 'KOR', '410', '82'),
(114, 'KW', 'KUWAIT', 'Kuwait', 'KWT', '414', '965'),
(115, 'KG', 'KYRGYZSTAN', 'Kyrgyzstan', 'KGZ', '417', '996'),
(116, 'LA', 'LAO PEOPLE`S DEMOCRATIC REPUBLIC', 'Lao People`s Democratic Republic', 'LAO', '418', '856'),
(117, 'LV', 'LATVIA', 'Latvia', 'LVA', '428', '371'),
(118, 'LB', 'LEBANON', 'Lebanon', 'LBN', '422', '961'),
(119, 'LS', 'LESOTHO', 'Lesotho', 'LSO', '426', '266'),
(120, 'LR', 'LIBERIA', 'Liberia', 'LBR', '430', '231'),
(121, 'LY', 'LIBYAN ARAB JAMAHIRIYA', 'Libyan Arab Jamahiriya', 'LBY', '434', '218'),
(122, 'LI', 'LIECHTENSTEIN', 'Liechtenstein', 'LIE', '438', '423'),
(123, 'LT', 'LITHUANIA', 'Lithuania', 'LTU', '440', '370'),
(124, 'LU', 'LUXEMBOURG', 'Luxembourg', 'LUX', '442', '352'),
(125, 'MO', 'MACAO', 'Macao', 'MAC', '446', '853'),
(126, 'MK', 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'Macedonia, the Former Yugoslav Republic of', 'MKD', '807', '389'),
(127, 'MG', 'MADAGASCAR', 'Madagascar', 'MDG', '450', '261'),
(128, 'MW', 'MALAWI', 'Malawi', 'MWI', '454', '265'),
(129, 'MY', 'MALAYSIA', 'Malaysia', 'MYS', '458', '60'),
(130, 'MV', 'MALDIVES', 'Maldives', 'MDV', '462', '960'),
(131, 'ML', 'MALI', 'Mali', 'MLI', '466', '223'),
(132, 'MT', 'MALTA', 'Malta', 'MLT', '470', '356'),
(133, 'MH', 'MARSHALL ISLANDS', 'Marshall Islands', 'MHL', '584', '692'),
(134, 'MQ', 'MARTINIQUE', 'Martinique', 'MTQ', '474', '596'),
(135, 'MR', 'MAURITANIA', 'Mauritania', 'MRT', '478', '222'),
(136, 'MU', 'MAURITIUS', 'Mauritius', 'MUS', '480', '230'),
(137, 'YT', 'MAYOTTE', 'Mayotte', NULL, NULL, '269'),
(138, 'MX', 'MEXICO', 'Mexico', 'MEX', '484', '52'),
(139, 'FM', 'MICRONESIA, FEDERATED STATES OF', 'Micronesia, Federated States of', 'FSM', '583', '691'),
(140, 'MD', 'MOLDOVA, REPUBLIC OF', 'Moldova, Republic of', 'MDA', '498', '373'),
(141, 'MC', 'MONACO', 'Monaco', 'MCO', '492', '377'),
(142, 'MN', 'MONGOLIA', 'Mongolia', 'MNG', '496', '976'),
(143, 'MS', 'MONTSERRAT', 'Montserrat', 'MSR', '500', '166'),
(144, 'MA', 'MOROCCO', 'Morocco', 'MAR', '504', '212'),
(145, 'MZ', 'MOZAMBIQUE', 'Mozambique', 'MOZ', '508', '258'),
(146, 'MM', 'MYANMAR', 'Myanmar', 'MMR', '104', '95'),
(147, 'NA', 'NAMIBIA', 'Namibia', 'NAM', '516', '264'),
(148, 'NR', 'NAURU', 'Nauru', 'NRU', '520', '674'),
(149, 'NP', 'NEPAL', 'Nepal', 'NPL', '524', '977'),
(150, 'NL', 'NETHERLANDS', 'Netherlands', 'NLD', '528', '31'),
(151, 'AN', 'NETHERLANDS ANTILLES', 'Netherlands Antilles', 'ANT', '530', '599'),
(152, 'NC', 'NEW CALEDONIA', 'New Caledonia', 'NCL', '540', '687'),
(153, 'NZ', 'NEW ZEALAND', 'New Zealand', 'NZL', '554', '64'),
(154, 'NI', 'NICARAGUA', 'Nicaragua', 'NIC', '558', '505'),
(155, 'NE', 'NIGER', 'Niger', 'NER', '562', '227'),
(156, 'NG', 'NIGERIA', 'Nigeria', 'NGA', '566', '234'),
(157, 'NU', 'NIUE', 'Niue', 'NIU', '570', '683'),
(158, 'NF', 'NORFOLK ISLAND', 'Norfolk Island', 'NFK', '574', '672'),
(159, 'MP', 'NORTHERN MARIANA ISLANDS', 'Northern Mariana Islands', 'MNP', '580', '167'),
(160, 'NO', 'NORWAY', 'Norway', 'NOR', '578', '47'),
(161, 'OM', 'OMAN', 'Oman', 'OMN', '512', '968'),
(162, 'PK', 'PAKISTAN', 'Pakistan', 'PAK', '586', '92'),
(163, 'PW', 'PALAU', 'Palau', 'PLW', '585', '680'),
(164, 'PS', 'PALESTINIAN TERRITORY, OCCUPIED', 'Palestinian Territory, Occupied', NULL, NULL, '970'),
(165, 'PA', 'PANAMA', 'Panama', 'PAN', '591', '507'),
(166, 'PG', 'PAPUA NEW GUINEA', 'Papua New Guinea', 'PNG', '598', '675'),
(167, 'PY', 'PARAGUAY', 'Paraguay', 'PRY', '600', '595'),
(168, 'PE', 'PERU', 'Peru', 'PER', '604', '51'),
(169, 'PH', 'PHILIPPINES', 'Philippines', 'PHL', '608', '63'),
(170, 'PN', 'PITCAIRN', 'Pitcairn', 'PCN', '612', '0'),
(171, 'PL', 'POLAND', 'Poland', 'POL', '616', '48'),
(172, 'PT', 'PORTUGAL', 'Portugal', 'PRT', '620', '351'),
(173, 'PR', 'PUERTO RICO', 'Puerto Rico', 'PRI', '630', '178'),
(174, 'QA', 'QATAR', 'Qatar', 'QAT', '634', '974'),
(175, 'RE', 'REUNION', 'Reunion', 'REU', '638', '262'),
(176, 'RO', 'ROMANIA', 'Romania', 'ROM', '642', '40'),
(177, 'RU', 'RUSSIAN FEDERATION', 'Russian Federation', 'RUS', '643', '70'),
(178, 'RW', 'RWANDA', 'Rwanda', 'RWA', '646', '250'),
(179, 'SH', 'SAINT HELENA', 'Saint Helena', 'SHN', '654', '290'),
(180, 'KN', 'SAINT KITTS AND NEVIS', 'Saint Kitts and Nevis', 'KNA', '659', '186'),
(181, 'LC', 'SAINT LUCIA', 'Saint Lucia', 'LCA', '662', '175'),
(182, 'PM', 'SAINT PIERRE AND MIQUELON', 'Saint Pierre and Miquelon', 'SPM', '666', '508'),
(183, 'VC', 'SAINT VINCENT AND THE GRENADINES', 'Saint Vincent and the Grenadines', 'VCT', '670', '178'),
(184, 'WS', 'SAMOA', 'Samoa', 'WSM', '882', '684'),
(185, 'SM', 'SAN MARINO', 'San Marino', 'SMR', '674', '378'),
(186, 'ST', 'SAO TOME AND PRINCIPE', 'Sao Tome and Principe', 'STP', '678', '239'),
(187, 'SA', 'SAUDI ARABIA', 'Saudi Arabia', 'SAU', '682', '966'),
(188, 'SN', 'SENEGAL', 'Senegal', 'SEN', '686', '221'),
(189, 'CS', 'SERBIA AND MONTENEGRO', 'Serbia and Montenegro', NULL, NULL, '381'),
(190, 'SC', 'SEYCHELLES', 'Seychelles', 'SYC', '690', '248'),
(191, 'SL', 'SIERRA LEONE', 'Sierra Leone', 'SLE', '694', '232'),
(192, 'SG', 'SINGAPORE', 'Singapore', 'SGP', '702', '65'),
(193, 'SK', 'SLOVAKIA', 'Slovakia', 'SVK', '703', '421'),
(194, 'SI', 'SLOVENIA', 'Slovenia', 'SVN', '705', '386'),
(195, 'SB', 'SOLOMON ISLANDS', 'Solomon Islands', 'SLB', '90', '677'),
(196, 'SO', 'SOMALIA', 'Somalia', 'SOM', '706', '252'),
(197, 'ZA', 'SOUTH AFRICA', 'South Africa', 'ZAF', '710', '27'),
(198, 'GS', 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'South Georgia and the South Sandwich Islands', NULL, NULL, '0'),
(199, 'ES', 'SPAIN', 'Spain', 'ESP', '724', '34'),
(200, 'LK', 'SRI LANKA', 'Sri Lanka', 'LKA', '144', '94'),
(201, 'SD', 'SUDAN', 'Sudan', 'SDN', '736', '249'),
(202, 'SR', 'SURINAME', 'Suriname', 'SUR', '740', '597'),
(203, 'SJ', 'SVALBARD AND JAN MAYEN', 'Svalbard and Jan Mayen', 'SJM', '744', '47'),
(204, 'SZ', 'SWAZILAND', 'Swaziland', 'SWZ', '748', '268'),
(205, 'SE', 'SWEDEN', 'Sweden', 'SWE', '752', '46'),
(206, 'CH', 'SWITZERLAND', 'Switzerland', 'CHE', '756', '41'),
(207, 'SY', 'SYRIAN ARAB REPUBLIC', 'Syrian Arab Republic', 'SYR', '760', '963'),
(208, 'TW', 'TAIWAN, PROVINCE OF CHINA', 'Taiwan, Province of China', 'TWN', '158', '886'),
(209, 'TJ', 'TAJIKISTAN', 'Tajikistan', 'TJK', '762', '992'),
(210, 'TZ', 'TANZANIA, UNITED REPUBLIC OF', 'Tanzania, United Republic of', 'TZA', '834', '255'),
(211, 'TH', 'THAILAND', 'Thailand', 'THA', '764', '66'),
(212, 'TL', 'TIMOR-LESTE', 'Timor-Leste', NULL, NULL, '670'),
(213, 'TG', 'TOGO', 'Togo', 'TGO', '768', '228'),
(214, 'TK', 'TOKELAU', 'Tokelau', 'TKL', '772', '690'),
(215, 'TO', 'TONGA', 'Tonga', 'TON', '776', '676'),
(216, 'TT', 'TRINIDAD AND TOBAGO', 'Trinidad and Tobago', 'TTO', '780', '186'),
(217, 'TN', 'TUNISIA', 'Tunisia', 'TUN', '788', '216'),
(218, 'TR', 'TURKEY', 'Turkey', 'TUR', '792', '90'),
(219, 'TM', 'TURKMENISTAN', 'Turkmenistan', 'TKM', '795', '737'),
(220, 'TC', 'TURKS AND CAICOS ISLANDS', 'Turks and Caicos Islands', 'TCA', '796', '164'),
(221, 'TV', 'TUVALU', 'Tuvalu', 'TUV', '798', '688'),
(222, 'UG', 'UGANDA', 'Uganda', 'UGA', '800', '256'),
(223, 'UA', 'UKRAINE', 'Ukraine', 'UKR', '804', '380'),
(224, 'AE', 'UNITED ARAB EMIRATES', 'United Arab Emirates', 'ARE', '784', '971'),
(225, 'GB', 'UNITED KINGDOM', 'United Kingdom', 'GBR', '826', '44'),
(226, 'US', 'UNITED STATES', 'United States', 'USA', '840', '1'),
(227, 'UM', 'UNITED STATES MINOR OUTLYING ISLANDS', 'United States Minor Outlying Islands', NULL, NULL, '1'),
(228, 'UY', 'URUGUAY', 'Uruguay', 'URY', '858', '598'),
(229, 'UZ', 'UZBEKISTAN', 'Uzbekistan', 'UZB', '860', '998'),
(230, 'VU', 'VANUATU', 'Vanuatu', 'VUT', '548', '678'),
(231, 'VE', 'VENEZUELA', 'Venezuela', 'VEN', '862', '58'),
(232, 'VN', 'VIET NAM', 'Viet Nam', 'VNM', '704', '84'),
(233, 'VG', 'VIRGIN ISLANDS, BRITISH', 'Virgin Islands, British', 'VGB', '92', '128'),
(234, 'VI', 'VIRGIN ISLANDS, U.S.', 'Virgin Islands, U.s.', 'VIR', '850', '134'),
(235, 'WF', 'WALLIS AND FUTUNA', 'Wallis and Futuna', 'WLF', '876', '681'),
(236, 'EH', 'WESTERN SAHARA', 'Western Sahara', 'ESH', '732', '212'),
(237, 'YE', 'YEMEN', 'Yemen', 'YEM', '887', '967'),
(238, 'ZM', 'ZAMBIA', 'Zambia', 'ZMB', '894', '260'),
(239, 'ZW', 'ZIMBABWE', 'Zimbabwe', 'ZWE', '716', '263');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `accountNo` int(11) NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fathername` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mothername` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `presentaddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permanentaddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `occupation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nationality` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customerpic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nidno` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `age` int(11) NOT NULL,
  `mobile` int(11) NOT NULL,
  `introducername` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `introducerpermanentaddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nomname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nomfathername` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nommothername` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nompresentaddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nompermanentaddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nomoccupation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `relationship` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nomnidno` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nomage` int(11) NOT NULL,
  `nommobile` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `accountNo`, `fullname`, `fathername`, `mothername`, `presentaddress`, `permanentaddress`, `occupation`, `nationality`, `customerpic`, `nidno`, `age`, `mobile`, `introducername`, `introducerpermanentaddress`, `nomname`, `nomfathername`, `nommothername`, `nompresentaddress`, `nompermanentaddress`, `nomoccupation`, `relationship`, `nomnidno`, `nomage`, `nommobile`, `status`, `created_at`, `updated_at`) VALUES
(10, 1099, 'Arnold R. Garcia', 'Father', 'Mother', '620 Willis Avenue', '620 Willis Avenue', 'Job Holder', 'Bangladeshi', '1541833885.jpg', '343243223423', 12, 2147483647, 'Introducer', '620 Willis Avenue', 'Arnold R. Garcia', 'Arnold R. Garcia', 'Arnold R. Garcia', 'Arnold R. Garcia', '620 Willis Avenue', 'Job Holder', 'Friend', '3432423324', 23, 2147483647, 1, '2018-11-07 03:41:58', '2018-11-10 01:11:25'),
(48, 1100, 'Shohan Kenshin', 'Father', 'Mother', 'Present', 'Permanent', 'Job Holder', 'Bangladeshi', '1542174736.png', '543324233241', 12, 34223432, 'Introducer', 'Address', 'Arnold R. Garcia', 'Arnold R. Garcia', 'Arnold R. Garcia', 'Arnold R. Garcia', '620 Willis Avenue', 'Job Holder', 'Friend', '352332223', 32, 2147483647, 1, '2018-11-08 08:41:12', '2018-11-13 23:52:16');

-- --------------------------------------------------------

--
-- Table structure for table `dps`
--

CREATE TABLE `dps` (
  `id` int(10) UNSIGNED NOT NULL,
  `accountNo` int(11) NOT NULL,
  `monthlyamount` int(11) NOT NULL,
  `numberofyear` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dps`
--

INSERT INTO `dps` (`id`, `accountNo`, `monthlyamount`, `numberofyear`, `created_at`, `updated_at`) VALUES
(98, 1100, 50000, 2, '2018-12-05 23:20:13', '2018-12-05 23:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `dps_records`
--

CREATE TABLE `dps_records` (
  `id` int(10) UNSIGNED NOT NULL,
  `accountNo` int(11) NOT NULL,
  `trnxNo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `terms` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `nextdate` date NOT NULL,
  `late` int(11) NOT NULL,
  `monthlyamount` int(11) NOT NULL,
  `monthlyinterest` float NOT NULL,
  `monthlytotal` float NOT NULL,
  `paymentstatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dps_records`
--

INSERT INTO `dps_records` (`id`, `accountNo`, `trnxNo`, `terms`, `date`, `nextdate`, `late`, `monthlyamount`, `monthlyinterest`, `monthlytotal`, `paymentstatus`, `created_at`, `updated_at`) VALUES
(24, 1100, 'Trx-Thu1544072730', '1-24', '2018-12-06', '2019-01-07', 0, 50000, 2, 50002, '', '2018-12-05 23:05:30', '2018-12-05 23:05:30'),
(25, 1100, 'Trx-Thu1544073613', '1-24', '2018-12-06', '2019-01-07', 0, 50000, 2, 50002, '', '2018-12-05 23:20:13', '2018-12-05 23:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `dps_settings`
--

CREATE TABLE `dps_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `interestrate` float NOT NULL,
  `latedateno` int(11) DEFAULT NULL,
  `latefees` int(11) DEFAULT NULL,
  `yearfigure` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `settingfor` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dps_settings`
--

INSERT INTO `dps_settings` (`id`, `interestrate`, `latedateno`, `latefees`, `yearfigure`, `settingfor`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 60, '2,5,10', 'DPS', '2018-11-12 10:00:22', '2018-12-05 21:23:48'),
(2, 2, 2, 60, '2,5,10', 'FDR', '2018-11-12 10:00:22', '2018-12-05 21:23:03'),
(3, 18, 10, 0, '5,10,110,220,330', 'LOAN', '2018-11-12 10:00:22', '2018-12-02 23:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `expense_trans`
--

CREATE TABLE `expense_trans` (
  `id` int(10) UNSIGNED NOT NULL,
  `voucherno` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `entryby` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `purpose` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `expense_trans`
--

INSERT INTO `expense_trans` (`id`, `voucherno`, `amount`, `date`, `entryby`, `purpose`, `remarks`, `created_at`, `updated_at`) VALUES
(1, 'Trx-exWed1544037682', 20, '2018-12-06', 'Shohan', 'Nothing', 'sdfdsdf', '2018-12-05 19:21:22', '2018-12-05 19:21:22');

-- --------------------------------------------------------

--
-- Table structure for table `fdrs`
--

CREATE TABLE `fdrs` (
  `id` int(10) UNSIGNED NOT NULL,
  `accountNo` int(11) NOT NULL,
  `fdrno` int(11) DEFAULT NULL,
  `tranxid` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fdramount` int(11) NOT NULL,
  `totalamount` float NOT NULL,
  `dueamount` float NOT NULL,
  `profitrate` float NOT NULL,
  `fdrterms` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `monthlyamount` float NOT NULL,
  `numberofyear` int(11) NOT NULL,
  `serviceenddate` date DEFAULT NULL,
  `nextwithdrawdate` date DEFAULT NULL,
  `fdrpermission` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fdrstatus` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `fdrs`
--

INSERT INTO `fdrs` (`id`, `accountNo`, `fdrno`, `tranxid`, `fdramount`, `totalamount`, `dueamount`, `profitrate`, `fdrterms`, `monthlyamount`, `numberofyear`, `serviceenddate`, `nextwithdrawdate`, `fdrpermission`, `fdrstatus`, `created_at`, `updated_at`) VALUES
(25, 1100, 1, 'Trx-fdr-D1544073317', 50000, 51000, 51000, 2, '1-24', 1000, 2, '2020-12-07', '2019-02-07', 'approved', 'active', '2018-12-06 05:15:40', '2018-12-05 23:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `fdr_records`
--

CREATE TABLE `fdr_records` (
  `id` int(10) UNSIGNED NOT NULL,
  `accountNo` int(11) NOT NULL,
  `fdrno` int(11) NOT NULL,
  `trnxNo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fdrterms` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `withdrawdate` date NOT NULL,
  `nextdate` date NOT NULL,
  `monthlyamount` float NOT NULL,
  `paymentstatus` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `fdr_records`
--

INSERT INTO `fdr_records` (`id`, `accountNo`, `fdrno`, `trnxNo`, `fdrterms`, `withdrawdate`, `nextdate`, `monthlyamount`, `paymentstatus`, `created_at`, `updated_at`) VALUES
(40, 1100, 1, 'Trx-fdThu1544073340', '1-24', '2019-01-07', '2019-02-07', 1000, 'paid', '2018-12-06 05:15:40', '2018-12-06 05:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(10) UNSIGNED NOT NULL,
  `holidayname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `holidaystartdate` date NOT NULL,
  `holidayenddate` date NOT NULL,
  `holidaycount` int(11) NOT NULL,
  `holidayyear` int(11) NOT NULL,
  `holidaystatus` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `holidaytype` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `holidayremarks` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `holidayname`, `holidaystartdate`, `holidayenddate`, `holidaycount`, `holidayyear`, `holidaystatus`, `holidaytype`, `holidayremarks`, `created_at`, `updated_at`) VALUES
(130, 'Eid ul Fitr', '2018-11-29', '0000-00-00', 1, 2018, '1', 'public', '', '2018-11-27 07:32:52', '2018-11-27 07:32:52'),
(131, 'Eid ul Fitr', '2018-12-01', '0000-00-00', 1, 2018, '1', 'public', '', '2018-11-27 07:32:52', '2018-11-27 07:32:52'),
(132, 'Eid ul Fitr', '2018-12-02', '0000-00-00', 1, 2018, '1', 'public', '', '2018-11-28 14:56:41', '2018-11-27 07:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `income_trans`
--

CREATE TABLE `income_trans` (
  `id` int(10) UNSIGNED NOT NULL,
  `voucherno` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `amount` float NOT NULL,
  `date` date NOT NULL,
  `entryby` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `purpose` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `income_trans`
--

INSERT INTO `income_trans` (`id`, `voucherno`, `amount`, `date`, `entryby`, `purpose`, `remarks`, `created_at`, `updated_at`) VALUES
(2, 'Trx-inWed1544037485', 50, '2018-12-06', 'Shohan', 'Nothing', 'lksjfkjdsf', '2018-12-05 19:18:05', '2018-12-05 19:18:05'),
(3, 'Trx-inThu1544069585', 80, '2018-12-08', 'Shohan', 'Lunch', 'fsdds', '2018-12-06 04:13:05', '2018-12-06 04:13:05');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(10) UNSIGNED NOT NULL,
  `foldername` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `languagename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flag_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `foldername`, `languagename`, `description`, `flag_image`, `created_at`, `updated_at`) VALUES
(1, 'en', 'English', 'English', 'america.png', '2018-11-04 00:30:22', '2018-11-04 00:30:22'),
(22, 'bn', 'bengali', 'Bangla', '1475429828.png', '2018-11-04 00:30:22', '2018-11-04 00:30:22');

-- --------------------------------------------------------

--
-- Table structure for table `loans`
--

CREATE TABLE `loans` (
  `id` int(10) UNSIGNED NOT NULL,
  `loanno` int(11) DEFAULT NULL,
  `loanapplytranxid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `accountNo` int(11) NOT NULL,
  `loandate` date DEFAULT NULL,
  `loanamount` int(11) DEFAULT NULL,
  `loantotal` int(11) DEFAULT NULL,
  `loandue` float DEFAULT NULL,
  `loaninterest` float DEFAULT NULL,
  `loanterms` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dailyamount` float NOT NULL DEFAULT '0',
  `next_collection_date` date DEFAULT NULL,
  `loanending` date DEFAULT NULL,
  `loanfailcount` int(11) DEFAULT NULL,
  `loanstatus` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `loanpermission` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `loans`
--

INSERT INTO `loans` (`id`, `loanno`, `loanapplytranxid`, `accountNo`, `loandate`, `loanamount`, `loantotal`, `loandue`, `loaninterest`, `loanterms`, `dailyamount`, `next_collection_date`, `loanending`, `loanfailcount`, `loanstatus`, `loanpermission`, `created_at`, `updated_at`) VALUES
(139, 1, 'Trx-ln-D1544069503', 1100, '2018-12-06', 50000, 59000, 53100, 18, '1-10', 5900, '2018-12-09', '2018-12-18', 0, 'active', 'approved', '2018-12-05 22:11:43', '2018-12-05 22:12:14'),
(140, 1, 'Trx-ln-D1544072305', 1099, '2018-12-06', 100000, 118000, 70800, 18, '2-5', 23600, '2018-12-11', '2018-12-12', 1, 'active', 'approved', '2018-12-05 22:58:25', '2018-12-05 23:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `loan_rocords`
--

CREATE TABLE `loan_rocords` (
  `id` int(10) UNSIGNED NOT NULL,
  `accountNo` int(11) NOT NULL,
  `loanno` int(11) NOT NULL,
  `loantranxid` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `receivedate` date DEFAULT NULL,
  `currentterms` int(11) DEFAULT NULL,
  `loantargetdays` int(11) DEFAULT NULL,
  `dailyamount` float DEFAULT '0',
  `next_collection_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `loan_rocords`
--

INSERT INTO `loan_rocords` (`id`, `accountNo`, `loanno`, `loantranxid`, `receivedate`, `currentterms`, `loantargetdays`, `dailyamount`, `next_collection_date`, `created_at`, `updated_at`) VALUES
(114, 1100, 1, 'Trx-lnD-D1544069534', '2018-12-08', 1, 10, 5900, '2018-12-09', '2018-12-06 04:12:14', '2018-12-06 04:12:14'),
(115, 1099, 1, 'Trx-lnD-D1544072436', '2018-12-08', 1, 5, 23600, '2018-12-09', '2018-12-06 05:00:36', '2018-12-06 05:00:36'),
(116, 1099, 1, NULL, '2018-12-09', 0, NULL, 0, NULL, '2018-12-06 05:01:09', '2018-12-06 05:01:09'),
(117, 1099, 1, 'Trx-lnD-D1544072469', '2018-12-10', 2, 5, 23600, '2018-12-11', '2018-12-06 05:01:09', '2018-12-06 05:01:09');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `receiver_id` int(10) UNSIGNED NOT NULL,
  `sender_id` int(10) UNSIGNED NOT NULL,
  `replay_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2015_08_25_172600_create_settings_table', 1),
(3, '2015_09_19_191655_setup_countries_table', 1),
(4, '2015_10_10_170827_create_users_table', 1),
(5, '2015_10_10_170911_create_social_accounts_table', 1),
(6, '2015_10_10_171049_create_social_login_table', 1),
(7, '2015_10_10_171734_add_foreign_keys', 1),
(8, '2015_12_24_080704_entrust_setup_tables', 1),
(9, '2015_12_29_224252_create_user_activity_table', 1),
(10, '2017_11_12_000000_create_languages_table', 1),
(12, '2017_11_12_000000_create_messages_table', 2),
(13, '2018_11_07_060138_create_customers_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `removable` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `removable`, `created_at`, `updated_at`) VALUES
(1, 'users.manage', 'Manage Users', 'Manage users and their sessions.', 0, '2018-11-04 00:30:21', '2018-11-04 00:30:21'),
(2, 'users.activity', 'View System Activity Log', 'View activity log for all system users.', 0, '2018-11-04 00:30:21', '2018-11-04 00:30:21'),
(3, 'roles.manage', 'Manage Roles', 'Manage system roles.', 0, '2018-11-04 00:30:21', '2018-11-04 00:30:21'),
(4, 'permissions.manage', 'Manage Permissions', 'Manage role permissions.', 0, '2018-11-04 00:30:21', '2018-11-04 00:30:21'),
(5, 'settings.general', 'Update General System Settings', '', 0, '2018-11-04 00:30:21', '2018-11-04 00:30:21'),
(6, 'languages.languages', 'Languages', 'Site languages', 1, '2018-11-05 23:14:45', '2018-11-05 23:14:45'),
(7, 'reports.all', 'Reports', 'All reports', 1, '2018-11-10 00:11:30', '2018-11-10 00:11:30'),
(8, 'holiday.add', 'Holidays', 'Show holiday list', 1, '2018-11-19 03:48:23', '2018-11-19 03:48:23');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(2, 3),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `removable` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `removable`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Admin', 'System administrator.', 0, '2018-11-04 00:30:21', '2018-11-04 00:30:21'),
(2, 'User', 'User', 'Default system user.', 0, '2018-11-04 00:30:21', '2018-11-04 00:30:21'),
(3, 'Accountant', 'Accountant', '', 1, '2018-11-04 00:55:18', '2018-11-04 00:55:18');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `accountNo` int(11) NOT NULL,
  `servicename` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `serviceno` int(11) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `accountNo`, `servicename`, `serviceno`, `status`, `created_at`, `updated_at`) VALUES
(29, 1100, 'LOAN', 1, '1', '2018-12-06 04:11:52', '2018-12-06 04:11:52'),
(31, 1099, 'LOAN', 1, '1', '2018-12-06 04:59:11', '2018-12-06 04:59:11'),
(33, 1100, 'FDR', 1, '1', '2018-12-06 05:15:18', '2018-12-06 05:15:18'),
(34, 1100, 'DPS', NULL, '1', '2018-12-05 23:20:13', '2018-12-05 23:20:13');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `app_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `app_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_me` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forget_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notify_signup` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `re_capcha` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `app_name`, `app_title`, `app_email`, `phone`, `mobile`, `currency`, `remember_me`, `forget_password`, `notify_signup`, `re_capcha`, `logo`, `address`, `created_at`, `updated_at`) VALUES
(1, 'New Uttara Shanchoi', 'New Uttara Shanchoi', 'support@gmail.com', '0321564685', '015465445', '৳', 'ON', 'ON', 'OFF', 'OFF', '1544070661.png', 'Pabna, Rajshahi', '2018-11-04 00:30:22', '2018-12-05 22:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `social_accounts`
--

CREATE TABLE `social_accounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `social_logins`
--

CREATE TABLE `social_logins` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `provider` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_of_birth` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `google` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dribbble` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `password`, `address`, `phone`, `country`, `date_of_birth`, `role`, `status`, `gender`, `image`, `google`, `facebook`, `twitter`, `linkedin`, `skype`, `dribbble`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'Doe', 'admin123', 'admin@gmail.com', '$2y$10$mj3AkgdV4zwbRTK.4OeSUOeD9/tVVOijIsuMURiohP0PeS./CMs8m', '620 Willis Avenue', '3864050303', 'Bangladesh', '', 'Admin', 'Active', 'Male', '1543516182.png', '', '', 'https://www.twitter.com/', '', '', '', 'YBJyn522vFl35S8zgnAY7LGhrcEj72M7tXVrtOYyqc0pDVwUCRY7IYLDlNli', '2018-11-04 00:30:22', '2018-11-29 12:29:42'),
(2, 'User', '123', 'user123', 'user@farazisoft.com', '$2y$10$qObI5nsZWr3ZY5HCx5raxOFlMu0Jyw0zd3OO5PBch/su/DSoFEZPe', '', NULL, NULL, NULL, 'User', 'Active', NULL, '1482937747.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-11-04 00:30:22', '2018-11-04 00:30:22'),
(3, 'Shohan', 'Kenshin', 'shohan27', 'shohan.st27@gmail.com', '$2y$10$c8uR8iFmRmgSkBP4eZKjke187yjj1A3L/eqiliSdouUo0NlDqcvmS', '620 Willis Avenue', '3864050303', 'Bangladesh', '11/21/2018', 'Accountant', 'Active', 'Male', '', NULL, NULL, NULL, NULL, NULL, NULL, 'Ko9UfqynBNEdUTHURW4Y4LAgdEekQHG7xLkmMIiUeHfpwwfM6O9i6Mau5uGe', '2018-11-04 00:56:41', '2018-11-04 00:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_activity`
--

CREATE TABLE `user_activity` (
  `id` int(10) UNSIGNED NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `latitude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `longtude` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_activity`
--

INSERT INTO `user_activity` (`id`, `description`, `user_id`, `ip_address`, `latitude`, `longtude`, `user_agent`, `created_at`) VALUES
(1, 'Role Added', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-04 06:55:18'),
(2, 'User Added', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-04 06:56:41'),
(3, 'Roles wise permission Update', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-04 06:59:11'),
(4, 'Roles wise permission Update', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-04 07:01:13'),
(5, 'Roles wise permission Update', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-04 07:01:42'),
(6, 'User Updated.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-04 07:06:46'),
(7, 'Roles wise permission Update', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-04 07:26:20'),
(8, 'User Updated.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-04 10:58:35'),
(9, 'Roles wise permission Update', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-04 11:19:34'),
(10, 'Permission Delete.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-05 05:21:12'),
(11, 'Roles wise permission Update', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-05 05:24:04'),
(12, 'User Updated.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-05 07:48:02'),
(13, 'User Updated.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-05 07:48:14'),
(14, 'User Updated.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-05 08:03:01'),
(15, 'User Updated.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-05 08:23:43'),
(16, 'User Updated.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-05 08:24:46'),
(17, 'Permission Updated', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-06 05:14:45'),
(18, 'Roles wise permission Update', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-06 05:14:53'),
(19, 'Permission Updated', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-10 06:11:30'),
(20, 'Roles wise permission Update', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-10 06:12:03'),
(21, 'Roles wise permission Update', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-10 06:13:29'),
(22, 'Roles wise permission Update', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36', '2018-11-10 06:39:10'),
(23, 'Permission Updated', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', '2018-11-19 09:48:23'),
(24, 'Roles wise permission Update', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36', '2018-11-19 09:48:28'),
(25, 'Change Photo.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Safari/537.36', '2018-11-29 18:29:42'),
(26, 'User Updated.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36', '2018-12-06 04:22:57'),
(27, 'User Updated.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36', '2018-12-06 04:24:38'),
(28, 'User Updated.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36', '2018-12-06 04:25:33'),
(29, 'User Updated.', 1, '::1', '', '', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.80 Safari/537.36', '2018-12-06 04:31:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dps`
--
ALTER TABLE `dps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dps_records`
--
ALTER TABLE `dps_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dps_settings`
--
ALTER TABLE `dps_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_trans`
--
ALTER TABLE `expense_trans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fdrs`
--
ALTER TABLE `fdrs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fdr_records`
--
ALTER TABLE `fdr_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `income_trans`
--
ALTER TABLE `income_trans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loan_rocords`
--
ALTER TABLE `loan_rocords`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_accounts`
--
ALTER TABLE `social_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `social_accounts_user_id_foreign` (`user_id`);

--
-- Indexes for table `social_logins`
--
ALTER TABLE `social_logins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `social_logins_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_activity_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `dps`
--
ALTER TABLE `dps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `dps_records`
--
ALTER TABLE `dps_records`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `dps_settings`
--
ALTER TABLE `dps_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `expense_trans`
--
ALTER TABLE `expense_trans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fdrs`
--
ALTER TABLE `fdrs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `fdr_records`
--
ALTER TABLE `fdr_records`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;
--
-- AUTO_INCREMENT for table `income_trans`
--
ALTER TABLE `income_trans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;
--
-- AUTO_INCREMENT for table `loan_rocords`
--
ALTER TABLE `loan_rocords`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `social_accounts`
--
ALTER TABLE `social_accounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `social_logins`
--
ALTER TABLE `social_logins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_activity`
--
ALTER TABLE `user_activity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `social_accounts`
--
ALTER TABLE `social_accounts`
  ADD CONSTRAINT `social_accounts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `social_logins`
--
ALTER TABLE `social_logins`
  ADD CONSTRAINT `social_logins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_activity`
--
ALTER TABLE `user_activity`
  ADD CONSTRAINT `user_activity_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
