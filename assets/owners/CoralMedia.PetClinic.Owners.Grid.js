Ext.ns('CoralMedia.PetClinic.Owners');

CoralMedia.PetClinic.Owners.Grid = Ext.extend(Hydra.grid.GridPanel, {
    sm: new Ext.grid.RowSelectionModel({singleSelect: true}),

    ownerModule: null,

    initComponent: function () {
        let self = this;
        self.resource = '/api/pet-clinic/owners';
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
                {header: 'Firstname', sortable: true, dataIndex: 'firstName', type: 'string'},
                {header: 'Lastname', sortable: true, dataIndex: 'lastName', type: 'string'},
                {header: 'Telephone', sortable: true, dataIndex: 'telephone', type: 'string'},
            ]
        });

        CoralMedia.PetClinic.Owners.Grid.superclass.initComponent.call(this);
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
                fields: ['id', 'firstName', 'lastName', 'telephone'],
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
                action.slice(1) + ' Owner',
            items: [
                new CoralMedia.PetClinic.Owners.Form({
                    parentGrid: this,
                    action: action
                })
            ]
        }, options));
    }
});
