<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\TreatmentResource\Pages;
use App\Models\Babyspa;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TreatmentResource extends Resource
{
    protected static ?string $model = Babyspa::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationLabel = 'Pilihan Treatment';

    protected static ?string $label = 'Pilihan Treatment';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    ImageColumn::make('image')
                        // ->grow(false)
                        ->width(250)
                        ->height(200),
                        // ->size(250),
                    Split::make([
                        Stack::make([
                            TextColumn::make('spa_type')
                                ->weight(FontWeight::Bold)
                                ->description(fn($record) => $record->jenis)
                                ->label('Jenis Spa')
                                ->searchable(),
                            TextColumn::make('manfaat')
                                ->weight(FontWeight::Thin)
                                ->label('Manfaat Spa'),
                            TextColumn::make('price')
                                ->weight(FontWeight::Bold)
                                ->money('IDR', locale: 'id')
                                ->sortable(),
                        ])
                            ->alignment(Alignment::End),
                    ]),
                ])
                ->from('md')
                ,
                Stack::make([
                    // TextColumn::make('created_at')
                    //     ->label('Created At')
                    //     ->dateTime()
                    //     ->sortable()
                ])
                    ->alignment(Alignment::End)
                // ->visibleFrom('md'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Reservasi')
                    ->steps([
                        Step::make('Masukkan Data Reservasi')
                            ->description('Lengkapi Data Reservasi Anda')
                            ->schema(fn($record) => [
                                Hidden::make('baby_spa_id')
                                    ->default($record->id),
                                Forms\Components\Group::make([
                                    Forms\Components\TextInput::make('baby_name')
                                        ->visible(fn($record) => $record->jenis == 'Anak'),
                                    Forms\Components\TextInput::make('baby_weight')
                                        ->visible(fn($record) => $record->jenis == 'Anak'),
                                    Forms\Components\TextInput::make('baby_ages')
                                        ->visible(fn($record) => $record->jenis == 'Anak'),
                                ]),
                                Forms\Components\DatePicker::make('reservasi_date')
                                    ->minDate(Carbon::now()->format('Y-m-d'))
                                    ->native(false)
                                    ->rules(['required'])
                                    ->validationMessages([
                                        'required' => "Tanggal Reservasi Wajib Disi",
                                    ])
                            ]),
                        Step::make('Pilih Metode Pembayaran')
                            ->description('Pilih Metode Pembayaran yang Anda Inginkan')
                            ->schema(fn(Reservation $data) => [
                                Hidden::make('reservation_id')
                                    ->default($data->id),
                                Radio::make('name')
                                    ->label('Metode Pembayaran')
                                    ->options([
                                        'Gopay' => 'Gopay',
                                        'OVO' => 'OVO',
                                        'Bank BRI' => 'Bank BRI',
                                        'Bank BCA' => 'Bank BCA',
                                    ])
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        $rekeningNumbers = [
                                            'Gopay' => '1234567890',
                                            'OVO' => '0987654321',
                                            'Bank BRI' => '1111222233',
                                            'Bank BCA' => '4444555566',
                                        ];
                                        $set('rekening_number', $rekeningNumbers[$state] ?? '');
                                    }),

                            ]),
                        Step::make('Masukkan Detail Pembayaran')
                            ->description('Masukkan Detail Pembayaran Anda')
                            ->schema(
                                fn($record) =>  [
                                    TextInput::make('rekening_number')
                                        ->label('Rekening Tujuan')
                                        ->readOnly()
                                        ->numeric(),
                                    TextInput::make('amount_of_payments')
                                        ->label('Nominal Pembayaran')
                                        ->prefix('Rp')
                                        ->default($record->price)
                                        ->rules(['required'])
                                        ->validationMessages([
                                            'required' => "Jumlah Pembayaran Wajib Diisi",
                                        ])
                                        ->numeric(),
                                    DatePicker::make('date_of_payment')
                                        ->minDate(Carbon::now()->format('Y-m-d'))
                                        ->label('Tanggal Pembayaran')
                                        ->default(Carbon::now())
                                        ->native(false)
                                        ->rules(['required'])
                                        ->validationMessages([
                                            'required' => "Tanggal Pembayaran Wajib Disi",
                                        ]),
                                ]
                            ),
                    ])
                    ->color('warning')
                    ->action(function (array $data): void {

                        $reservasiCount = Reservation::whereDate('reservasi_date', $data['reservasi_date'])->count();

                        if ($reservasiCount >= 6) {
                            Notification::make()
                                ->title('Tidak bisa melakukan reservasi !')
                                ->body('Reservasi untuk tanggal tersebut sudah penuh, silakan coba dihari lain.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $reservation = new Reservation();
                        $reservation->baby_name = isset($data['baby_name']) ? $data['baby_name'] : null;
                        $reservation->baby_weight = isset($data['baby_weight']) ? $data['baby_weight'] : null;
                        $reservation->baby_age = isset($data['baby_age']) ? $data['baby_age'] : null;
                        $reservation->reservasi_date = $data['reservasi_date'];
                        $reservation->baby_spa_id = $data['baby_spa_id'];
                        $reservation->paid = false;
                        $reservation->save();

                        $payment = new Payment();
                        $payment->reservation_id = $reservation->id;
                        $payment->name = $data['name'];
                        $payment->rekening_number = $data['rekening_number'];
                        $payment->amount_of_payments = $data['amount_of_payments'];
                        $payment->date_of_payment = $data['date_of_payment'];
                        $payment->save();

                        $reservation->save();

                        $recipient = auth()->user();
                        Notification::make()
                            ->title('Reservasi Berhasil')
                            ->body('Anda berhasil melakukan reservasi')
                            ->success()
                            ->send()
                            ->sendToDatabase($recipient);
                    })

                    ->icon('heroicon-m-arrow-up-tray')
                    ->iconPosition(IconPosition::Before)
                    ->button(),
                Tables\Actions\ViewAction::make()
                    ->button(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('spa_type'),
                TextEntry::make('jenis'),
                TextEntry::make('price')
                    ->money('IDR', locale: 'id'),
                ImageEntry::make('image'),
                TextEntry::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime(),
            ])
            ->columns(1)
            ->inlineLabel();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTreatments::route('/'),
            // 'create' => Pages\CreateTreatment::route('/create'),
            // 'edit' => Pages\EditTreatment::route('/{record}/edit'),
        ];
    }
}
