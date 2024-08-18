<?php

namespace App\Filament\Resources;

use App\Enums\JenisSpa;
use Filament\Support\Enums\Alignment;
use App\Filament\Resources\TreatmentResource\Pages;
use App\Models\Babyspa;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Form;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\Layout\Split;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TreatmentResource extends Resource
{
    protected static ?string $model = Babyspa::class;

    protected static ?string $navigationIcon = 'heroicon-o-home-modern';

    protected static ?string $navigationLabel = 'Pilihan Treatment';

    protected static ?string $label = 'Pilihan Treatment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('spa_type')
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => "Tipe Spa Wajib Disi",
                    ])
                    ->maxLength(255),
                Forms\Components\Radio::make('jenis')
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => "Jenis Spa Wajib Disi",
                    ])
                    ->options([
                        'Ibu' => 'Ibu',
                        'Anak' => 'Anak',
                    ])
                    ->inline()
                    ->inlineLabel(false),
                Forms\Components\TextArea::make('manfaat')
                    ->autosize(),
                Forms\Components\TextInput::make('price')
                    ->rules(['required'])
                    ->validationMessages([
                        'required' => "Harga Wajib Disi",
                    ])
                    ->numeric()
                    ->prefix('Rp'),
                Forms\Components\FileUpload::make('image')
                    ->rules(['max:2048'])
                    ->acceptedFileTypes(['.jpg', '.jpeg', '.png'])
                    ->validationMessages([
                        'max' => "Ukuran Gambar Terlalu Besar, Maksimal 2 MB",
                    ])
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->contentGrid([
                'sm' => 3,
                'md' => 1,
                'xl' => 1,
            ])
            ->columns([
                Split::make([
                    ImageColumn::make('image')
                        // ->grow(false)
                        ->width(350)
                        ->height(200),
                    Split::make([
                        Stack::make([
                            TextColumn::make('spa_type')
                                ->weight(FontWeight::Bold)
                                ->description(fn ($record) => $record->jenis)
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
                ]),
                Stack::make([
                    // TextColumn::make('created_at')
                    //     ->label('Created At')
                    //     ->dateTime()
                    //     ->sortable()
                ])
                    ->alignment(Alignment::End)
                // ->visibleFrom('md'),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                ViewAction::make(),
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
                TextEntry::make('updated_at')
                    ->label('Tanggal Diupdate')
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
            'create' => Pages\CreateTreatment::route('/create'),
            'edit' => Pages\EditTreatment::route('/{record}/edit'),
        ];
    }
}
