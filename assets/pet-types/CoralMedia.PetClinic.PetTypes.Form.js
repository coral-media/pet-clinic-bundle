Ext.ns('CoralMedia.PetClinic.PetTypes');
CoralMedia.PetClinic.PetTypes.Form = Ext.extend(Hydra.form.FormPanel,{
    defaults:{
        anchor: '-20',
        msgTarget: 'side',
        xtype: 'textfield',
        allowBlank: false
    },

    padding: '10',
    action: null,
    /**
     * @var Ext.grid.GridPanel
     */
    parentGrid: null,
    jsonData: null,

    initComponent:function ()
    {
        let self = this;
        self.buttons = this.configureDefaultButtons();
        self.items = this.configureFormFields();
        CoralMedia.PetClinic.PetTypes.Form.superclass.initComponent.call(this);
        if (self.action === 'update') {
            self.jsonData  = self.parentGrid.getSelectionModel().getSelected().json;
            self.getForm().loadRecord(self.parentGrid.getSelectionModel().getSelected());
        }
        self.getForm().on('beforeaction', function (form, action) {
            if(action.type === 'jsonSubmit' && !Ext.isArray(form.getValues().roles)) {
                let params = form.getValues();
                action.overwriteParams = {roles: [params.roles]};
            }
        }, this)
    },

    configureFormFields: function () {
        let self = this;
        return self.items||([
            {
                xtype: 'textfield',
                name: 'name',
                fieldLabel: 'Name'
            }
        ])
    }
});