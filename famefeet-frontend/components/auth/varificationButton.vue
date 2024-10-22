<template>
  <div>
    <button @click="startTimer" :disabled="timerRunning" ref="startBtn">
      Start Timer
    </button>
    <p v-if="timerRunning">Timer Running for {{ minutes }}:{{ seconds }}</p>
  </div>
</template>

<script>
export default {
  props: ["loading"],
  data() {
    return {
      timerRunning: false,
      timeLeft: 0,
      timerIntervalId: null,
    };
  },
  computed: {
    minutes() {
      return Math.floor(this.timeLeft / 60)
        .toString()
        .padStart(2, "0");
    },
    seconds() {
      return (this.timeLeft % 60).toString().padStart(2, "0");
    },
  },
  methods: {
    startTimer() {
      // Disable the button and set the timerRunning flag
      this.timerRunning = true;
      this.$refs.startBtn.disabled = true;

      // Set the timer to 2 minutes (120 seconds)
      const timerDuration = 120;

      // Start the timer
      const startTime = Date.now();
      this.timerIntervalId = setInterval(() => {
        const elapsedTime = Date.now() - startTime;
        this.timeLeft = Math.ceil(timerDuration - elapsedTime / 1000);
        if (elapsedTime >= timerDuration * 1000) {
          // Stop the timer and enable the button
          clearInterval(this.timerIntervalId);
          this.timerRunning = false;
          this.timeLeft = 0;
          this.$refs.startBtn.disabled = false;

          // Save the timeLeft value to local storage
          localStorage.setItem("timeLeft", this.timeLeft);
        }
      }, 1000);
    },
    saveTimerData() {
      // Save the timer data to local storage before the page is unloaded
      if (this.timerRunning) {
        localStorage.setItem("timerRunning", true);
        localStorage.setItem("timeLeft", this.timeLeft);
      } else {
        localStorage.removeItem("timerRunning");
        localStorage.removeItem("timeLeft");
      }
    },
  },
  mounted() {
    // Get the saved timer data from local storage and resume the timer if applicable
    const savedTimerRunning = localStorage.getItem("timerRunning");
    const savedTimeLeft = localStorage.getItem("timeLeft");
    if (savedTimerRunning && savedTimeLeft) {
      this.timeLeft = savedTimeLeft;
      this.timerRunning = true;

      // Restart the timer with the saved timeLeft value
      this.$refs.startBtn.disabled = true;
      const timerDuration = 120;
      const startTime = Date.now() - (timerDuration - this.timeLeft) * 1000;
      this.timerIntervalId = setInterval(() => {
        const elapsedTime = Date.now() - startTime;
        this.timeLeft = Math.ceil(timerDuration - elapsedTime / 1000);
        if (elapsedTime >= timerDuration * 1000) {
          clearInterval(this.timerIntervalId);
          this.timerRunning = false;
          this.timeLeft = 0;
          this.$refs.startBtn.disabled = false;
          localStorage.removeItem("timerRunning");
          localStorage.removeItem("timeLeft");
        }
      }, 1000);
    }

    // Add an event listener for the beforeunload event to save the timer data to local storage
    window.addEventListener("beforeunload", this.saveTimerData);
  },
  beforeDestroy() {
    // Remove the event listener for the beforeunload event
    window.removeEventListener("beforeunload", this.saveTimerData);
  },
};
</script>
