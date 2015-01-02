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
Espo.define('Views.User.Fields.Name', 'Views.Fields.PersonName', function (Dep) {

    return Dep.extend({
    
        listTemplate: 'user.fields.name.list-link',

        listLinkTemplate: 'user.fields.name.list-link',

        data: function () {
            return _.extend({
                avatar: this.getAvatarHtml()
            }, Dep.prototype.data.call(this));
        },

        getAvatarHtml: function () {
            if (this.getConfig().get('disableAvatars')) {
                return '';
            }
            var t;
            var cache = this.getCache();
            if (cache) {
                t = cache.get('app', 'timestamp');
            } else {
                t = Date.now();
            }
            return '<img class="avatar avatar-link" width="16" src="?entryPoint=avatar&size=small&id=' + this.model.id + '&t='+t+'">';
        },

    });
    
});
