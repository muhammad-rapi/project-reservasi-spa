<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReservationResource\Pages;
use App\Models\Payment;
use Filament\Notifications\Notification;
use App\Models\Reservation;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\IconPosition;
use Filament\Infolists\Components;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationLabel = 'Data Reservasi';

    protected static ?string $label = 'Data Reservasi';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reservasi_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('baby_spa.spa_type')
                    ->label('Pilihan Treatment')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('baby_spa.jenis')
                    ->label('Jenis Treatment')
                    ->numeric()
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
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('baby_spa.price')
                    ->label('Harga Treatment')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid')
                    ->label('Status')
                    ->formatStateUsing(function ($state) {
                        return $state ? 'Lunas' : 'Pending';
                    })
                    ->color(function ($state) {
                        return $state ? 'success' : 'warning';
                    })
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
                Tables\Actions\Action::make('Approve')
                    ->hidden(fn($record): bool => $record->payment->status === Payment::PAID)
                    ->form(fn($record) => [
                        Forms\Components\TextInput::make('status')
                            ->label('Status Pembayaran'),
                        Forms\Components\TextInput::make('name')
                            ->label('Metode Pembayaran'),
                        Forms\Components\FileUpload::make('bukti_pembayaran')
                            ->label('Bukti Pembayaran'),
                    ])
                    ->fillForm(fn($record): array => [
                        'status' => $record->payment->status,
                        'name' => $record->payment->name,
                        'bukti_pembayaran' => $record->payment->bukti_pembayaran,
                    ])
                    ->disabledForm()
                    ->color('warning')
                    ->action(function (array $data, $record): void {
                        $payment = Payment::where('reservation_id', $record->id)->first();

                        if (!$payment) {
                            $payment = new Payment();
                            $payment->reservation_id = $record->id;
                        }

                        $payment->bukti_pembayaran = $data['bukti_pembayaran'];
                        $payment->status = Payment::PAID;
                        $payment->save();

                        $record->paid = true;
                        $record->save();

                        $recipient = auth()->user();
                        Notification::make()
                            ->title('Approve Pembayaran Berhasil')
                            ->body('Anda berhasil approve Pembayaran')
                            ->success()
                            ->send()
                            ->sendToDatabase($recipient);
                    })
                    ->icon('heroicon-m-arrow-up-tray')
                    ->iconPosition(IconPosition::Before),
                Tables\Actions\DeleteAction::make()
                    ->visible(function ($record) {
                        return !$record->paid;
                    }),
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
                                ->schema(fn($record) => [
                                    Components\Group::make([
                                        TextEntry::make('reservasi_date'),
                                        TextEntry::make('baby_name')
                                            ->label('Nama Bayi')
                                            ->visible(fn($record) => $record->baby_spa->jenis == 'Anak'),
                                        TextEntry::make('baby_weight')
                                            ->label('Berat Bayi')
                                            ->visible(fn($record) => $record->baby_spa->jenis == 'Anak'),
                                        TextEntry::make('baby_ages')
                                            ->label('Umur Bayi')
                                            ->visible(fn($record) => $record->baby_spa->jenis == 'Anak'),
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
            'edit' => Pages\EditReservation::route('/{record}/edit'),
            'view' => Pages\ViewReservation::route('/{record}/view'),
        ];
    }
}
