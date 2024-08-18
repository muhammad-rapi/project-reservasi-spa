<?php

namespace App\Filament\Pages\Authentication;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Register as BaseRegister;

class AdminRegisterPage extends BaseRegister
{

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('fullname')
                ->rules(['required'])
                ->validationMessages([
                    'required' => "Nama Lengkap Wajib Diisi",
                ])
                ->placeholder('Nama Lengkap Anda...')
                ->maxLength(255),
            TextInput::make('username')
                ->rules(['required'])
                ->validationMessages([
                    'required' => "Username Wajib Diisi",
                ])
                ->placeholder('Masukkan username anda'),
            $this->getEmailFormComponent()
                ->rules(['required'])
                ->validationMessages([
                    'required' => "Email Wajib Diisi",
                    'unique' => "Email sudah digunakan",
                ])
                ->placeholder('example@spa.com'),
            $this->getPasswordFormComponent()
                ->rules(['required'])
                ->validationMessages([
                    'required' => "Password Wajib Diisi",
                    'min' => "Password Minimal 8 Karakter",
                ])
                ->placeholder('Masukkan password anda...'),
            $this->getPasswordConfirmationFormComponent(),
            TextInput::make('phone_number')
                ->rules(['required'])
                ->validationMessages([
                    'required' => "Nomor Hp Wajib Diisi",
                    'unique' => "Nomor Hp sudah digunakan",
                ])
                ->placeholder('Masukkan No. Hp anda...')
                ->numeric(),
            Radio::make('gender')
                ->options([
                    'pria' => 'Pria',
                    'wanita' => 'Wanita'
                ])
                ->inline()
                ->inlineLabel(false),
            Hidden::make('role')
                ->default('admin')
        ])
            ->statePath('data');
    }
}
