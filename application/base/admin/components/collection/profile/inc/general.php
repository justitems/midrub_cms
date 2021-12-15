<?php
/**
 * Admin Profile General Inc
 *
 * This file contains some general
 * functions used in the profile component
 *
 * @author Scrisoft
 * @package Midrub
 * @since 0.0.8.5
 */

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

if ( !function_exists('the_profile_countries_list') ) {
    
    /**
     * The function the_profile_countries_list returns the countries list
     * 
     * @since 0.0.8.5
     * 
     * @return array with countries list
     */
    function the_profile_countries_list() {

        // return countries
        return array(
            "AF" => "Afghanistan",
            "AL" => "Albania",
            "DZ" => "Algeria",
            "AS" => "American Samoa",
            "AD" => "Andorra",
            "AO" => "Angola",
            "AI" => "Anguilla",
            "AQ" => "Antarctica",
            "AG" => "Antigua and Barbuda",
            "AR" => "Argentina",
            "AM" => "Armenia",
            "AW" => "Aruba",
            "AU" => "Australia",
            "AT" => "Austria",
            "AZ" => "Azerbaijan",
            "BS" => "Bahamas",
            "BH" => "Bahrain",
            "BD" => "Bangladesh",
            "BB" => "Barbados",
            "BY" => "Belarus",
            "BE" => "Belgium",
            "BZ" => "Belize",
            "BJ" => "Benin",
            "BM" => "Bermuda",
            "BT" => "Bhutan",
            "BO" => "Bolivia",
            "BA" => "Bosnia and Herzegovina",
            "BW" => "Botswana",
            "BV" => "Bouvet Island",
            "BR" => "Brazil",
            "BQ" => "British Antarctic Territory",
            "IO" => "British Indian Ocean Territory",
            "VG" => "British Virgin Islands",
            "BN" => "Brunei",
            "BG" => "Bulgaria",
            "BF" => "Burkina Faso",
            "BI" => "Burundi",
            "KH" => "Cambodia",
            "CM" => "Cameroon",
            "CA" => "Canada",
            "CT" => "Canton and Enderbury Islands",
            "CV" => "Cape Verde",
            "KY" => "Cayman Islands",
            "CF" => "Central African Republic",
            "TD" => "Chad",
            "CL" => "Chile",
            "CN" => "China",
            "CX" => "Christmas Island",
            "CC" => "Cocos Islands",
            "CO" => "Colombia",
            "KM" => "Comoros",
            "CG" => "Congo - Brazzaville",
            "CD" => "Congo - Kinshasa",
            "CK" => "Cook Islands",
            "CR" => "Costa Rica",
            "HR" => "Croatia",
            "CU" => "Cuba",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "CI" => "Côte d’Ivoire",
            "DK" => "Denmark",
            "DJ" => "Djibouti",
            "DM" => "Dominica",
            "DO" => "Dominican Republic",
            "NQ" => "Dronning Maud Land",
            "DD" => "East Germany",
            "EC" => "Ecuador",
            "EG" => "Egypt",
            "SV" => "El Salvador",
            "GQ" => "Equatorial Guinea",
            "ER" => "Eritrea",
            "EE" => "Estonia",
            "ET" => "Ethiopia",
            "FK" => "Falkland Islands",
            "FO" => "Faroe Islands",
            "FJ" => "Fiji",
            "FI" => "Finland",
            "FR" => "France",
            "GF" => "French Guiana",
            "PF" => "French Polynesia",
            "TF" => "French Southern Territories",
            "FQ" => "French Southern and Antarctic Territories",
            "GA" => "Gabon",
            "GM" => "Gambia",
            "GE" => "Georgia",
            "DE" => "Germany",
            "GH" => "Ghana",
            "GI" => "Gibraltar",
            "GR" => "Greece",
            "GL" => "Greenland",
            "GD" => "Grenada",
            "GP" => "Guadeloupe",
            "GU" => "Guam",
            "GT" => "Guatemala",
            "GG" => "Guernsey",
            "GN" => "Guinea",
            "GW" => "Guinea-Bissau",
            "GY" => "Guyana",
            "HT" => "Haiti",
            "HM" => "Heard Island and McDonald Islands",
            "HN" => "Honduras",
            "HK" => "Hong Kong SAR China",
            "HU" => "Hungary",
            "IS" => "Iceland",
            "IN" => "India",
            "ID" => "Indonesia",
            "IR" => "Iran",
            "IQ" => "Iraq",
            "IE" => "Ireland",
            "IM" => "Isle of Man",
            "IL" => "Israel",
            "IT" => "Italy",
            "JM" => "Jamaica",
            "JP" => "Japan",
            "JE" => "Jersey",
            "JT" => "Johnston Island",
            "JO" => "Jordan",
            "KZ" => "Kazakhstan",
            "KE" => "Kenya",
            "KI" => "Kiribati",
            "KW" => "Kuwait",
            "KG" => "Kyrgyzstan",
            "LA" => "Laos",
            "LV" => "Latvia",
            "LB" => "Lebanon",
            "LS" => "Lesotho",
            "LR" => "Liberia",
            "LY" => "Libya",
            "LI" => "Liechtenstein",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MO" => "Macau SAR China",
            "MK" => "Macedonia",
            "MG" => "Madagascar",
            "MW" => "Malawi",
            "MY" => "Malaysia",
            "MV" => "Maldives",
            "ML" => "Mali",
            "MT" => "Malta",
            "MH" => "Marshall Islands",
            "MQ" => "Martinique",
            "MR" => "Mauritania",
            "MU" => "Mauritius",
            "YT" => "Mayotte",
            "FX" => "Metropolitan France",
            "MX" => "Mexico",
            "FM" => "Micronesia",
            "MI" => "Midway Islands",
            "MD" => "Moldova",
            "MC" => "Monaco",
            "MN" => "Mongolia",
            "ME" => "Montenegro",
            "MS" => "Montserrat",
            "MA" => "Morocco",
            "MZ" => "Mozambique",
            "MM" => "Myanmar [Burma]",
            "NA" => "Namibia",
            "NR" => "Nauru",
            "NP" => "Nepal",
            "NL" => "Netherlands",
            "AN" => "Netherlands Antilles",
            "NT" => "Neutral Zone",
            "NC" => "New Caledonia",
            "NZ" => "New Zealand",
            "NI" => "Nicaragua",
            "NE" => "Niger",
            "NG" => "Nigeria",
            "NU" => "Niue",
            "NF" => "Norfolk Island",
            "KP" => "North Korea",
            "VD" => "North Vietnam",
            "MP" => "Northern Mariana Islands",
            "NO" => "Norway",
            "OM" => "Oman",
            "PC" => "Pacific Islands Trust Territory",
            "PK" => "Pakistan",
            "PW" => "Palau",
            "PS" => "Palestinian Territories",
            "PA" => "Panama",
            "PZ" => "Panama Canal Zone",
            "PG" => "Papua New Guinea",
            "PY" => "Paraguay",
            "YD" => "People's Democratic Republic of Yemen",
            "PE" => "Peru",
            "PH" => "Philippines",
            "PN" => "Pitcairn Islands",
            "PL" => "Poland",
            "PT" => "Portugal",
            "PR" => "Puerto Rico",
            "QA" => "Qatar",
            "RO" => "Romania",
            "RU" => "Russia",
            "RW" => "Rwanda",
            "RE" => "Réunion",
            "BL" => "Saint Barthélemy",
            "SH" => "Saint Helena",
            "KN" => "Saint Kitts and Nevis",
            "LC" => "Saint Lucia",
            "MF" => "Saint Martin",
            "PM" => "Saint Pierre and Miquelon",
            "VC" => "Saint Vincent and the Grenadines",
            "WS" => "Samoa",
            "SM" => "San Marino",
            "SA" => "Saudi Arabia",
            "SN" => "Senegal",
            "RS" => "Serbia",
            "CS" => "Serbia and Montenegro",
            "SC" => "Seychelles",
            "SL" => "Sierra Leone",
            "SG" => "Singapore",
            "SK" => "Slovakia",
            "SI" => "Slovenia",
            "SB" => "Solomon Islands",
            "SO" => "Somalia",
            "ZA" => "South Africa",
            "GS" => "South Georgia and the South Sandwich Islands",
            "KR" => "South Korea",
            "ES" => "Spain",
            "LK" => "Sri Lanka",
            "SD" => "Sudan",
            "SR" => "Suriname",
            "SJ" => "Svalbard and Jan Mayen",
            "SZ" => "Swaziland",
            "SE" => "Sweden",
            "CH" => "Switzerland",
            "SY" => "Syria",
            "ST" => "São Tomé and Príncipe",
            "TW" => "Taiwan",
            "TJ" => "Tajikistan",
            "TZ" => "Tanzania",
            "TH" => "Thailand",
            "TL" => "Timor-Leste",
            "TG" => "Togo",
            "TK" => "Tokelau",
            "TO" => "Tonga",
            "TT" => "Trinidad and Tobago",
            "TN" => "Tunisia",
            "TR" => "Turkey",
            "TM" => "Turkmenistan",
            "TC" => "Turks and Caicos Islands",
            "TV" => "Tuvalu",
            "UM" => "U.S. Minor Outlying Islands",
            "PU" => "U.S. Miscellaneous Pacific Islands",
            "VI" => "U.S. Virgin Islands",
            "UG" => "Uganda",
            "UA" => "Ukraine",
            "SU" => "Union of Soviet Socialist Republics",
            "AE" => "United Arab Emirates",
            "GB" => "United Kingdom",
            "US" => "United States",
            "ZZ" => "Unknown or Invalid Region",
            "UY" => "Uruguay",
            "UZ" => "Uzbekistan",
            "VU" => "Vanuatu",
            "VA" => "Vatican City",
            "VE" => "Venezuela",
            "VN" => "Vietnam",
            "WK" => "Wake Island",
            "WF" => "Wallis and Futuna",
            "EH" => "Western Sahara",
            "YE" => "Yemen",
            "ZM" => "Zambia",
            "ZW" => "Zimbabwe",
            "AX" => "Åland Islands"
        );
        
    }
    
}

if ( !function_exists('the_profile_time_zones_list') ) {
    
    /**
     * The function the_profile_time_zones_list returns the time zones list
     * 
     * @since 0.0.8.5
     * 
     * @return array with time zones list
     */
    function the_profile_time_zones_list() {

        // Assign the CodeIgniter super-object
        $CI =& get_instance();

        // return time zones
        return array(
            array(
                'id' => '-11',
                'name' => $CI->lang->line('profile_gmt_11_00_midway')      
            ),
            array(
                'id' => '-10',
                'name' => $CI->lang->line('profile_gmt_10_00_honolulu')      
            ),  
            array(
                'id' => '-9',
                'name' => $CI->lang->line('profile_gmt_09_00_juneau')      
            ), 
            array(
                'id' => '-8',
                'name' => $CI->lang->line('profile_gmt_08_00_los_angeles')      
            ),
            array(
                'id' => '-7',
                'name' => $CI->lang->line('profile_gmt_07_00_phoenix')      
            ),     
            array(
                'id' => '-6',
                'name' => $CI->lang->line('profile_gmt_06_00_chicago')      
            ), 
            array(
                'id' => '-5',
                'name' => $CI->lang->line('profile_gmt_05_00_new_york')      
            ),  
            array(
                'id' => '-4',
                'name' => $CI->lang->line('profile_gmt_04_00_manaus')      
            ),     
            array(
                'id' => '-3',
                'name' => $CI->lang->line('profile_gmt_03_00_buenos_aires')      
            ), 
            array(
                'id' => '-2',
                'name' => $CI->lang->line('profile_gmt_02_00_sao_paulo')      
            ),
            array(
                'id' => '-1',
                'name' => $CI->lang->line('profile_gmt_01_00_cape_verde')      
            ),       
            array(
                'id' => '0',
                'name' => $CI->lang->line('profile_gmt_00_00_london')      
            ),  
            array(
                'id' => '1',
                'name' => $CI->lang->line('profile_gmt_01_00_amsterdam')      
            ),  
            array(
                'id' => '2',
                'name' => $CI->lang->line('profile_gmt_02_00_cairo')      
            ),  
            array(
                'id' => '3',
                'name' => $CI->lang->line('profile_gmt_03_00_istanbul')      
            ),   
            array(
                'id' => '3.30',
                'name' => $CI->lang->line('profile_gmt_03_30_tehran')      
            ),  
            array(
                'id' => '4',
                'name' => $CI->lang->line('profile_gmt_04_00_baku')      
            ),  
            array(
                'id' => '4.30',
                'name' => $CI->lang->line('profile_gmt_04_30_kabul')      
            ),  
            array(
                'id' => '5',
                'name' => $CI->lang->line('profile_gmt_05_00_karachi')      
            ),  
            array(
                'id' => '5.30',
                'name' => $CI->lang->line('profile_gmt_05_30_colombo')      
            ),  
            array(
                'id' => '5.45',
                'name' => $CI->lang->line('profile_gmt_05_45_katmandu')      
            ),  
            array(
                'id' => '6',
                'name' => $CI->lang->line('profile_gmt_06_00_dhaka')      
            ), 
            array(
                'id' => '6.30',
                'name' => $CI->lang->line('profile_gmt_06_30_rangoon')      
            ),  
            array(
                'id' => '7',
                'name' => $CI->lang->line('profile_gmt_07_00_bangkok')      
            ), 
            array(
                'id' => '8',
                'name' => $CI->lang->line('profile_gmt_08_00_hong_kong')      
            ),  
            array(
                'id' => '9',
                'name' => $CI->lang->line('profile_gmt_09_00_tokyo')      
            ),   
            array(
                'id' => '9.30',
                'name' => $CI->lang->line('profile_gmt_09_30_darwin')      
            ),
            array(
                'id' => '10',
                'name' => $CI->lang->line('profile_gmt_10_00_vladivostok')      
            ),
            array(
                'id' => '10.30',
                'name' => $CI->lang->line('profile_gmt_10_30_adelaide')      
            ), 
            array(
                'id' => '11',
                'name' => $CI->lang->line('profile_gmt_11_00_magadan')      
            ),
            array(
                'id' => '13',
                'name' => $CI->lang->line('profile_gmt_13_00_auckland')      
            ),
            array(
                'id' => '14',
                'name' => $CI->lang->line('profile_gmt_14_00_kiritimati')      
            )
        );
        
    }
    
}

if ( !function_exists('the_profile_date_formats_list') ) {
    
    /**
     * The function the_profile_date_formats_list returns the date formats list
     * 
     * @since 0.0.8.5
     * 
     * @return array with date formats list
     */
    function the_profile_date_formats_list() {

        // return date formats
        return array(
            array(
                'id' => 'dd/mm/yyyy',
                'name' => 'DD / MM / YYYY'    
            ),
            array(
                'id' => 'mm/dd/yyyy',
                'name' => 'MM / DD / YYYY'     
            ),
            array(
                'id' => 'yyyy-mm-dd',
                'name' => 'YYYY - MM- DD '     
            )

        );
        
    }
    
}

if ( !function_exists('the_profile_languages_list') ) {
    
    /**
     * The function the_profile_languages_list returns the languages list
     * 
     * @since 0.0.8.5
     * 
     * @return array with languages list
     */
    function the_profile_languages_list() {

        // Languages container
        $the_languages = array();

        // Get languages
        $languages = glob(APPPATH . 'language' . '/*', GLOB_ONLYDIR);

        // Verify if there are more than a language
        if (count($languages) > 0) {

            // List all languages
            foreach ($languages as $lang) {

                // Set directory
                $only_dir = str_replace(APPPATH . 'language' . '/', '', $lang);

                // Add language to the container
                $the_languages[] = array(
                    'id' => $only_dir,
                    'name' => ucfirst($only_dir)
                );

            }

        }

        // return languages
        return $the_languages;
        
    }
    
}

/* End of file general.php */