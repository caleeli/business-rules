import Vue from "vue";
import BootstrapVue from "bootstrap-vue";
import VModal from "vue-js-modal";
import SampleListing from "./components/SamplesListing";

Vue.use(VModal);
Vue.use(BootstrapVue);

new Vue({
  el: "#app-business-rules",
  data: {
    filter: "",
    sample: {
      id: "",
      variable: "",
      condition: "",
      status: "ENABLED"
    },
    addError: {
      name: null,
      variable: null,
      status: null
    },
    action: "Add"
  },
  components: {SampleListing},
  methods: {
    reload() {
      this.clear();
      this.$refs.listing.dataManager([{
        field: "updated_at",
        direction: "desc"
      }]);
    },
    edit(data) {
      this.sample.variable = data.variable;
      this.sample.condition = data.condition;
      this.sample.status = data.status;
      this.sample.id = data.id;
      this.action = "Edit";
      this.$refs.modal.show();
    },
    validateForm() {
      if (this.sample.variable === "" || this.sample.variable === null) {
        this.submitted = false;
        this.addError.variable = ["The variable field is required"];
        return false;
      }
      if (this.sample.condition === "" || this.sample.condition === null) {
        this.submitted = false;
        this.addError.condition = ["The condition field is required"];
        return false;
      }
      return true;
    },
    onSubmit(evt) {
      evt.preventDefault();
      this.submitted = true;
      if (this.validateForm()) {
        this.addError.name = null;
        if (this.action === "Add") {
          ProcessMaker.apiClient.post("business_rules", this.sample)
            .then((response) => {
              ProcessMaker.alert("Successfully added ", "success");
              this.reload();
            })
            .catch((error) => {
              if (error.response.status === 422) {
                this.addError = error.response.data.errors;
              }
            })
            .finally(() => {
              this.submitted = false;
              this.$refs.modal.hide();
            });
        } else {
          ProcessMaker.apiClient.patch(`business_rules/${this.sample.id}`, {
            name: this.sample.name,
            status: this.sample.status
          })
            .then((response) => {
              ProcessMaker.alert("Successfully updated ", "success");
              this.reload();
            })
            .catch((error) => {
              if (error.response.status === 422) {
                this.addError = error.response.data.errors;
              }
            })
            .finally(() => {
              this.submitted = false;
              this.$refs.modal.hide();
              this.action = "create";
            });
        }
      }
    },
    clearForm() {
      this.action = "Add";
      this.id = "";
      this.addError.name = null;
      this.sample.variable = "";
      this.sample.condition = "";
      this.sample.status = "ENABLED";
    }
  }
});
