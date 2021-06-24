<?php

return [

    /**
     * Models
     */
    'models' => [

        /**
         * 'App\User' | 'App\Models\User'
         * User Model
         */
        'user' => 'App\User',

        /**
         * Role Model
         */
        'role' => \JetBox\Permission\Models\Role::class,

        /**
         * Permission Model
         */
        'permission' => \JetBox\Permission\Models\Permission::class,
    ],

    /**
     * Tables
     */
    'tables' => [

        /**
         * pivot_roles Table
         */
        'model_has_roles' => 'model_has_roles',

        /**
         * permissions Table
         */
        'permissions' => 'permissions',

        /**
         * permission_role Table
         */
        'permission_role' => 'permission_role',

        /**
         * roles Table
         */
        'roles' => 'roles'
    ],

    /**
     * columns
     */
    'columns' => [

        /**
         * model
         */
        'morphs' => 'model',

        /**
         * related pivot key
         */
        'role_id' => 'role_id',

        /**
         * model_id
         */
        'morph_key' => 'model_id',

        /**
         * permission_id
         */
        'permission_id' => 'permission_id'
    ]
];
