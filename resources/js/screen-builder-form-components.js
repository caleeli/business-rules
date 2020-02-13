import CustomAlert from './components/CustomAlert.vue';

Vue.component("CustomAlert", CustomAlert);

window.ProcessMaker.EventBus.$on('screen-builder-init', (manager) => {
    const control = {
        editorComponent: CustomAlert,
        editorBinding: 'CustomAlert',
        rendererComponent: CustomAlert,
        rendererBinding: 'CustomAlert',
        control: {
            label: "Custom Alert",
            component: 'CustomAlert',
            "editor-component": "CustomAlert",
            config: {
                label: "Custom Alert",
                placeholder: "",
                validation: '',
                icon: 'far fa-comment-alt',
                helper: null,
            },
            inspector: [
                {
                    type: "FormInput",
                    field: "label",
                    config: {
                        label: "Field Label",
                        helper: "The label describes the fields name"
                    }
                },
                {
                    type: "FormInput",
                    field: "color",
                    config: {
                        label: "Color variable",
                        helper: "The variable used to select the color of the control"
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
