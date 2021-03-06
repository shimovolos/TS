function updateMaskedField(selector, data, jQ){
    var input = jQ('#' + selector);
    if(data !== undefined){
        var dataFormat = data.format;
        cCode = dataFormat;

        delete jQ.mask.definitions['9'];
        jQ.mask.definitions['#'] = "[0-9]";

        input.attr('placeholder', data.format);
        input.attr('data-val', data.format).val('')

        if(!input.hasClass('required-entry')){
            jQ('label[for="'+ selector +'"] .required').css('display', 'inline');
            if(!arguments[3])
                input.addClass('required-entry');
        }
    }else{
        input.unmask().attr('placeholder', '');
        if(input.hasClass('required-entry')){
            input.removeClass('required-entry');
            jQ('label[for="'+ selector +'"] .required').css('display', 'none');
        }
    }
}

function initMasks(countryInput, phoneInput, jQ){
    var cCode = jQ('#' + countryInput).val();
    if(cCode === '') {
        return;
    }
    var phoneResultObject = phones.filter(function(obj){
        return obj.code === cCode;
    })[0];

    updateMaskedField(phoneInput, phoneResultObject, jQ);
}

var phones = [
    {"name": "Israel", "format": "+972", "code": "IL", "cityCodeLength": 1},
    {"name": "Afghanistan", "format": "+93", "code": "AF", "cityCodeLength": 3},
    {"name": "Albania", "format": "+355", "code": "AL",
        "cityCodeLength": 3},
    {"name": "Algeria", "format": "+213", "code": "DZ", "cityCodeLength": 1},
    {"name": "AmericanSamoa", "format": "+1 684", "code": "AS", "cityCodeLength": 0},
    {"name": "Andorra", "format": "+376", "code": "AD",
        "cityCodeLength": 0},
    {"name": "Angola", "format": "+244", "code": "AO",
        "cityCodeLength": 2},
    {"name": "Anguilla", "format": "+1 264", "code": "AI",
        "cityCodeLength": 0},
    {"name": "Antigua and Barbuda", "format": "+1268", "code": "AG",
        "cityCodeLength": 0},
    {"name": "Argentina", "format": "+54", "code": "AR",
        "cityCodeLength": 4},
    {"name": "Armenia", "format": "+374", "code": "AM",
        "cityCodeLength": 2},
    {"name": "Aruba", "format": "+297", "code": "AW",
        "cityCodeLength": 1},
    {"name": "Australia", "format": "+61", "code": "AU",
        "cityCodeLength": 1},
    {"name": "Austria", "format": "+43", "code": "AT",
        "cityCodeLength": 4,
        "zeroHack": false,
        "exceptions": [
            1,
            662,
            732,
            316,
            512,
            463
        ]},
    {"name": "Azerbaijan", "format": "+994", "code": "AZ",
        "cityCodeLength": 3},
    {"name": "Bahamas", "format": "+1 242", "code": "BS",
        "cityCodeLength": 0},
    {"name": "Bahrain", "format": "+973", "code": "BH",
        "cityCodeLength": 0},
    {"name": "Bangladesh", "format": "+880", "code": "BD",
        "cityCodeLength": 3},
    {"name": "Barbados", "format": "+1 246", "code": "BB",
        "cityCodeLength": 0},
    {"name": "Belarus", "format": "+375", "code": "BY",
        "cityCodeLength": 3},
    {"name": "Belgium", "format": "+32", "code": "BE",
        "cityCodeLength": 2,
        "zeroHack": false,
        "exceptions": [
            2,
            9,
            7,
            3,
            476,
            477,
            478,
            495,
            496
        ]},
    {"name": "Belize", "format": "+501", "code": "BZ",
        "cityCodeLength": 1},
    {"name": "Benin", "format": "+229", "code": "BJ",
        "cityCodeLength": 0},
    {"name": "Bermuda", "format": "+1 441", "code": "BM"},
    {"name": "Bhutan", "format": "+975", "code": "BT"},
    {"name": "Bosnia and Herzegovina", "format": "+387", "code": "BA",
        "cityCodeLength": 2},
    {"name": "Botswana", "format": "+267", "code": "BW",
        "cityCodeLength": 2},
    {"name": "Brazil", "format": "+55", "code": "BR",
        "cityCodeLength": 2},
    {"name": "British Indian Ocean Territory", "format": "+246", "code": "IO"},
    {"name": "Bulgaria", "format": "+359", "code": "BG",
        "cityCodeLength": 3},
    {"name": "Burkina Faso", "format": "+226", "code": "BF"},
    {"name": "Burundi", "format": "+257", "code": "BI",
        "cityCodeLength": 2},
    {"name": "Cambodia", "format": "+855", "code": "KH"},
    {"name": "Cameroon", "format": "+237", "code": "CM"},
    {"name": "Canada", "format": "+1", "code": "CA"},
    {"name": "Cape Verde", "format": "+238", "code": "CV"},
    {"name": "Cayman Islands", "format": "+ 345", "code": "KY"},
    {"name": "Central African Republic", "format": "+236", "code": "CF"},
    {"name": "Chad", "format": "+235", "code": "TD",
        "cityCodeLength": 2},
    {"name": "Chile", "format": "+56", "code": "CL",
        "cityCodeLength": 2},
    {"name": "China", "format": "+86", "code": "CN",
        "cityCodeLength": 3},
    {"name": "Christmas Island", "format": "+61", "code": "CX"},
    {"name": "Colombia", "format": "+57", "code": "CO",
        "cityCodeLength": 2},
    {"name": "Comoros", "format": "+269", "code": "KM"},
    {"name": "Congo", "format": "+242", "code": "CG",
        "cityCodeLength": 2},
    {"name": "Cook Islands", "format": "+682", "code": "CK"},
    {"name": "Costa Rica", "format": "+506", "code": "CR"},
    {"name": "Croatia", "format": "+385", "code": "HR",
        "cityCodeLength": 2},
    {"name": "Cuba", "format": "+53", "code": "CU",
        "cityCodeLength": 2},
    {"name": "Cyprus", "format": "+537", "code": "CY",
        "cityCodeLength": 2},
    {"name": "Czech Republic", "format": "+420", "code": "CZ",
        "cityCodeLength": 3},
    {"name": "Denmark", "format": "+45", "code": "DK",
        "cityCodeLength": 2,
        "zeroHack": false,
        "exceptions": [
            9,
            6,
            7,
            8,
            1,
            5,
            3,
            4,
            251,
            243,
            249,
            276,
            70777,
            80827,
            90107,
            90207,
            90417,
            90517
        ]},
    {"name": "Djibouti", "format": "+253", "code": "DJ"},
    {"name": "Dominica", "format": "+1 767", "code": "DM"},
    {"name": "Dominican Republic", "format": "+1 849", "code": "DO"},
    {"name": "Ecuador", "format": "+593", "code": "EC",
        "cityCodeLength": 1},
    {"name": "Egypt", "format": "+20", "code": "EG"},
    {"name": "El Salvador", "format": "+503", "code": "SV"},
    {"name": "Equatorial Guinea", "format": "+240", "code": "GQ",
        "cityCodeLength": 1},
    {"name": "Eritrea", "format": "+291", "code": "ER",
        "cityCodeLength": 2},
    {"name": "Estonia", "format": "+372", "code": "EE",
        "cityCodeLength": 2},
    {"name": "Ethiopia", "format": "+251", "code": "ET"},
    {"name": "Faroe Islands", "format": "+298", "code": "FO"},
    {"name": "Fiji", "format": "+679", "code": "FJ"},
    {"name": "Finland", "format": "+358", "code": "FI",
        "cityCodeLength": 2},
    {"name": "France", "format": "+33", "code": "FR",
        "cityCodeLength": 3,
        "zeroHack": false,
        "exceptions": [
            32,
            14,
            38,
            59,
            55,
            88,
            96,
            28,
            97,
            42,
            61
        ]},
    {"name": "French Guiana", "format": "+594", "code": "GF"},
    {"name": "French Polynesia", "format": "+689", "code": "PF"},
    {"name": "Gabon", "format": "+241", "code": "GA"},
    {"name": "Gambia", "format": "+220", "code": "GM"},
    {"name": "Georgia", "format": "+995", "code": "GE",
        "cityCodeLength": 3},
    {"name": "Germany", "format": "+49", "code": "DE",
        "cityCodeLength": 4,
        "exceptions": [
            651,
            241,
            711,
            981,
            821,
            30,
            971,
            671,
            921,
            951,
            521,
            228,
            234,
            531,
            421,
            471,
            961,
            281,
            611,
            365,
            40,
            511,
            209,
            551,
            641,
            34202,
            340,
            351,
            991,
            771,
            906,
            231,
            203,
            211,
            271,
            911,
            212,
            841,
            631,
            721,
            561,
            221,
            831,
            261,
            341,
            871,
            491,
            591,
            451,
            621,
            391,
            291,
            89,
            395,
            5021,
            571,
            441,
            781,
            208,
            541,
            69,
            331,
            851,
            34901,
            381,
            33638,
            751,
            681,
            861,
            581,
            731,
            335,
            741,
            461,
            761,
            661,
            345,
            481,
            34203,
            375,
            385,
            34204,
            361,
            201,
            33608,
            161,
            171,
            172,
            173,
            177,
            178,
            179
        ]},
    {"name": "Ghana", "format": "+233", "code": "GH",
        "cityCodeLength": 2},
    {"name": "Gibraltar", "format": "+350", "code": "GI"},
    {"name": "Greece", "format": "+30", "code": "GR",
        "cityCodeLength": 3,
        "zeroHack": false,
        "exceptions": [
            1,
            41,
            81,
            51,
            61,
            31,
            71,
            93,
            94,
            95,
            97556,
            97557
        ]},
    {"name": "Greenland", "format": "+299", "code": "GL"},
    {"name": "Grenada", "format": "+1 473", "code": "GD"},
    {"name": "Guadeloupe", "format": "+590", "code": "GP"},
    {"name": "Guam", "format": "+1 671", "code": "GU"},
    {"name": "Guatemala", "format": "+502", "code": "GT"},
    {"name": "Guinea", "format": "+224", "code": "GN"},
    {"name": "Guinea-Bissau", "format": "+245", "code": "GW"},
    {"name": "Guyana", "format": "+595", "code": "GY"},
    {"name": "Haiti", "format": "+509", "code": "HT",
        "cityCodeLength": 1},
    {"name": "Honduras", "format": "+504", "code": "HN"},
    {"name": "Hungary", "format": "+36", "code": "HU",
        "cityCodeLength": 2},
    {"name": "Iceland", "format": "+354", "code": "IS",
        "cityCodeLength": 3},
    {"name": "India", "format": "+91", "code": "IN",
        "cityCodeLength": 3},
    {"name": "Indonesia", "format": "+62", "code": "ID",
        "cityCodeLength": 3},
    {"name": "Iraq", "format": "+964", "code": "IQ",
        "cityCodeLength": 3},
    {"name": "Ireland", "format": "+353", "code": "IE"},
    {"name": "Israel", "format": "+972", "code": "IL"},
    {"name": "Italy", "format": "+39", "code": "IT",
        "cityCodeLength": 3,
        "zeroHack": true,
        "exceptions": [
            71,
            80,
            35,
            51,
            30,
            15,
            41,
            45,
            33,
            70,
            74,
            95,
            31,
            90,
            2,
            59,
            39,
            81,
            49,
            75,
            85,
            50,
            6,
            19,
            79,
            55,
            330,
            333,
            335,
            339,
            360,
            347,
            348,
            349
        ]},
    {"name": "Jamaica", "format": "+1 876", "code": "JM"},
    {"name": "Japan", "format": "+81", "code": "JP",
        "cityCodeLength": 3},
    {"name": "Jordan", "format": "+962", "code": "JO",
        "cityCodeLength": 1},
    {"name": "Kazakhstan", "format": "+7 7", "code": "KZ"},
    {"name": "Kenya", "format": "+254", "code": "KE"},
    {"name": "Kiribati", "format": "+686", "code": "KI"},
    {"name": "Kuwait", "format": "+965", "code": "KW"},
    {"name": "Kyrgyzstan", "format": "+996", "code": "KG",
        "cityCodeLength": 4},
    {"name": "Latvia", "format": "+371", "code": "LV",
        "cityCodeLength": 2},
    {"name": "Lebanon", "format": "+961", "code": "LB",
        "cityCodeLength": 1},
    {"name": "Lesotho", "format": "+266", "code": "LS"},
    {"name": "Liberia", "format": "+231", "code": "LR"},
    {"name": "Liechtenstein", "format": "+423", "code": "LI"},
    {"name": "Lithuania", "format": "+370", "code": "LT",
        "cityCodeLength": 3},
    {"name": "Luxembourg", "format": "+352", "code": "LU",
        "cityCodeLength": 2},
    {"name": "Madagascar", "format": "+261", "code": "MG"},
    {"name": "Malawi", "format": "+265", "code": "MW",
        "cityCodeLength": 1},
    {"name": "Malaysia", "format": "+60", "code": "MY",
        "cityCodeLength": 1},
    {"name": "Maldives", "format": "+960", "code": "MV"},
    {"name": "Mali", "format": "+223", "code": "ML"},
    {"name": "Malta", "format": "+356", "code": "MT"},
    {"name": "Marshall Islands", "format": "+692", "code": "MH"},
    {"name": "Martinique", "format": "+596", "code": "MQ"},
    {"name": "Mauritania", "format": "+222", "code": "MR",
        "cityCodeLength": 1},
    {"name": "Mauritius", "format": "+230", "code": "MU",
        "cityCodeLength": 3},
    {"name": "Mayotte", "format": "+262", "code": "YT"},
    {"name": "Mexico", "format": "+52", "code": "MX",
        "cityCodeLength": 2},
    {"name": "Monaco", "format": "+377", "code": "MC",
        "cityCodeLength": 1},
    {"name": "Mongolia", "format": "+976", "code": "MN",
        "cityCodeLength": 2},
    {"name": "Montenegro", "format": "+382", "code": "ME"},
    {"name": "Montserrat", "format": "+1664", "code": "MS"},
    {"name": "Morocco", "format": "+212", "code": "MA",
        "cityCodeLength": 1},
    {"name": "Myanmar", "format": "+95", "code": "MM",
        "cityCodeLength": 2},
    {"name": "Namibia", "format": "+264", "code": "NA"},
    {"name": "Nauru", "format": "+674", "code": "NR"},
    {"name": "Nepal", "format": "+977", "code": "NP",
        "cityCodeLength": 2},
    {"name": "Netherlands", "format": "+31", "code": "NL",
        "cityCodeLength": 3,
        "zeroHack": false,
        "exceptions": [
            4160,
            2268,
            2208,
            5253,
            78,
            72,
            33,
            20,
            55,
            26,
            35,
            74,
            76,
            40,
            77,
            10,
            70,
            75,
            73,
            38,
            50,
            15,
            30,
            58,
            43,
            24,
            46,
            13,
            23,
            45,
            53,
            61,
            62,
            65
        ]},
    {"name": "Netherlands Antilles", "format": "+599", "code": "AN",
        "cityCodeLength": 1},
    {"name": "New Caledonia", "format": "+687", "code": "NC"},
    {"name": "New Zealand", "format": "+64", "code": "NZ",
        "cityCodeLength": 1},
    {"name": "Nicaragua", "format": "+505", "code": "NI"},
    {"name": "Niger", "format": "+227", "code": "NE"},
    {"name": "Nigeria", "format": "+234", "code": "NG",
        "cityCodeLength": 2},
    {"name": "Niue", "format": "+683", "code": "NU"},
    {"name": "Norfolk Island", "format": "+672", "code": "NF"},
    {"name": "Northern Mariana Islands", "format": "+1 670", "code": "MP"},
    {"name": "Norway", "format": "+47", "code": "NO",
        "cityCodeLength": 1,
        "zeroHack": false,
        "exceptions": [
            43,
            83,
            62
        ]},
    {"name": "Oman", "format": "+968", "code": "OM"},
    {"name": "Pakistan", "format": "+92", "code": "PK",
        "cityCodeLength": 3},
    {"name": "Palau", "format": "+680", "code": "PW"},
    {"name": "Panama", "format": "+507", "code": "PA",
        "cityCodeLength": 1},
    {"name": "Papua New Guinea", "format": "+675", "code": "PG",
        "cityCodeLength": 2},
    {"name": "Paraguay", "format": "+595", "code": "PY",
        "cityCodeLength": 2},
    {"name": "Peru", "format": "+51", "code": "PE",
        "cityCodeLength": 2},
    {"name": "Philippines", "format": "+63", "code": "PH",
        "cityCodeLength": 2},
    {"name": "Poland", "format": "+48", "code": "PL",
        "cityCodeLength": 2,
        "zeroHack": false,
        "exceptions": [
            192,
            795,
            862,
            131,
            135,
            836,
            115,
            604,
            641,
            417,
            601,
            602,
            603,
            605,
            606,
            501,
            885
        ]},
    {"name": "Portugal", "format": "+351", "code": "PT"},
    {"name": "Puerto Rico", "format": "+1 939", "code": "PR"},
    {"name": "Qatar", "format": "+974", "code": "QA"},
    {"name": "Romania", "format": "+40", "code": "RO",
        "cityCodeLength": 2,
        "zeroHack": false,
        "exceptions": [
            1,
            941,
            916,
            981
        ]},
    {"name": "Rwanda", "format": "+250", "code": "RW"},
    {"name": "Samoa", "format": "+685", "code": "WS"},
    {"name": "San Marino", "format": "+378", "code": "SM"},
    {"name": "Saudi Arabia", "format": "+966", "code": "SA"},
    {"name": "Senegal", "format": "+221", "code": "SN",
        "cityCodeLength": 3},
    {"name": "Serbia", "format": "+381", "code": "RS"},
    {"name": "Seychelles", "format": "+248", "code": "SC"},
    {"name": "Sierra Leone", "format": "+232", "code": "SL",
        "cityCodeLength": 1},
    {"name": "Singapore", "format": "+65", "code": "SG"},
    {"name": "Slovakia", "format": "+421", "code": "SK",
        "cityCodeLength": 3},
    {"name": "Slovenia", "format": "+386", "code": "SI",
        "cityCodeLength": 2},
    {"name": "Solomon Islands", "format": "+677", "code": "SB"},
    {"name": "South Africa", "format": "+27", "code": "ZA"},
    {"name": "South Georgia and the South Sandwich Islands", "format": "+500", "code": "GS"},
    {"name": "Spain", "format": "+34", "code": "ES",
        "cityCodeLength": 3,
        "zeroHack": false,
        "exceptions": [
            4,
            6,
            3,
            5,
            96,
            93,
            94,
            91,
            95,
            98
        ]},
    {"name": "Sri Lanka", "format": "+94", "code": "LK",
        "cityCodeLength": 2},
    {"name": "Sudan", "format": "+249", "code": "SD",
        "cityCodeLength": 3},
    {"name": "Suriname", "format": "+597", "code": "SR"},
    {"name": "Swaziland", "format": "+268", "code": "SZ"},
    {"name": "Sweden", "format": "+46", "code": "SE",
        "cityCodeLength": 3,
        "zeroHack": false,
        "exceptions": [
            33,
            21,
            31,
            54,
            44,
            13,
            46,
            40,
            19,
            63,
            8,
            60,
            90,
            18,
            42
        ]},
    {"name": "Switzerland", "format": "+41", "code": "CH",
        "cityCodeLength": 2},
    {"name": "Tajikistan", "format": "+992", "code": "TJ"},
    {"name": "Thailand", "format": "+66", "code": "TH",
        "cityCodeLength": 2},
    {"name": "Togo", "format": "+228", "code": "TG"},
    {"name": "Tokelau", "format": "+690", "code": "TK"},
    {"name": "Tonga", "format": "+676", "code": "TO"},
    {"name": "Trinidad and Tobago", "format": "+1 868", "code": "TT"},
    {"name": "Tunisia", "format": "+216", "code": "TN",
        "cityCodeLength": 1},
    {"name": "Turkey", "format": "+90", "code": "TR",
        "cityCodeLength": 3},
    {"name": "Turkmenistan", "format": "+993", "code": "TM",
        "cityCodeLength": 1},
    {"name": "Turks and Caicos Islands", "format": "+1 649", "code": "TC"},
    {"name": "Tuvalu", "format": "+688", "code": "TV"},
    {"name": "Uganda", "format": "+256", "code": "UG"},
    {"name": "Ukraine", "format": "+380", "code": "UA",
        "cityCodeLength": 4},
    {"name": "United Arab Emirates", "format": "+971", "code": "AE",
        "cityCodeLength": 1},
    {"name": "United Kingdom", "format": "+44", "code": "GB",
        "cityCodeLength": 4,
        "zeroHack": false,
        "exceptions": [
            21,
            91,
            44,
            41,
            51,
            61,
            31,
            121,
            117,
            141,
            185674,
            18383,
            15932,
            116,
            151,
            113,
            171,
            181,
            161,
            207,
            208,
            158681,
            115,
            191,
            177681,
            114,
            131,
            18645
        ]},
    {"name": "United States", "format": "+1", "code": "US","cityCodeLength": 3},
    {"name": "Uruguay", "format": "+598", "code": "UY",
        "cityCodeLength": 3},
    {"name": "Uzbekistan", "format": "+998", "code": "UZ",
        "cityCodeLength": 4},
    {"name": "Vanuatu", "format": "+678", "code": "VU"},
    {"name": "Wallis and Futuna", "format": "+681", "code": "WF"},
    {"name": "Yemen", "format": "+967", "code": "YE",
        "cityCodeLength": 2},
    {"name": "Zambia", "format": "+260", "code": "ZM"},
    {"name": "Zimbabwe", "format": "+263", "code": "ZW"},
    {"name": "land Islands", "format": "", "code": "AX"},
    {"name": "Antarctica", "format": null, "code": "AQ"},
    {"name": "Bolivia, Plurinational State of", "format": "+591", "code": "BO",
        "cityCodeLength": 3},
    {"name": "Brunei Darussalam", "format": "+673", "code": "BN",
        "cityCodeLength": 1},
    {"name": "Cocos (Keeling) Islands", "format": "+61", "code": "CC"},
    {"name": "Congo, The Democratic Republic of the", "format": "+243", "code": "CD"},
    {"name": "Cote d'Ivoire", "format": "+225", "code": "CI"},
    {"name": "Falkland Islands (Malvinas)", "format": "+500", "code": "FK"},
    {"name": "Guernsey", "format": "+44", "code": "GG"},
    {"name": "Holy See (Vatican City State)", "format": "+379", "code": "VA"},
    {"name": "Hong Kong", "format": "+852", "code": "HK"},
    {"name": "Iran, Islamic Republic of", "format": "+98", "code": "IR",
        "cityCodeLength": 3},
    {"name": "Isle of Man", "format": "+44", "code": "IM"},
    {"name": "Jersey", "format": "+44", "code": "JE"},
    {"name": "Korea, Democratic People's Republic of", "format": "+850", "code": "KP",
        "cityCodeLength": 4},
    {"name": "Korea, Republic of", "format": "+82", "code": "KR",
        "cityCodeLength": 3},
    {"name": "Lao People's Democratic Republic", "format": "+856", "code": "LA"},
    {"name": "Libyan Arab Jamahiriya", "format": "+218", "code": "LY",
        "cityCodeLength": 2},
    {"name": "Macao", "format": "+853", "code": "MO"},
    {"name": "Macedonia, The Former Yugoslav Republic of", "format": "+389", "code": "MK",
        "cityCodeLength": 2},
    {"name": "Micronesia, Federated States of", "format": "+691", "code": "FM"},
    {"name": "Moldova, Republic of", "format": "+373", "code": "MD",
        "cityCodeLength": 2},
    {"name": "Mozambique", "format": "+258", "code": "MZ"},
    {"name": "Palestinian Territory, Occupied", "format": "+970", "code": "PS"},
    {"name": "Pitcairn", "format": "+872", "code": "PN"},
    {"name": "Réunion", "format": "+262", "code": "RE"},
    {"name": "Russia", "format": "+7", "code": "RU",
        "cityCodeLength": 5,
        "zeroHack": false,
        "exceptions": [
            4162,
            416332,
            8512,
            851111,
            4722,
            4725,
            391379,
            8442,
            4732,
            4152,
            4154451,
            4154459,
            4154455,
            41544513,
            8142,
            8332,
            8612,
            8622,
            3525,
            812,
            8342,
            8152,
            3812,
            4862,
            3422,
            342633,
            8112,
            9142,
            8452,
            3432,
            3434,
            3435,
            4812,
            3919,
            8432,
            8439,
            3822,
            4872,
            3412,
            3511,
            3512,
            3022,
            4112,
            4852,
            4855,
            3852,
            3854,
            8182,
            818,
            90,
            3472,
            4741,
            4764,
            4832,
            4922,
            8172,
            8202,
            8722,
            4932,
            493,
            3952,
            3951,
            3953,
            411533,
            4842,
            3842,
            3843,
            8212,
            4942,
            3912,
            4712,
            4742,
            8362,
            495,
            499,
            4966,
            4964,
            4967,
            498,
            8312,
            8313,
            3832,
            383612,
            3532,
            8412,
            4232,
            423370,
            423630,
            8632,
            8642,
            8482,
            4242,
            8672,
            8652,
            4752,
            4822,
            482502,
            4826300,
            3452,
            8422,
            4212,
            3466,
            3462,
            8712,
            8352,
            997,
            901,
            902,
            903,
            904,
            905,
            906,
            908,
            909,
            910,
            911,
            912,
            913,
            914,
            915,
            916,
            917,
            918,
            919,
            920,
            921,
            922,
            923,
            924,
            925,
            926,
            927,
            928,
            929,
            930,
            931,
            932,
            933,
            934,
            936,
            937,
            938,
            950,
            951,
            952,
            953,
            960,
            961,
            962,
            963,
            964,
            965,
            967,
            968,
            980,
            981,
            982,
            983,
            984,
            985,
            987,
            988,
            989
        ]},
    {"name": "Saint Barthélemy", "format": "+590", "code": "BL"},
    {"name": "Saint Helena, Ascension and Tristan Da Cunha", "format": "+290", "code": "SH"},
    {"name": "Saint Kitts and Nevis", "format": "+1 869", "code": "KN"},
    {"name": "Saint Lucia", "format": "+1 758", "code": "LC"},
    {"name": "Saint Martin", "format": "+590", "code": "MF"},
    {"name": "Saint Pierre and Miquelon", "format": "+508", "code": "PM"},
    {"name": "Saint Vincent and the Grenadines", "format": "+1 784", "code": "VC"},
    {"name": "Sao Tome and Principe", "format": "+239", "code": "ST"},
    {"name": "Somalia", "format": "+252", "code": "SO",
        "cityCodeLength": 2},
    {"name": "Svalbard and Jan Mayen", "format": "+47", "code": "SJ"},
    {"name": "Syrian Arab Republic", "format": "+963", "code": "SY",
        "cityCodeLength": 2},
    {"name": "Taiwan, Province of China", "format": "+886", "code": "TW",
        "cityCodeLength": 1},
    {"name": "Tanzania, United Republic of", "format": "+255", "code": "TZ"},
    {"name": "Timor-Leste", "format": "+670", "code": "TL"},
    {"name": "Venezuela, Bolivarian Republic of", "format": "+58", "code": "VE",
        "cityCodeLength": 2},
    {"name": "Viet Nam", "format": "+84", "code": "VN"},
    {"name": "Virgin Islands, British", "format": "+1 284", "code": "VG"},
    {"name": "Virgin Islands, U.S.", "format": "+1 340", "code": "VI"}
];