<?php

return [
    'model_not_found' => [
        'help' => 'Check your table and searching parameter and try again',
        'error' => ':model with id :id not found.'
    ],
    'model_not_updated' => [
        'help' => 'Check your updating parameter and try again',
        'error' => ':model with id :id not updated.'
    ],
    'model_not_deleted' => [
        'help' => 'Check your deleting parameter and try again',
        'error' => ':model with id :id not deleted.'
    ],
    'user_not_present' => [
        'help' => 'Perform login again.',
        'error' => 'Whops... Something unexpected happen with your user.'
    ],
    'data_validation' => 'Data validation failed.',
    'record_already_exists' => [
        'error' => 'This record already exists.',
        'help' => 'Check the information and try again.',
    ],
    'attribute_not_exists' => [
        'error' => 'Attribute not exists on model.',
        'help' => ':model doesn\'t have attribute :attr',
    ],
    'json_not_encoded' => [
        'error' => 'Error.php couldn\'t encode itself into JSON',
        'help' => 'Make sure all properties are mapped into the toArray()',
    ]
];
