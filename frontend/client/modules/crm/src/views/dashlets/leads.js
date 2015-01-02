/************************************************************************
 * This file is part of AppsZure.
 *
 * AppsZure - Open Source CRM application.
 * Copyright (C) 2014  Yuri Kuznetsov, Taras Machyshyn, Oleksiy Avramenko
 * Website: http://www.AppsZure.com
 *
 * AppsZure is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AppsZure is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with AppsZure. If not, see http://www.gnu.org/licenses/.
 ************************************************************************/ 

Espo.define('Crm:Views.Dashlets.Leads', 'Views.Dashlets.Abstract.RecordList', function (Dep) {

    return Dep.extend({

        name: 'Leads',

        scope: 'Lead',

        defaultOptions: {
            sortBy: 'createdAt',
            asc: false,
            displayRecords: 5,
            expandedLayout: {
                rows: [
                    [
                        {
                            name: 'name',
                            link: true,
                        },
                        {
                            name: 'addressCity'
                        }
                    ],
                    [
                        {
                            name: 'status'
                        },
                        {
                            name: 'source'
                        }
                    ]
                ]
            },
            searchData: {
                bool: {
                    onlyMy: true,
                },
                advanced: {
                    status: {
                        type: 'notIn',
                        value: ['Converted', 'Hoax', 'Dead']
                    },
                },

            },
        },

    });
});

