<?php

use App\InputType;
use Illuminate\Database\Seeder;

class InputTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $inputTypes = [
            [
                'type' => 'radio',
                'display_name' => 'Opción Múltiple'
            ],
            [
                'type' => 'text',
                'display_name' => 'Párrafo Corto'
            ],
            [
                'type' => 'checkbox',
                'display_name' => 'Casilla De Verificación'
            ],
            [
                'type' => 'select',
                'display_name' => 'Lista Desplegable'
            ],
            [
                'type' => 'textarea',
                'display_name' => 'Texto Largo'
            ]
        ];

        collect($inputTypes)->each(function ($inputType) {
            InputType::create($inputType);
        });
    }
}
