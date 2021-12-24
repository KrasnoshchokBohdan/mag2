define(['uiComponent'], function (Component){
    'use strict';
    return Component.extend({
        defaults:{
            template: 'MageMastery_Blog/blog'
        }
        ,initialize: function () {
            this._super();

            console.log(this.posts);
            return this;
        },

        getDate: function (value){
            const date = new Date(value);
            const formatter = Intl.DateTimeFormat('en', {month: "short"});
            const month = formatter.format(date);

            return month + " " + date.getDate() + " " + date.getFullYear();
        }
    });

});
