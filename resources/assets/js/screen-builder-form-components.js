import CustomPopup from './components/CustomPopup.vue';

Vue.component("CustomPopup", CustomPopup);

window.ProcessMaker.EventBus.$on('screen-builder-init', (manager) => {
    const control = {
        editorComponent: CustomPopup,
        editorBinding: 'CustomPopup',
        rendererComponent: CustomPopup,
        rendererBinding: 'CustomPopup',
        control: {
            label: "Custom Popup",
            component: 'CustomPopup',
            "editor-component": "CustomPopup",
            config: {
                label: "Custom Popup",
                placeholder: "",
                validation: '',
                icon: 'far fa-comment-alt',
                collectionConfig: {
                    labelField: '',
                    valueField: 'id',
                    collectionId: null,
                    query: '',
                    options: [{
                        value: 'new',
                        content: 'New Option'
                    }]
                },
                helper: null,
            },
            inspector: [{
                type: "FormInput",
                field: "name",
                config: {
                    label: "Field Name",
                    helper: "The data name for this field"
                    }
                },
                {
                    type: "FormInput",
                    field: "label",
                    config: {
                        label: "Field Label",
                        helper: "The label describes the fields name"
                    }
                },
            ]
        },
    };
    manager.addControl(
        control.control,
        control.rendererComponent,
        control.rendererBinding,
        control.builderComponent,
        control.builderBinding
    );
});
