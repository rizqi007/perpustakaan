<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public ?string $captchaAnswer = null;

    public function mount(): void
    {
        parent::mount();

        $this->generateCaptcha();
    }

    protected function generateCaptcha(): void
    {
        session()->put('login_captcha', str_pad(random_int(0, 999), 3, '0', STR_PAD_LEFT));
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getCaptchaFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getCaptchaFormComponent(): Component
    {
        return ViewField::make('captcha_display')
            ->view('filament.forms.components.captcha-field')
            ->dehydrated(false);
    }

    public function authenticate(): ?LoginResponse
    {
        $captchaInput = $this->data['captcha'] ?? '';
        $captchaExpected = session()->get('login_captcha');

        if ($captchaInput !== $captchaExpected) {
            $this->generateCaptcha();

            throw ValidationException::withMessages([
                'data.captcha' => 'Captcha salah. Silakan coba lagi.',
            ]);
        }

        return parent::authenticate();
    }

    public function refreshCaptcha(): void
    {
        $this->generateCaptcha();
    }
}
