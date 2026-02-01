<?php
namespace App\Sdkpayment\Hyperfast\Request;

use App\Sdkpayment\Contracts\PaymentRequestInterface;
use InvalidArgumentException;

class PaymentRequest implements PaymentRequestInterface
{
    private string $phone;
    private float $amount;
    private array $metadata;
    private ?string $callback;
    private ?string $email;
    private string $accessToken;

    public function __construct(array $data)
    {
        if (empty($data['phone']) || !isset($data['amount']) || empty($data['access_token'])) {
            throw new InvalidArgumentException('Champs requis manquants: phone, amount, access_token');
        }

        $this->phone = (string) $data['phone'];
        $this->amount = is_numeric($data['amount']) ? (float) $data['amount'] : throw new InvalidArgumentException('amount doit être numérique');
        $this->metadata = isset($data['metadata']) && is_array($data['metadata']) ? $data['metadata'] : [];
        $this->callback = $data['callback'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->accessToken = (string) $data['access_token'];
    }

    public function getPhone(): string { return $this->phone; }
    public function getAmount(): float { return $this->amount; }
    public function getMetadata(): array { return $this->metadata; }
    public function getCallback(): ?string { return $this->callback; }
    public function getEmail(): ?string { return $this->email; }
    public function getAccessToken(): string { return $this->accessToken; }

    public function toArray(): array
    {
        return [
            'phone' => $this->phone,
            'amount' => $this->amount,
            'metadata' => $this->metadata,
            'callback' => $this->callback,
            'email' => $this->email,
            'access_token' => $this->accessToken,
        ];
    }
}