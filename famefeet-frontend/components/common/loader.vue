<template>
  <div class="loader_main">
    <div class="loader"></div>
  </div>
</template>

<script>
export default {};
</script>

<style lang="css" scoped>
.loader_main {
  /*width: 100vw;*/
  height: calc(100vh - 69px);
  display: flex;
  justify-content: center;
  align-items: center;
}

.loader {
  border: 12px solid lightgrey;
  border-radius: 50%;
  border-top: 12px solid var(--primary);
  width: 60px;
  height: 60px;
  -webkit-animation: spin 2s linear infinite;
  /* Safari */
  animation: spin 2s linear infinite;
}

/* Safari */
@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
  }
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>
