<template>
  <div>
    <label v-if="!isShowLable" for="input-id">Price:
      <span v-if="isRequired" style="font-size: 8px;color: red;"><b-icon icon="asterisk" class="mb-2" ></b-icon></span>
    </label>

    <b-form-input
      id="input-title"
      class="Famefeet-input-field"
      :disabled="status === 'Unlocked'"
      v-model="displayValue"
      @blur="isInputActive = false"
      @focus="isInputActive = true"
      v-only-number
    ></b-form-input>
  </div>
</template>

<script>
export default {
  name: "input-price",
  props: ["value", "status", "isShowLable","isRequired"],

  data() {
    return {
      isInputActive: false,
    };
  },
  computed: {
    displayValue: {
      get: function () {
        if (this.isInputActive) {
          // Cursor is inside the input field. unformat display value for user
          return this.value ? this.value.toString(): "";
        } else {
          // User is not modifying now. Format display value for user interface
          return (
            "$ " +
            (this.value ? this.value.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,"): "")
          );
        }
      },
      set: function (modifiedValue) {
        // Recalculate value after ignoring "$" and "," in user input
        let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ""));
        // Ensure that it is not NaN
        if (isNaN(newValue)) {
          newValue = 0;
        }
        // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
        // $emit the event so that parent component gets it
        this.$emit("input", newValue);
      },
    },
  },
  methods: {},
  directives: {
    "only-number": {
      bind: function (el) {
        el.addEventListener("input", function (event) {
          event.target.value = event.target.value.replace(/[^\d\.]/g, "");
        });
      },
    },
  },
};
</script>

<style lang="css" scoped></style>
