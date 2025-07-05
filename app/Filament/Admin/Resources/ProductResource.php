<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Filament\Admin\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
    ->schema([
        Forms\Components\TextInput::make('name')
            ->label('Product Name')
            ->required()
            ->maxLength(255),

        Forms\Components\Textarea::make('description')
            ->label('Product Description')
            ->maxLength(1000)
            ->columnSpan('full'),

        Forms\Components\TextInput::make('price')
            ->label('Price (NPR)')
            ->numeric()
            ->required()
            ->minValue(0),
    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
    Tables\Columns\TextColumn::make('id')
            ->rowIndex()
            ->sortable()
        ->searchable(),

    Tables\Columns\TextColumn::make('name')
        ->label('Product Name')
        ->sortable()
        ->searchable(),

    Tables\Columns\TextColumn::make('description')
        ->limit(50)
        ->wrap()
        ->label('Description')
        ->sortable(),

    Tables\Columns\TextColumn::make('price')
        ->money('NRP') // or 'NPR' if you're in Nepal
        ->sortable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
