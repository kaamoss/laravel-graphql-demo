<?php


namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType {

    protected $attributes = [
        'name'        => 'User',
        'description' => 'Information about a user',
    ];

    public function fields(): array {
        return [
            'id'               => [
                'type'        => Type::nonNull(Type::int()),
                'description' => 'The id of the user',
            ],
            'email'               => [
                'type'        => Type::nonNull(Type::string()),
                'description' => 'The email of the user',
            ],
            'firstName'               => [
                'type'        => Type::string(),
                'description' => 'The first name of the user if it has one',
            ],
            'lastName'               => [
                'type'        => Type::string(),
                'description' => 'The last name of the user if they have one',
            ],
            'displayName' => [
                'type'        => Type::string(),
                'description' => 'The display name of the user',
                'resolve'     => function($root, $args) {
                    $displayName = trim($root['firstName']);
                    if($displayName !== '' && $root['lastName'] !== '') {
                        $displayName .= ' ';
                    }
                    if($root['lastName'] !== '') {
                        $displayName .= $root['lastName'];
                    }
                    return $displayName;
                },
            ],
        ];
    }
}
