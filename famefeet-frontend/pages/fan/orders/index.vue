<template>
  <div>
    <FanOrders />
  </div>
</template>

<script>
import FanOrders from "@/components/fan/orders/order";
export default {
  layout: "fan",
  name: "orders",
  components: { FanOrders },

  data() {
    return {};
  },
};
</script>

<style></style>
