Ext.ns('CoralMedia.PetClinic.PetTypes');

CoralMedia.PetClinic.PetTypes.Grid = Ext.extend(Hydra.grid.GridPanel, {
    sm: new Ext.grid.RowSelectionModel({singleSelect: true}),

    ownerModule: null,

    initComponent: function () {
        let self = this;
        self.resource = '/api/pet-clinic/pet_types';
        self.store = self.configureStore();
        self.tbar = self.configureToolBar();
        self.bbar = self.configureBottomBar();

        self.cm = new Ext.grid.ColumnModel({
            defaults: {
                width: 120,
                sortable: true
            },
            columns: [
                new Ext.grid.RowNumberer(),
                {header: 'Name', sortable: true, dataIndex: 'name', type: 'string'},
            ]
        });

        CoralMedia.PetClinic.PetTypes.Grid.superclass.initComponent.call(this);
    },

    configureStore: function () {
        let self = this;
        return self.store || (
            new Ext.data.JsonStore({
                restful: true,
                proxy: new Ext.data.HttpProxy({
                    url: self.resource,
                    defaultHeaders: {'Content-Type': 'application/ld+json'}
                }),
                idProperty: 'id',
                totalProperty: 'hydra:totalItems',
                root: 'hydra:member',
                fields: ['id', 'name'],
                baseParams: {
                    page: 1
                },
                paramNames: {
                    page: 'page'
                }
            })
        );
    },

    setFormContainer: function (action, options) {
        let self = this;
        self.formContainer = new Ext.Window(Ext.apply({
            layout: 'fit',
            height: 320,
            width: 640,
            resizable: false,
            modal: true,
            title: action.charAt(0).toUpperCase() +
                action.slice(1) + ' Pet Type',
            items: [
                new CoralMedia.PetClinic.PetTypes.Form({
                    parentGrid: this,
                    action: action
                })
            ]
        }, options));
    }
});
