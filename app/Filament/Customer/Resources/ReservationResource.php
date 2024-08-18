<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\ReservationResource\Pages;
use App\Models\Babyspa;
use App\Models\Payment;
use App\Models\Reservation;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Infolists\Components;
use Filament\Infolists\Components\IconEntry;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationLabel = 'Data Reservasi';

    protected static ?string $label = 'Data Reservasi';

    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\Select::make('baby_spa_id')
    //                 ->rules(['required'])
    //                 ->validationMessages([
    //                     'required' => "Pilihan Treatment Wajib Disi",
    //                 ])
    //                 ->relationship('baby_spa', 'spa_type')
    //                 ->options(Babyspa::all()->pluck('spa_type', 'id'))
    //                 ->label('Pilihan Treatment')
    //                 ->native(false)
    //                 ->searchable(),
    //             Forms\Components\TextInput::make('baby_name'),
    //             Forms\Components\TextInput::make('baby_weight'),
    //             Forms\Components\TextInput::make('baby_ages'),
    //             Forms\Components\DatePicker::make('reservasi_date')
    //                 ->native(false)
    //                 ->rules(['required'])
    //                 ->validationMessages([
    //                     'required' => "Tanggal Reservasi Wajib Disi",
    //                 ])
    //         ]);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reservasi_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('baby_spa.spa_type')
                    ->label('Pilihan Treatment')
                    ->sortable(),
                Tables\Columns\TextColumn::make('baby_spa.jenis')
                    ->label('Jenis Treatment')
                    ->sortable(),
                Tables\Columns\TextColumn::make('baby_name')
                    ->default('Tidak Ada Data')
                    ->sortable(),
                Tables\Columns\TextColumn::make('baby_weight')
                    ->default('Tidak Ada Data')
                    ->sortable(),
                Tables\Columns\TextColumn::make('baby_age')
                    ->default('Tidak Ada Data'),
                Tables\Columns\TextColumn::make('customer.fullname')
                    ->sortable(),
                Tables\Columns\TextColumn::make('baby_spa.price')
                    ->label('Harga Treatment')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => $state ? 'Lunas' : 'Pending')
                    ->color(fn ($state) => $state ? 'success' : 'warning')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Upload Bukti Pembayaran')
                    ->form(fn ($record) => [
                        Forms\Components\FileUpload::make('bukti_pembayaran')
                            ->label('Upload Bukti Pembayaran')
                            ->rules(['required', 'image', 'max:2048'])
                            ->acceptedFileTypes(['image/*'])
                            ->validationMessages([
                                'required' => "Bukti Pembayaran Wajib Disi",
                                'image' => "Bukti Pembayaran harus berupa gambar",
                                'max' => "Ukuran gambar tidak boleh lebih dari 2MB",
                            ])
                    ])
                    ->color('warning')
                    ->action(function (array $data, $record): void {
                        // Save the uploaded file
                        $payment = Payment::where('reservation_id', $record->id)->first();

                        if (!$payment) {
                            $payment = new Payment();
                            $payment->reservation_id = $record->id;
                        }

                        $payment->bukti_pembayaran = $data['bukti_pembayaran'];
                        $payment->status = Payment::PAID;
                        $payment->save();

                        // Update the reservation status
                        $record->paid = true;
                        $record->save();

                        $recipient = auth()->user();
                        Notification::make()
                            ->title('Pembayaran Berhasil')
                            ->body('Anda berhasil melakukan Pembayaran')
                            ->success()
                            ->send()
                            ->sendToDatabase($recipient);
                    })
                    ->icon('heroicon-m-arrow-up-tray')
                    ->iconPosition(IconPosition::Before)
                    ->visible(fn ($record) => !$record->paid),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn ($record) => !$record->paid),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }



    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Reservasi Customer')
                    ->schema([
                        Components\Split::make([
                            Components\Grid::make(2)
                                ->schema([
                                    Components\Group::make([
                                        TextEntry::make('reservasi_date'),
                                        TextEntry::make('baby_name')
                                            ->label('Nama Bayi'),
                                        TextEntry::make('baby_weight')
                                            ->label('Berat Bayi'),
                                        TextEntry::make('baby_age')
                                            ->label('Umur Bayi'),
                                    ]),
                                    Components\Group::make([
                                        TextEntry::make('baby_spa.spa_type')
                                            ->label('Pilihan Treatment'),
                                        TextEntry::make('customer.fullname'),
                                        TextEntry::make('baby_spa.price')
                                            ->label('Harga Treatment'),
                                        IconEntry::make('paid')
                                            ->boolean()
                                            ->label('Status'),
                                    ]),
                                ]),
                            Components\ImageEntry::make('image')
                                ->hiddenLabel()
                                ->grow(false),
                        ])->from('xl'),
                    ])
            ]);
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
            'view' => Pages\ViewReservation::route('/{record}/view'),
        ];
    }
}
