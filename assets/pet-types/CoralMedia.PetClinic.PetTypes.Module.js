Ext.ns('CoralMedia.PetClinic.PetTypes');
CoralMedia.PetClinic.PetTypes.Module = Ext.extend(Ext.app.Module, {
    id: 'pet-clinic-pet-types',
    type: 'coralmediapetclinic/pet-types',
    requires: [
        'app/coralmediapetclinic/pet-types/CoralMedia.PetClinic.PetTypes.Grid',
        'app/coralmediapetclinic/pet-types/CoralMedia.PetClinic.PetTypes.Form'
    ],
    addons: [
        'hydra-api',
    ],

    actions: null,
    defaults: {winHeight: 600, winWidth: 800},

    win: null,

    createWindow: function () {
        let desktop = this.app.getDesktop();
        let self = this;
        self.win = desktop.getWindow(self.id);

        let h = parseInt(desktop.getWinHeight() * 0.9);
        let w = parseInt(desktop.getWinWidth() * 0.7);
        if (h > self.defaults.winHeight) {
            h = self.defaults.winHeight;
        }
        if (w > self.defaults.winWidth) {
            w = self.defaults.winWidth;
        }

        let winWidth = w;
        let winHeight = h;

        if (!self.win) {
            self.win = desktop.createWindow({
                animCollapse: false,
                cls: 'qo-win',
                constrainHeader: true,
                id: self.id,
                height: winHeight,
                iconCls: 'grid-icon',
                items: [
                    new CoralMedia.PetClinic.PetTypes.Grid({ownerModule: self})
                ],
                layout: 'fit',
                shim: false,
                taskbuttonTooltip: '<b>Pet Types</b><br />Pet Types',
                title: 'Pet Types',
                width: winWidth
            });
        }

        this.win.show();
    },

    showMask: function (msg) {
        this.win.body.mask(msg + '...', 'x-mask-loading');
    },

    hideMask: function () {
        this.win.body.unmask();
    }
});