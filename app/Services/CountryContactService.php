<?php

namespace App\Services;

use App\Models\CountryContact;

class CountryContactService
{
    public static function getContact(string $countryCode = 'TR'): array
    {
        $locale  = app()->getLocale();
        $code    = strtoupper($countryCode);
        $contact = CountryContact::getForCountry($code) ?? CountryContact::getDefault();

        if (!$contact) {
            return [
                'phone'      => '',
                'whatsapp'   => '',
                'email'      => '',
                'address'    => '',
                'currency'   => 'USD',
                'symbol'     => '$',
                'price_field'=> 'price_usd',
                'has_custom' => false,
            ];
        }

        return [
            'phone'      => $contact->phone ?? '',
            'whatsapp'   => $contact->whatsapp ?? '',
            'email'      => $contact->email ?? '',
            'address'    => $contact->getAddress($locale),
            'currency'   => $contact->currency_code,
            'symbol'     => $contact->currency_symbol,
            'price_field'=> $contact->price_field,
            'has_custom' => $contact->country_code !== null,
        ];
    }
}
