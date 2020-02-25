
/**
 * Initialize the connector.
 *
 * Register the nodes it contains.
 */
window.ProcessMaker.EventBus.$on('modeler-init', ({ registerNode, registerBpmnExtension, registerInspectorExtension }) => {
    /* Register basic node types */
    const taskComponent = ProcessMaker.nodeTypes[2];
    const accordions = taskComponent.inspectorConfig[0].items;
    const TaskAssignment = accordions[1].items[0];
    console.log(TaskAssignment);
    const TaskAssignmentEx = Vue.component("TaskAssignment", {
        extends: Vue.extend(TaskAssignment),
        data() {
            return {
                assignmentTypes: [
                    {
                        value: "requester",
                        label: "Requester!!!!"
                    },
                    {
                        value: "user_group",
                        label: "Users / Groups!!!"
                    },
                    {
                        value: "previous_task_assignee",
                        label: "Previous Task Assignee"
                    },
                    {
                        value: "user_by_id",
                        label: "By User ID"
                    },
                    {
                        value: "self_service",
                        label: "Self Service"
                    },
                ],
            };
        }
    });
});
