define([
    'underscore',
    'oroui/js/messenger',
    'orotranslation/js/translator',
    'oro/datagrid/action/mass-action',
    'oroui/js/messenger'
], function (_, messenger, __, MassAction, messanger) {
    'use strict';

    var CreateShipmentAction;

    /**
     * @export  oro/datagrid/action/createshipment-action
     * @class   oro.datagrid.action.CreateShipmentAction
     * @extends oro.datagrid.action.MassAction
     */
    CreateShipmentAction = MassAction.extend({

        executeConfiguredAction: function () {
            switch (this.frontend_handle) {
                case 'ajax':
                    this._handleAjax();
                    break;
                case 'redirect':
                    this._handleRedirect();
                    break;
                case 'createshipment':
                    this._handleCreateShipment();
                    break;
                default:
                    this._handleWidget();
            }
        },

        _handleCreateShipment: function () {
            if (this.dispatched) {
                return;
            }

            this._doAjaxRequest();
        },
        getActionParameters: function () {
            var selectionState = this.datagrid.getSelectionState();
            var collection = this.datagrid.collection;

            var params = {
                inset: selectionState.inset ? 1 : 0,
                values: selectionState.selectedIds.join(','),
                orderId: collection.first().attributes.orderId || null,
                qty: this.getQty()
            };

            params = collection.processFiltersParams(params, null, 'filters');

            return params;
        },

        getQty: function () {
            var selectionState = this.datagrid.getSelectionState();
            var collection = this.datagrid.collection;
            var key;
            var qty = {};
            var items = selectionState.selectedIds.length > 0 ? selectionState.selectedIds : collection.models;

            for (key in items) {
                var data = collection.models[key];
                if (data.attributes.gtyShipping) {
                    this.checkQty(data.attributes.gtyShipping, data.attributes.qty);
                    qty[data.id] = data.attributes.gtyShipping;
                }
            }

            return qty;
        },

        checkQty: function (enteredQty, productQty) {
            if (enteredQty > productQty) {
                var error =__('Entered value of qty must be less or equal qty of product!');
                messenger.notificationFlashMessage('error', error);
                throw Error(error);
            }
        }
    });

    return CreateShipmentAction;
});
