<?php

return [

        /**
         * Models
         */
        'models' => [
            /**
             * Role Model
             */
            'role_model' => \JetBox\Permission\Models\Role::class,

            /**
             * Permission Model
             */
            'permission_model' => \JetBox\Permission\Models\Permission::class,
        ],

        /**
         * Tables
         */
        'tables' => [
            /**
             *
             */
            'pivot_roles' => 'model_has_roles'
        ]

];
