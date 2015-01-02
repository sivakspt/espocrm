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

Espo.define('Controllers.Preferences', 'Controllers.Record', function (Dep) {
            
    return Dep.extend({        
    
        defaultAction: 'own',        
        
        getModel: function (callback) {        
            var model = new Espo['Models.Preferences']();
            model.settings = this.getConfig();
            model.defs = this.getMetadata().get('entityDefs.Preferences');            
            callback.call(this, model);
        },    
    
        checkAccess: function (action) {
            return true;            
        },
    
        own: function () {
            this.edit({
                id: this.getUser().id
            });
        },        
        
        list: function () {},    
    });    
});


