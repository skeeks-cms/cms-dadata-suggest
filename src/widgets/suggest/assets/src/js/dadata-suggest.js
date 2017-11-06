/*!
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.09.2016
 */
(function(sx, $, _)
{
    sx.classes.DadataSuggest = sx.classes.Component.extend({

        _init: function()
        {
            var self = this;

            this.AjaxQuery = sx.ajax.preparePostQuery(this.get('backend'));

            if (this.get('onInit'))
            {
                this.bind('onInit', this.get('onInit'));
            }

            if (this.get('onSelect'))
            {
                this.bind('onSelect', this.get('onSelect'));
            }

            self.trigger('onInit', {
                'DadataSuggest': self
            });
        },

        _onDomReady: function()
        {
            var self = this;

            $("#" + this.get('id')).suggestions(_.extend(this.get('suggestOptions'), {
                'onSelect' : function(data)
                {
                    self.set('geoobject', data);
                    self.trigger('onSelect', data);
                }
            }));
        },

        save: function()
        {
            var self = this;

            self.trigger('beforeSave', {
                'DadataSuggest': self
            });

            this.AjaxQuery.setData({
                'geoobject': self.get('geoobject')
            });

            this.AjaxQuery.bind("success", function(e, data)
            {
                self.trigger('afterSave', {
                    'DadataSuggest': self
                });
            });

            this.AjaxQuery.execute();

            return this;
        }
    });

    sx.classes.DadataSuggestHandler = sx.classes.Component.extend({

        construct: function (DadataSuggest, opts)
        {
            var self = this;
            opts = opts || {};
            this._DadataSuggest = DadataSuggest;
            this.applyParentMethod(sx.classes.Component, 'construct', [opts]); // TODO: make a workaround for magic parent calling
        },

    });

})(sx, sx.$, sx._);