<template>
    <div class="data-table">
        <vuetable :dataManager="dataManager" :sortOrder="sortOrder" :css="css" :api-mode="false"
                  @vuetable:pagination-data="onPaginationData" :fields="fields" :data="data" data-path="data"
                  pagination-path="meta">
            <template slot="actions" slot-scope="props">
                <div class="actions">
                    <div class="popout">
                        <b-btn variant="action" @click="onAction('edit-item', props.rowData, props.rowIndex)"
                               v-b-tooltip.hover data-action="Edit" data-toggle="modal" data-target="#businessRuleModal"
                               title="Edit"><i class="fas fa-edit"></i></b-btn>
                        <b-btn variant="action" @click="onAction('remove-item', props.rowData, props.rowIndex)"
                               v-b-tooltip.hover title="Remove"><i class="fas fa-trash-alt"></i></b-btn>
                    </div>
                </div>
            </template>
        </vuetable>
        <pagination single="Business Rule" plural="Business Rules" :perPageSelectEnabled="true"
                    @changePerPage="changePerPage"
                    @vuetable-pagination:change-page="onPageChange" ref="pagination"></pagination>
    </div>
</template>


<script>
  import datatableMixin from "./common/mixins/datatable";

  export default {
    mixins: [datatableMixin],
    props: ["filter"],

    data() {
      return {
        orderBy: "variable",
        // Our listing of business Rules
        sortOrder: [
          {
            field: "variable",
            sortField: "variable",
            direction: "asc"
          }
        ],
        fields: [
          {
            title: "Variable",
            name: "variable",
            sortField: "variable"
          },
          {
            title: "Condition",
            name: "condition",
            sortField: "condition"
          },
          {
            title: "Status",
            name: "status",
            sortField: "status"
          },
          {
            title: "Created at",
            name: "created_at",
            sortField: "created_at"
          },
          {
            name: "__slot:actions",
            title: ""
          }
        ]
      };
    },
    methods: {
      formatStatus(status) {
        status = status.toLowerCase();
        let bubbleColor = {
          active: "text-success",
          inactive: "text-danger",
          draft: "text-warning",
          archived: "text-info"
        };
        return (
          '<i class="fas fa-circle ' +
          bubbleColor[status] +
          ' small"></i> ' +
          status.charAt(0).toUpperCase() +
          status.slice(1)
        );
      },
      onAction(action, data, index) {
        switch (action) {
          case "edit-item":
            this.$parent.edit(data);
            break;
          case "remove-item":
            ProcessMaker.confirmModal(
              "Caution!",
              "Are you sure to inactive the Business Rule '" + data.variable + "'?",
              "",
              () => {
                ProcessMaker.apiClient
                  .delete("business_rules/" + data.id)
                  .then(response => {
                    ProcessMaker.alert("business Rule " + data.variable + " has been deleted", "warning");
                    this.$emit("reload");
                  });
              }
            );
            break;
        }
      },
      fetch() {
        this.loading = true;
        // Load from our api client
        ProcessMaker.apiClient
          .get(
            "business_rules?page=" +
            this.page +
            "&per_page=" +
            this.perPage +
            "&filter=" +
            this.filter +
            "&order_by=" +
            this.orderBy +
            "&order_direction=" +
            this.orderDirection
          )
          .then(response => {
            this.data = this.transform(response.data);
            this.loading = false;
          });
      }
    }
  };
</script>

<style lang="scss" scoped>
</style>
