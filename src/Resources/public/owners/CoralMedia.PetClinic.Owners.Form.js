Ext.ns("CoralMedia.PetClinic.Owners"),CoralMedia.PetClinic.Owners.Form=Ext.extend(Hydra.form.FormPanel,{defaults:{anchor:"-20",msgTarget:"side",xtype:"textfield",allowBlank:!1},padding:"10",action:null,parentGrid:null,jsonData:null,initComponent:function(){let e=this;e.buttons=this.configureDefaultButtons(),e.items=this.configureFormFields(),CoralMedia.PetClinic.Owners.Form.superclass.initComponent.call(this),"update"===e.action&&(e.jsonData=e.parentGrid.getSelectionModel().getSelected().json,e.getForm().loadRecord(e.parentGrid.getSelectionModel().getSelected())),e.getForm().on("beforeaction",(function(e,t){if("jsonSubmit"===t.type&&!Ext.isArray(e.getValues().roles)){let n=e.getValues();t.overwriteParams={roles:[n.roles]}}}),this)},configureFormFields:function(){return this.items||[{xtype:"textfield",name:"firstName",fieldLabel:"Firstname"},{xtype:"textfield",name:"lastName",fieldLabel:"Lastname"},{xtype:"textfield",name:"telephone",fieldLabel:"Telephone"}]}});