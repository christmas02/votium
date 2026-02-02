<?php

namespace App\Enums;

enum PaymentMethod: string
{
    // un tableau des methodes de paiement avec leurs valeurs respectives plus icones
    case MTN = 'mtn';
    case ORANGE_MONEY = 'orange_money';
    case MOOV_MONEY = 'moov_money';
    case WAVE = 'wave';

    public function icon(): string
    {
        return match($this) {
            self::MTN => 'mtn_ci.jpg',
            self::ORANGE_MONEY => 'orange_ci.png',
            self::MOOV_MONEY => 'flooz_ci.png',
            self::WAVE => 'waveci_ci.png',
        };
    }

    public function label(): string
    {
        return match($this) {
            self::ORANGE_MONEY => 'orange',
            self::MTN => 'mtn',
            self::MOOV_MONEY => 'flooz',
            self::WAVE => 'wave',
        };
    }

    public function optionPayment(): array
    {
        return match($this) {
            self::ORANGE_MONEY => ['provider' => 'orange_money', 'params' => [ 'api_processing' => 'hub2','message' => 'Tapez le #144*82# + option 2 pour obtenir le code de paiement,', 'fields' => ['codOtp']  ] ],
            self::MTN => ['provider' => 'mtn', 'api_processing' => 'hub2'],
            self::MOOV_MONEY => ['provider' => 'moov_money', 'api_processing' => 'hub2'],
            self::WAVE => ['provider' => 'wave', 'api_processing' => 'hub2'],
        };
    }
}