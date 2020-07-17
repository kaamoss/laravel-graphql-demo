<?php


namespace App\GraphQL\Query;

use GraphQL;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class UsersQuery extends Query {
    protected $attributes = [
        'name' => 'users',
    ];
    protected $locationSvc;

    public function __construct()
    {
        //TODO: inject services or repositories
    }

    public function type(): Type
    {
        return Type::nonNull(Type::listOf(GraphQL::type('User')));
        //return GraphQL::paginate('User');
    }

    public function args(): array
    {
        return [
            'excludeArchived' => ['name' => 'excludeArchived', 'type' => Type::boolean()],
            'numPerPage' => ['name' => 'numPerPage', 'type' => Type::int()],
            'page' => ['name' => 'page', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        //$serviceContext = $this->getServiceContext($root, $args, $context, $info);
        $page = null;
        $numPerPage = null;
        $includeArchived = null;
        if (isset($args['page'])) {
            $page = $args['page'];
        }
        if (isset($args['numPerPage'])) {
            $numPerPage = $args['numPerPage'];
        }
        if (isset($args['excludeArchived'])) {
            $includeArchived = !$args['excludeArchived'];
        }

        return [
            [
                'id'=>1,
                'email'=>'foo@bar.com',
                'firstName'=>'Jerk',
                'lastName'=>'Face',
            ],
            [
                'id'=>2,
                'email'=>'baz@bar.com',
                'firstName'=>'Tom',
                'lastName'=>'Sawyer',
            ],
            [
                'id'=>3,
                'email'=>'bar@bar.com',
                'firstName'=>'Huckleberry',
                'lastName'=>'Finn',
            ],
        ];
    }
}

