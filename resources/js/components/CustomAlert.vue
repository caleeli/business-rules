<template>
  <div class="alert" :class="variant" role="alert">{{ label }}</div>
</template>

<script>
import { get } from "lodash";

export default {
  props: ["name", "label", "color", "validationData"],
  computed: {
    variant() {
      // the variable value using dot notation
      const color = get(this.validationData, this.color);
      return `alert-${color}`;
    }
  }
};
</script>

<style scoped>

</style>
