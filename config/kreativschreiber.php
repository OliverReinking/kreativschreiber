<?php
use App\Models\Administration;
return [
    // Version
    'version' => [
        'versionnr' => '1.0.0',
        'versionsdatum' => '01.01.2023',
    ],
    'rechnung' => [
        'company_name' => 'KreativSchreiber, eine Web-Anwendung von Oliver Reinking (Diplom-Mathematiker)',
        'address' => 'Oliver Reinking<br />Diplom-Mathematiker<br /><br />66482 Zweibrücken<br />Nordpfad 25<br /><br />Telefon: 06332 - 993 993<br />Mail: oliver@kreativschreiber.com<br />Steuernummer: 35 / 135 42 479<br />Ust-IdNr: DE 326 50 48 56',
        'footer_line_1' => 'Oliver Reinking | Diplom-Mathematiker | D-66482 Zweibrücken | Telefon: 06332 - 993 993',
        'footer_line_2' => 'E-Mail: oliver@kreativschreiber.com',
        'footer_line_3' => 'ING Diba | BIC INGDDEFFXX| IBAN DE77 5001 0517 5594 5787 63',
        'footer_line_4' => 'Ust-IdNr: DE 326 50 48 56 | Steuer-Nr 35 / 135 / 42 479',
    ],
    // Plattform-Daten
    'platform' => [
        'name' => 'KreativSchreiber',
        'admin_person_company_id' => Administration::ADMIN_KREATIVSCHREIBER_ID,
    ],
    // Anwendungsnamen
    'application' => [
        'administration' => 'Administration',
        'customer' => 'Kunde',
    ],
    // API-Keys
    'api_keys' => [
        'open_ai' => env('OPEN_AI_API_KEY'),
    ],
    // Kontakt
    'contact' => [
        'info' => 'Bei Fragen wende dich an:<br /><br /><b>KreativSchreiber</b><br />Erstellung von Werbe- und Blogtexten<br /><br />Adresse:<br />Nordpfad 25<br />66482 Zweibrücken<br /><br />Ansprechpartner:<br />Oliver Reinking<br />Mail: oliver[at]kreativschreiber.com<br />Telefon: 06332 993 993',
        'admin' => '<b>KreativSchreiber</b><br />Erstellung von Werbe- und Blogtexten<br /><br />Nordpfad 25<br />66482 Zweibrücken<br /><br />Oliver Reinking<br />Mail: oliver[at]kreativschreiber.com<br />Telefon: 06332 993 993',
    ],
    // Mailadressen
    'mail' => [
        'mailFooterContent' => 'Die Web-Anwendung KreativSchreiber wurde entwickelt von <br />Oliver Reinking, Diplom-Mathematiker<br />Nordpfad 25<br />66482 Zweibrücken<br /><br />Mail: oliver[at]kreativschreiber.com<br />Telefon: 06332 993 993<br />Web: https://oliverreinking.github.io/',
    ],
];
