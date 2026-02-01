<?php
// app/Sdkpayment/Contracts/PaymentRequestInterface.php
namespace App\Sdkpayment\Contracts;

interface PaymentRequestInterface
{
    public function getPhone(): string;
    public function getAmount(): float;
    public function getMetadata(): array;
    public function getCallback(): ?string;
    public function getEmail(): ?string;
    public function getAccessToken(): string;
    public function toArray(): array;
}