<?php

namespace App\Filament\Resources;

use App\Enums\ProductTypeEnum;
use Carbon\Carbon;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';
    protected static ?string $navigationGroup='Shop';
    protected static ?string $navigationLabel='Products';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                ->schema([
                  Forms\Components\Section::make('General Details:')
                      ->schema([  
                            Forms\Components\TextInput::make('name') 
                                                    ->required() 
                                                    ->placeholder('e.g. Branded T-Shirt')
                                                    ->label('Product Name'),
                            Forms\Components\TextInput::make('slug')
                                                    ->required() 
                                                    ->placeholder('e.g. branded-t-shirt')   
                                                    ->label('Product Slug'),
                            Forms\Components\MarkdownEditor::make('description')
                                                    ->label('Product Description')
                                                    ->placeholder('e.g. this is a branded t-shirt. ...')
                                                    ->columnSpan('full'),
                      ])->columns(2),

                      Forms\Components\Section::make('Price & Inventory:')
                      ->schema([  
                            Forms\Components\TextInput::make('sku') 
                                                    ->required() 
                                                    ->unique()
                                                    ->placeholder('e.g. branded-t-shirt')
                                                    ->label('SKU'),
                            Forms\Components\TextInput::make('price')
                                                    ->required() 
                                                    ->placeholder('e.g. 700')   
                                                    ->label('Price (KES)'),
                            Forms\Components\TextInput::make('quantity')
                                                    ->required() 
                                                    ->placeholder('e.g. 10')   
                                                    ->label('Quantity'),
                            Forms\Components\Select::make('type')
                                                    ->required()
                                                    ->options([   
                                                      'downloadable' => ProductTypeEnum::DOWNLOADABLE ->value,
                                                      'deliverable' => productTypeEnum::DELIVERABLE ->value,
                                                    ])
                                                    ->label('Type'),
                      ]) ->columns(2),

                ]),

                Forms\Components\Group::make()
                ->schema([
                  Forms\Components\Section::make('Status Details:')
                      ->schema([  
                            Forms\Components\Toggle::make('is_visible')
                                                    ->label('Is it visible?'),
                            Forms\Components\Toggle::make('is_featured')  
                                                    ->label('Is it featured?'),
                            Forms\Components\DatePicker::make('published_at')
                                                    ->required()
                                                    ->maxDate(Carbon::now())
                                                    ->label('Published Date')
                                                    ->placeholder('Select a date'),
                                                    
                      ]),

                  Forms\Components\Section::make('Product Image:')
                      ->schema([  
                            Forms\Components\FileUpload::make('image')
                                                    ->label('Select an Image')
                                                    ->required(),
                                                    
                      ]) ->collapsible(),

                  Forms\Components\Section::make('Association:')
                      ->schema([  
                            Forms\Components\Select::make('brand_id')
                                                    ->label('Brand')
                                                    ->relationship('brand', 'name')
                                                    ->required(),
                                                    
                      ]),

                ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('brand.name'),
                Tables\Columns\IconColumn::make('is_visible')->boolean(),
                Tables\columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('published_at'),
                Tables\Columns\TextColumn::make('type')
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
