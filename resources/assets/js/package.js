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
    formData: {
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
      this.$refs.listing.dataManager([{
        field: "updated_at",
        direction: "desc"
      }]);
      this.clearForm();
    },
    edit(data) {
      this.formData.variable = data.variable;
      this.formData.condition = data.condition;
      this.formData.status = data.status;
      this.formData.id = data.id;
      this.action = "Edit";
      this.$refs.modal.show();
    },
    validateForm() {
      if (this.formData.variable === "" || this.formData.variable === null) {
        this.submitted = false;
        this.addError.variable = ["The variable field is required"];
        return false;
      }
      if (this.formData.condition === "" || this.formData.condition === null) {
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
          ProcessMaker.apiClient.post("business_rules", this.formData)
            .then((response) => {
              ProcessMaker.alert("Successfully added ", "success");
              this.reload()
            })
            .catch((error) => {
              if (error.response && error.response.status === 422) {
                this.addError = error.response.data.errors;
              }
            })
            .finally(() => {
              this.submitted = false;
              this.$refs.modal.hide();
            });
        } else {
          ProcessMaker.apiClient.patch(`business_rules/${this.formData.id}`, this.formData)
            .then((response) => {
              ProcessMaker.alert("Successfully updated ", "success");
              this.reload()
            })
            .catch((error) => {
              if (error.response && error.response.status === 422) {
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
      this.formData.variable = "";
      this.formData.condition = "";
      this.formData.status = "ENABLED";
    }
  }
});
